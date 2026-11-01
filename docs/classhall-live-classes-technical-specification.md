# Classhall Live Classes Technical Specification

## 1. Product Overview
Classhall Live Classes extends the existing Classhall curriculum platform with paid teacher-led live classes connected to subjects, class levels, optional Sensei courses, and examination categories. It must remain an extension of subject learning, not a generic tutoring marketplace.

Repository inspection found this checkout contains only `wp-content`, not a full WordPress installation. Available directories are `plugins`, `themes`, `.git`, and `advanced-cache.php`; `wp-admin`, `wp-includes`, `wp-config.php`, and database access are unavailable. Existing relevant plugins include WooCommerce, WooCommerce Subscriptions, Paystack for WooCommerce, Sensei LMS under `plugins/woothemes-sensei/plugins/sensei-lms`, Ultimate Member, Breeze, Classhall Forum, Classhall Light Pages, Classhall Content Formatter, and a small legacy `kleo-live-classes` plugin. The active child theme appears to be `themes/kleo-child`, but active theme status cannot be confirmed from the database.

The implementation is a new self-contained plugin: `plugins/classhall-live-classes`. It integrates through WordPress hooks, WooCommerce CRUD APIs, Sensei post types/taxonomies, REST routes, shortcodes, and custom database tables. It does not modify the active theme, Sensei, WooCommerce, Paystack, or WordPress core.

## 2. Phase 1 Scope
Phase 1 includes plugin foundation, migrations, capabilities, teacher profiles/applications, class management, public class/teacher browsing, WooCommerce product association, paid booking confirmation, meeting-link access control, manual completion, reviews, ranking, social sharing, earnings and manual payouts, admin settings, notifications hooks, REST endpoints, WP-CLI maintenance commands, seed tooling, documentation, and test scaffolding.

## 3. Explicit Out-of-Scope Features
Native video conferencing, automatic Google Meet/Zoom/Teams creation, Google Calendar API integration, automatic Paystack transfers, direct student-teacher messaging, direct file sharing, guardian consent workflows, mobile apps, and full LMS lesson replacement are out of scope.

## 4. User Roles
The plugin uses existing WordPress users. Administrators retain management rights. Approved teachers receive live-class capabilities. Students are authenticated WordPress/WooCommerce customers with bookings. Sensei's existing `teacher` role is detected but not blindly trusted for live-class publishing until a Classhall Live teacher profile is approved.

## 5. Capabilities and Permissions
Capabilities are added on activation and removed on uninstall only if plugin data removal is enabled. Administrators receive all live-class capabilities. Approved teachers receive `classhall_manage_live_profile`, `classhall_create_live_classes`, `classhall_edit_own_live_classes`, `classhall_view_own_live_bookings`, and `classhall_view_own_live_earnings`.

Unauthenticated users can browse public approved classes and teacher profiles only. Meeting links, student lists, earnings, internal notes, documents, and moderation data require authentication and ownership/capability checks.

## 6. Teacher Application and Approval Workflow
A logged-in user applies through `[classhall_live_teacher_application]`. The profile starts as `draft` or `submitted`. Administrators review applications in the Live Classes admin area and may set `under_review`, `approved`, `rejected`, or `suspended`, mark verification, and add internal notes. Approval grants live-class teacher capabilities to that user.

## 7. Live-Class Creation and Approval Workflow
Approved teachers create classes through `[classhall_live_teacher_dashboard]`. Classes are stored as `classhall_live_class` posts for friendly URLs and editorial fields, with transactional/scheduling fields mirrored in `{prefix}classhall_live_classes`. Drafts are private to the teacher. Submitted classes require admin approval before becoming bookable. Approved classes create or sync a hidden WooCommerce virtual product.

## 8. Group-Class Booking Workflow
Students select an approved group class, add its hidden product to cart, and pay through WooCommerce/Paystack. The plugin validates status, booking window, teacher ownership, duplicate bookings, and seats both when adding to cart and again when payment/order status changes. Confirmed bookings consume seats atomically.

## 9. One-on-One Booking Workflow
One-on-one classes are represented by a class record and a single session with capacity one. Confirmation requires an atomic seat claim and a unique confirmed booking per session. Once confirmed, the class/session becomes unavailable.

## 10. WooCommerce Product and Order Integration
WooCommerce remains the source of checkout, tax, coupon, customer, payment, order, and refund truth. The plugin uses WooCommerce CRUD objects, hidden virtual simple products, cart/order item metadata, and order status hooks. It never writes directly to WooCommerce internal tables.

Historical order totals are never mutated. Price changes sync only future product prices and class records. Class details are copied to cart, checkout, order items, and emails. Payment completion creates bookings idempotently.

## 11. Booking Status Lifecycle
`pending_payment -> confirmed -> completed`

Alternate terminal or exception states: `cancelled`, `refunded`, `no_show_student`, `no_show_teacher`, `disputed`.

## 12. Class Status Lifecycle
`draft -> submitted -> approved -> published -> in_progress -> completed`

Alternate states: `fully_booked`, `cancelled`, `rejected`, `suspended`.

## 13. Attendance and Completion Workflow
Phase 1 uses manual completion. Teachers may mark delivered only after scheduled end. Administrators can confirm, override, cancel, or dispute. Completion updates confirmed bookings to completed, makes earnings eligible, and opens review eligibility.

## 14. Review Eligibility Workflow
A student may submit one review for one completed paid booking. The review stores booking, class, session, teacher, student, subject, ratings, written review, and moderation status. Public ratings use only approved reviews.

## 15. Teacher Rating and Ranking Logic
Phase 1 ranking uses a configurable weighted score:

