# Home lesson timetable and emails

## Deployment

Upload the updated Kleo child theme, including `functions.php`,
`inc/home-lesson-schedule.php`, `template-parts/emails/home-lesson.php`, and
`template-parts/classhall-summer-banner.php`. Clear the homepage cache.
Also include `inc/home-lesson-renewals.php`,
`template-parts/emails/home-lesson-renewal.php`, and
`assets/css/home-lesson-renewals.css` for manual renewal.
WooCommerce and its bundled Action Scheduler must be active.

## Admin settings

Open **WooCommerce > Home Lessons** to change the Google Meet URL.
The initial URL is `https://meet.google.com/kig-bzkt-cnh`.
Only HTTPS Google Meet meeting URLs are accepted. Changes require the
`manage_woocommerce` capability and a valid WordPress settings nonce.

The email join button contains a private enrolment link, not a fixed meeting
URL. It checks paid status, item refunds and expiry before redirecting to the
current Google Meet URL. Changing the admin setting therefore updates the
destination of previously sent emails too. Do not share private enrolment links.
An email already delivered cannot have its displayed timetable changed.

Use **Sync existing paid enrolments** after deployment to enrol recent paid
orders into this timetable. It processes orders in batches of 25. Only orders
still inside their original paid month receive a confirmation and reminders.
Repeated syncs do not resend successful confirmations or duplicate pending jobs.

## Enrolment and email behaviour

- Successful payment or a paid processing/completed status registers each home
  lesson order item. An unpaid account registration does not grant meeting access.
- Initial access lasts one calendar month from payment, clamped at month-end (January 31
  expires February 28, or February 29 in a leap year). This is not automatic renewal.
- Confirmation is queued immediately and sent to the order's billing email,
  including for guest checkout. It contains the selected class, timetable,
  enrolment dates, Nigeria timezone and joining button.
- Reminders are scheduled individually at 24 hours and 1 hour before
  each session. There is no hourly scan of the order database.
- A reminder whose scheduled time was already past at enrolment is not queued.
  The confirmation still includes the full timetable.
- Cancelled/unpaid orders, fully refunded items and expired enrolments are checked
  again before every send and every use of the private joining link.
- Hourly execution can deliver reminders up to one hour late. Reminders over one
  hour late are skipped. No
  reminder is sent after its session begins. This avoids bursts of stale emails.
- Failed `wp_mail` calls receive up to three retries one minute apart. Persistent
  failures add an order note. A successful `wp_mail` call means accepted by the
  mail transport, not guaranteed inbox delivery; use the site's working SMTP service.
- The previous home lesson notification handler has been replaced to avoid
  duplicate payment emails. Normal WooCommerce order emails still run.

## Timetable (Africa/Lagos, WAT / UTC+1)

| Classes | Day | Time | Subject |
| --- | --- | --- | --- |
| Primary 1 & 2 | Monday | 4:30-5:30 pm | Mathematics |
| Primary 1 & 2 | Wednesday | 4:30-5:30 pm | English |
| Primary 1 & 2 | Thursday | 4:30-5:30 pm | Other subjects |
| Primary 3 & 4 | Monday | 5:30-6:30 pm | English |
| Primary 3 & 4 | Tuesday | 4:30-5:30 pm | Mathematics |
| Primary 3 & 4 | Thursday | 5:30-6:30 pm | Other subjects |
| Primary 5 & 6 | Tuesday | 5:30-6:30 pm | English |
| Primary 5 & 6 | Wednesday | 5:30-6:30 pm | Other subjects |
| Primary 5 & 6 | Friday | 4:30-5:30 pm | Mathematics |

## Manual renewal

Parents can open **My Account > Home Lessons** to see their paid enrolments,
status, latest expiry and **Renew Home Lessons** button. The account view uses
the parent's own WooCommerce orders and is paginated. Guest purchases can be
renewed using the private link in the enrolment or renewal email. Guest renewal
requires the original billing email; an authenticated original order owner can
use their updated billing email. No WooCommerce Subscriptions extension or
automatic billing is used.

Renewal opens checkout for the same Primary class at the current home lessons
monthly price. Nothing is extended until the renewal order is paid. An early
renewal starts at the latest valid paid expiry; a late renewal starts at the new
payment timestamp. Multiple paid renewals add consecutive months. Duplicate
payment callbacks do not add months again. Concurrent payment processing is
serialised per enrolment.

Every renewal has its own order and access period, leaving the original payment
history unchanged. Cancelling or fully refunding a period revokes that period;
other already-paid periods keep their original dates. Original joining links can
resolve to an active renewed period, so parents can continue using saved emails.

Renewal notices are queued three days before expiry and at expiry. A notice is
suppressed if a later paid renewal already covers the enrolment. Successful
renewal emails include the new dates and timetable. Future class reminders are
scheduled only for the newly paid period. Failed-payment, pending, and cancelled
renewal orders never extend access. Hourly cron remains unchanged.

After deployment, use **Sync existing paid enrolments** to schedule expiry
notices for recent active orders created before this feature. Older expired
orders remain renewable from My Account. No historical expiry-email campaign
is sent automatically.

## Server scheduling

Retain the existing hourly hosting cron. For example,
with WP-CLI available, substitute the real WordPress path and executable paths:

```cron
0 * * * * /usr/local/bin/wp --path=/absolute/path/to/wordpress cron event run --due-now --quiet
```

Use the site owner's operating-system account. If the server already has a cron
task for this WordPress installation, keep it instead of adding a
duplicate. Disable visit-triggered WP-Cron only after confirming the server task
works. This repository change does not configure the live hosting scheduler.

Monitor **WooCommerce > Status > Scheduled Actions**, filtering by group
`classhall-home-lessons`. Confirm that the hourly cron processes due actions.
Action Scheduler retains its own internal queue interval; this change does not
alter other WooCommerce jobs. Exact reminder delivery times are not guaranteed:
for a 4:30 pm lesson, an hourly run at 4 pm delivers the 1-hour reminder 30 minutes
before class. Email subjects use neutral reminder wording and the body shows the
exact class time. Existing queued 10-minute reminders are ignored. Failed-email
retries and confirmations can also wait until the next hourly run. Heavy queues
or a slow mail provider can further delay delivery.

## Verification

Run `php tests/home-lesson-schedule-test.php` locally for isolated tests. No real
emails, network calls or database writes occur in those tests. On staging, complete
a test order for each class group, check its confirmation, change the admin Meet
URL and confirm the original email button resolves to it. Check pending reminder
times, a cancelled/refunded order and an expired enrolment. Test real inbox delivery
and actual server cron execution separately.
