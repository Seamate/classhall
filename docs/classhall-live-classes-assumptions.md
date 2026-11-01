# Assumptions

* This repository is `wp-content` only.
* Active theme is assumed to be `kleo-child` based on current files, but database confirmation is unavailable.
* WooCommerce, Paystack, WooCommerce Subscriptions, Sensei LMS, and Ultimate Member are installed but runtime activation state is unavailable.
* Sensei subjects are represented primarily through courses and `course-category`; the adapter falls back to predefined subject keys.
* Production uses MySQL/MariaDB compatible with WordPress `dbDelta()`.
* NGN money should be stored in kobo.
* Full payment success is represented by WooCommerce payment/order status hooks.

