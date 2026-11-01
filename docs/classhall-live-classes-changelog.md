# Changelog

## 0.1.3
* Updated the student dashboard to always show the join area for confirmed paid bookings with a meeting URL, including a disabled Join button and availability message outside the access window.

## 0.1.2
* Added paid booking confirmation emails for students and new-booking notification emails for teachers.
* Added authorized `/live-class-join/{booking_uuid}/` redirects so the student dashboard no longer prints the raw meeting URL in the Join button.
* Added class ownership, booking status, class status, and meeting access-window checks before redirecting to the private meeting URL.
* Added an admin-only Delete action for live classes that soft-deletes the class, moves the class post to Trash, drafts the linked product, and preserves booking/order history.

## 0.1.1
* Forced frontend asset cache busting, showed only the selected meeting-platform helper link, and made the one-on-one seats field hidden and disabled by default.

## 0.1.0
* Added Classhall Live Classes plugin scaffold.
* Added custom-table migrations for teachers, classes, sessions, bookings, reviews, earnings, payouts, referrals, and audit log.
* Added teacher application, teacher dashboard, student dashboard, class listing, subject listing, and review shortcodes.
* Added WooCommerce hidden product association and paid booking confirmation.
* Corrected product synchronisation so WooCommerce products are created on approval or publish status, not on initial teacher submission.
* Added public `/live-teachers/{teacher-slug}/` profile routing and safe public class social metadata.
* Prevented duplicate live-class creation from form refreshes or rapid double-submits, and made admin class status approval idempotent.
* Updated Facebook and X share links; X now uses the current `x.com` post intent endpoint.
* Simplified the teacher live-class creation form: removed primary subject and cancellation policy fields, renamed Subject/Class level/Duration/Seats labels, and changed class levels to a Primary 1 through SS3 dropdown.
* Filtered the Sensei Subject dropdown by the selected class level using inferred course title/term metadata, with a WordPress filter for production-specific class-level mappings.
* Renamed the live-class creation "Class levels" field to "Class", hid Sensei courses that do not match the selected class, and removed class-level text from subject dropdown labels.
* Removed extra class text such as "Upper Basic 7" from subject dropdown titles and excluded non-main subject entries such as tests, quizzes, assessments, examinations, mocks, and question banks.
* Removed trailing separators and empty parentheses from subject dropdown titles, renamed the price field to `Price (₦)`, and removed the visible currency field from teacher class creation.
* Normalised subject dropdown labels to title case, removed remaining trailing dash/minus characters, and sorted subjects alphabetically.
* Updated the teacher application form: removed the phone field, renamed "Class levels taught" to "Classes taught", changed classes taught to checkboxes, and aligned the confirmation checkbox with its text.
* Made one-on-one the default live-class type, hid Seats available unless Group is selected, added meeting-platform helper links, removed Primary classes from the Class dropdown, and added browser-side subject label cleanup for trailing dashes.
* Fixed hidden field styling so Seats available stays hidden for one-on-one classes, and made meeting-platform helper links update more reliably with direct Google Meet, Zoom, and Microsoft Teams links.
* Added REST read endpoints and WP-CLI maintenance command hooks.
* Added documentation, security review, testing guide, admin guide, teacher guide, assumptions, risks, and Phase 2 recommendations.
