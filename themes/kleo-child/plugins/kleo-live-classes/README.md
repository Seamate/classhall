# Kleo Live Classes

This plugin adds a paid live-class workflow for teachers and students on WordPress.

## What it does

- Creates a `Live Classes` custom post type.
- Lets teachers create live classes from the frontend with the `[klc_teacher_dashboard]` shortcode.
- Creates a hidden WooCommerce product for each live class.
- Uses your existing WooCommerce checkout and Paystack gateway for payments.
- Enrols students automatically after a paid order reaches `processing` or `completed`.
- Tracks platform commission and teacher earnings on each order item.
- Shows students their paid class schedule with `[klc_student_schedule]`.
- Shows a public class catalogue with `[klc_live_classes]`.

## Install

1. Copy the `kleo-live-classes` folder into `wp-content/plugins/`.
2. Activate `Kleo Live Classes` in WordPress.
3. Go to `Settings > Live Classes`.
4. Set the teacher role slug and platform fee percentage.

## Shortcodes

- `[klc_teacher_dashboard]`: teacher create/edit screen.
- `[klc_live_classes]`: public list of available live classes.
- `[klc_student_schedule]`: logged-in student schedule and join links.

## Notes

- This version uses WooCommerce + Paystack for checkout, but it does not yet send automatic teacher payouts through Paystack Transfer APIs.
- Teacher revenue is tracked per order item so you can use it for reconciliation or build an automated payout step next.
- If you want Sensei course enrolment to happen automatically after payment, that can be added in a follow-up once you confirm the exact Sensei enrolment method used on your site.