`score = bayesian_rating * 0.45 + completed_class_factor * 0.15 + verified_review_factor * 0.15 + availability_factor * 0.10 + verification_bonus * 0.10 + new_teacher_discovery_bonus * 0.05 - cancellation_penalty`

Bayesian rating uses global mean `C`, teacher mean `R`, review count `v`, and minimum confidence `m`: `(v/(v+m))*R + (m/(v+m))*C`. "Top Rated" requires configured minimum approved reviews and completed classes.

## 16. Teacher Earnings and Payout Workflow
Completion creates ledger entries in integer minor currency units. For NGN, amounts are stored in kobo. Earnings track gross, refunds, net eligible amount, commission, teacher amount, status, and payout status. Admins manually create payout batches and mark paid or reversed with audit records. Paystack transfers are not implemented.

## 17. Cancellation and Refund Handling
Students and teachers cannot directly mutate payment state. Refunds are handled in WooCommerce. Refund hooks mark bookings/earnings refunded or reversed. Admin cancellation may update class status and add order notes, but the actual refund remains a WooCommerce workflow.

## 18. Meeting-Link Security
Meeting links are stored only in custom tables and protected post meta. They are never rendered in public HTML, REST public responses, Open Graph metadata, structured data, or search indexes. The join URL is exposed only to the authenticated booking owner or class teacher/admin inside the configured access window.

## 19. Social Sharing
Approved class pages include WhatsApp, Facebook, LinkedIn, X, Telegram, copy link, and native Web Share API controls. Share text includes class title, subject, teacher, date/time, price, and booking URL. Referral codes are opaque hashes, not sequential user IDs.

## 20. Public URLs and Rewrite Rules
Classes use `/live-classes/{class-slug}/`. Teacher profiles use `/live-teachers/{teacher-slug}/`. The plugin registers rewrite rules and flushes rules on activation/deactivation.

## 21. Student Dashboard
`[classhall_live_student_dashboard]` lists upcoming, completed, and cancelled bookings with status, payment state, class date/time, teacher, subject, join button when authorized, and review link when eligible.

## 22. Teacher Dashboard
`[classhall_live_teacher_dashboard]` shows profile/verification status, create-class form, class lists, booking counts, seats sold, revenue estimates, earnings, payout status, and student lists limited to that teacher's classes.

## 23. Administrator Interfaces
Admin screens cover settings, teacher applications, classes, bookings, reviews, earnings, payouts, and audit logs. Phase 1 implements lightweight list/detail screens; custom list tables can be expanded later.

## 24. Email and Notification Events
The notification service exposes hooks for application submitted/approved/rejected, class submitted/approved/rejected/cancelled/completed, booking confirmed/refunded, reminders, meeting-link available, review request/approved, and payout recorded. WooCommerce email hooks are used where order context exists.

## 25. REST API Requirements
Namespace: `classhall-live/v1`. Endpoints expose public class/teacher search, current user bookings, teacher classes/bookings, class create/update, review submission, and referral tracking. Each endpoint must include schemas, validation, sanitization, pagination, permission callbacks, and ownership checks.

## 26. WordPress AJAX Requirements
AJAX is optional in Phase 1. Copy-link UI can use browser APIs. Any future AJAX actions must use nonces and capability checks.

## 27. Nonce, Permission and Authentication Requirements
Every state-changing form includes nonces. Admin actions require live-class management capabilities. Teacher actions require ownership and approval. REST state changes require authentication and permission callbacks.

## 28. Data Retention and Deletion Behaviour
Transactional data is preserved on deactivation. Uninstall preserves data by default. Full deletion occurs only if the explicit `delete_data_on_uninstall` setting was enabled before uninstall.

## 29. Privacy Considerations
Student names, contact details, attendance, direct contact data, and private notes are never public. Teacher public profiles exclude identity documents and internal notes. Audit logs avoid payment secrets and excessive personal data.

## 30. Performance and Scalability Considerations
Lists are paginated, frequent filters are indexed, aggregates are cached and invalidated, assets load only on live-class screens, and custom tables avoid unbounded postmeta joins for bookings and earnings.

## 31. Accessibility Requirements
Frontend UI must be mobile-first, keyboard accessible, labelled, responsive, screen-reader friendly, and usable without hover. Buttons and forms must expose meaningful accessible names.

## 32. SEO and Structured Data Requirements
Public approved classes may output Event structured data without meeting links or private booking data. Metadata is escaped and uses class/teacher images when available.

## 33. Logging and Audit Requirements
Sensitive teacher/admin actions, booking transitions, meeting-link changes, review moderation, earnings, payouts, and settings changes are written to `{prefix}classhall_live_audit_log`.

## 34. Error-Handling Strategy
User-facing errors are concise and safe. Internal errors are logged when debug logging is enabled. Payment/order hooks are idempotent. Exceptions do not expose sensitive data.

## 35. Testing Strategy
Automated tests cover activation, schema strings, capabilities, booking idempotency, capacity safeguards, one-on-one uniqueness, meeting-link authorization, review eligibility, earnings calculation, REST permissions, escaping, and nonce failures. In this repository, no full WordPress test harness was found, so tests are scaffolded as plugin-level PHPUnit-compatible tests and PHP syntax checks.

## 36. Migration and Rollback Strategy
Migrations are versioned with `CLASSHALL_LIVE_DB_VERSION` and `dbDelta()`. Rollback is deactivation plus database backup restore. Schema documentation includes SQL reference only; runtime uses dynamic `$wpdb->prefix`.

## 37. Future Phase 2 Extension Points
Calendar integration, auto-generated meeting links, guardian consent, SMS/WhatsApp reminders, automated Paystack transfers, richer analytics, block editor blocks, advanced matching, subscription bundles, and background reconciliation workers.

