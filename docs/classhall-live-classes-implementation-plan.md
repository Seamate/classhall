# Classhall Live Classes Implementation Plan

## Milestone 1: Documentation and Repository Fit
Objective: document architecture, schema, scope, security, testing, guides, and assumptions.

Files: `docs/classhall-live-classes-*.md`, `docs/classhall-live-classes-schema.sql`.

Database changes: none at documentation time.

Hooks/APIs: none.

Acceptance criteria: all required docs exist and clearly mark assumptions where the repository lacks database/runtime information.

Tests required: spelling/manual review.

Dependencies: repository inspection.

Rollback: delete docs if not wanted.

## Milestone 2: Plugin Foundation
Objective: create a self-contained namespaced plugin with autoloading, activation/deactivation, dependency notices, settings, assets, and rewrite handling.

Files: `plugins/classhall-live-classes/classhall-live-classes.php`, `composer.json`, `readme.txt`, `uninstall.php`, `src/*`, `assets/*`.

Database changes: create/update custom tables with `dbDelta()`.

Hooks/APIs: activation/deactivation hooks, `plugins_loaded`, `init`, `admin_notices`, settings API.

Acceptance criteria: plugin loads without WooCommerce/Sensei fatal errors and registers CPT/shortcodes/settings.

Tests required: PHP syntax checks, activation code inspection.

Dependencies: WordPress runtime.

Rollback: deactivate plugin; restore DB backup if needed.

## Milestone 3: Roles and Teacher Profiles
Objective: add capabilities, application/profile table, application shortcode, admin moderation actions, public profile URLs.

Files: `src/Security/Capabilities.php`, `src/Admin/Admin.php`, `src/Frontend/Shortcodes.php`, templates/assets.

Database changes: teacher profile and teacher subjects rows.

Hooks/APIs: `user_has_cap`, settings API, admin forms, rewrite rules.

Acceptance criteria: only approved teachers can create live classes.

Tests required: cap mapping, unapproved restrictions, nonce failures.

Rollback: suspend teacher profiles; remove caps only on explicit uninstall.

## Milestone 4: Live Classes and Subject Adapter
Objective: register `classhall_live_class`, create teacher dashboard form, sync schedule/private data to custom table, and associate subjects/Sensei courses through an adapter.

Files: `src/Infrastructure/Subject_Adapter.php`, `src/Frontend/Shortcodes.php`, `src/Admin/Admin.php`.

Database changes: live classes and sessions.

Hooks/APIs: `register_post_type`, `save_post`, Sensei post/taxonomy discovery.

Acceptance criteria: approved teachers can draft/submit classes; admins can approve/publish.

Tests required: class creation, ownership checks, status lifecycle.

Rollback: set classes to suspended/cancelled.

## Milestone 5: WooCommerce Booking Integration
Objective: create hidden virtual products, validate cart/checkout, create idempotent bookings after payment, enforce capacity.

Files: `src/Integrations/WooCommerce.php`.

Database changes: bookings, class/session `confirmed_seats`, earnings.

Hooks/APIs: WooCommerce CRUD, cart validation, order item meta, payment/order-status hooks, refund hooks.

Acceptance criteria: paid orders create one booking per order item and cannot oversell last seats.

Tests required: idempotency, capacity, one-on-one double booking, cancelled checkout prevention.

Rollback: reconcile bookings with WooCommerce orders; mark erroneous bookings disputed.

## Milestone 6: Dashboards, Reviews, Earnings, Payouts
Objective: student/teacher dashboards, review forms, rating aggregates, earnings ledger, manual payout admin flows.

Files: `src/Frontend/Shortcodes.php`, `src/Application/Ranking_Service.php`, `src/Admin/Admin.php`.

Database changes: reviews, earnings, payouts, payout items.

Hooks/APIs: shortcodes, admin-post actions, WooCommerce refunds, audit log.

Acceptance criteria: meeting links are visible only to authorized booking owners during the window; reviews require completed bookings.

Tests required: meeting-link authorization, duplicate review prevention, earnings/refund reversal.

Rollback: hide dashboards by removing shortcode pages; data remains for disputes.

## Milestone 7: REST, WP-CLI, Seeds, QA
Objective: expose minimal safe REST endpoints, maintenance commands, development seed command, and QA guides.

Files: `src/Api/Rest_Controller.php`, `src/Infrastructure/Cli.php`, `src/Application/Seeder.php`, `tests/*`.

Database changes: optional seed data only when command runs.

Hooks/APIs: `rest_api_init`, `WP_CLI::add_command`.

Acceptance criteria: public endpoints do not leak meeting links; private endpoints enforce ownership.

Tests required: REST permissions, seed dry run, CLI dry run.

Rollback: seed removal command in development; database backup restore in staging/production.

## Milestone 8: Final Review
Objective: review changed files, run PHP syntax checks, run available tests, scan for unsafe SQL, missing caps/nonces/escaping, meeting-link exposure, duplicate bookings, and global assets.

Files: all changed files.

Database changes: none.

Hooks/APIs: none.

Acceptance criteria: report exactly what was tested and what could not run.

Tests required: `php -l`, available PHPUnit or static tests if dependencies exist.

Rollback: deactivate plugin and restore database backup.

