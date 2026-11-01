# Classhall Live Classes Testing Guide

Automated checks to run in this repository:

```bash
php -l plugins/classhall-live-classes/classhall-live-classes.php
find plugins/classhall-live-classes/src -name "*.php" -print0 | xargs -0 -n1 php -l
```

If a WordPress test suite is available, add PHPUnit coverage for:

* Plugin activation and migrations.
* Teacher approval capabilities.
* Unapproved teacher class creation restriction.
* WooCommerce product association.
* Booking creation after payment.
* Booking idempotency.
* Capacity enforcement and one-on-one last-seat behavior.
* Cancelled/unapproved checkout prevention.
* Meeting-link authorization window.
* Review eligibility and duplicate review prevention.
* Earnings calculation and refund reversal.
* REST permission checks.
* Nonce failures and output escaping.

Manual QA checklist:

* Desktop, tablet, and mobile layouts.
* Logged-out visitor browsing classes.
* Student booking, successful Paystack payment, failed payment, and refund.
* Approved teacher dashboard.
* Unapproved teacher restriction.
* Administrator approval/rejection/suspension.
* Simultaneous last-seat booking in staging.
* Expired, cancelled, and fully booked classes.
* Meeting links absent from public HTML and REST responses.

