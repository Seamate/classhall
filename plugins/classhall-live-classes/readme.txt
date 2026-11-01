=== Classhall Live Classes ===
Contributors: classhall
Requires at least: 6.0
Requires PHP: 7.4
Stable tag: 0.1.69
License: GPLv2 or later

Adds approved teacher live classes, WooCommerce checkout integration, secure meeting-link access, reviews, earnings, manual payouts, REST endpoints, and WP-CLI maintenance commands for Classhall.

== Description ==
Classhall Live Classes is a modular extension for live teacher-led classes connected to Classhall subjects and optional Sensei courses. Phase 1 uses manually entered meeting links and WooCommerce/Paystack checkout.

== Shortcodes ==
* [classhall_live_classes]
* [classhall_live_teachers]
* [classhall_live_teacher_application]
* [classhall_live_teacher_dashboard]
* [classhall_live_student_dashboard]
* [classhall_live_subject_classes subject="mathematics"]

== WP-CLI ==
`wp classhall-live health`
`wp classhall-live migrate`
`wp classhall-live recalc-ratings`
`wp classhall-live reconcile-bookings --dry-run`
`wp classhall-live seed --dry-run`

== Uninstall ==
Transactional data is preserved by default. Data is removed only when the plugin setting `delete_data_on_uninstall` is enabled before uninstall.

== Changelog ==

= 0.1.69 =
* Added separate admin Verify and Unverify actions for teacher profiles.

= 0.1.68 =
* Changed teacher verified avatar badge to a scalloped social-style seal.

= 0.1.67 =
* Reduced teacher profile name size and softened the teacher subject line.

= 0.1.66 =
* Reduced teacher profile header font sizes.

= 0.1.65 =
* Made teacher text searches ignore any selected class filter.

= 0.1.64 =
* Made teacher text search reset the class filter when submitted.

= 0.1.63 =
* Made teacher directory class filtering include completed live classes and common class label formats.

= 0.1.62 =
* Fixed the teacher directory query syntax after adding immediate class filtering.

= 0.1.61 =
* Made the teacher directory class filter apply immediately when changed.

= 0.1.60 =
* Reworked teacher directory search and class filtering to avoid grouped joins.

= 0.1.59 =
* Fixed teacher directory class filtering and cleaned class text from listed subject names.

= 0.1.58 =
* Moved the teacher class filter before search and made class filtering use listed live classes.

= 0.1.57 =
* Added vertical spacing around the teacher directory search button.

= 0.1.56 =
* Added spacing below the teacher directory search filters.

= 0.1.55 =
* Added a class filter to the public teacher directory.

= 0.1.54 =
* Refresh teacher aggregate ratings after student review submissions and updates.
* Rebuild existing review and teacher averages from saved category ratings.

= 0.1.53 =
* Store combined review ratings with one decimal place so teacher averages can show values like 4.5.

= 0.1.52 =
* Added review moderation admin screen and related live classes on class detail pages.

= 0.1.51 =
* Allowed students to update existing reviews without creating duplicate review records.

= 0.1.50 =
* Blocked duplicate student reviews before showing or submitting review forms.

= 0.1.49 =
* Updated live class share text and social preview image handling.

= 0.1.48 =
* Reused strict subject-title cleanup on live class detail pages.

= 0.1.47 =
* Simplified live class detail teacher metadata and share controls.

= 0.1.46 =
* Added a cover-style background to teacher profile headers.

= 0.1.45 =
* Decoded subject dash entities before removing class suffixes from teacher titles.

= 0.1.44 =
* Removed leftover trailing punctuation from teacher profile subject titles.

= 0.1.43 =
* Reused the subject dropdown cleaner for teacher profile subject titles.

= 0.1.42 =
* Normalized dash variants before removing class suffixes from teacher subject titles.

= 0.1.41 =
* Expanded class suffix cleanup in teacher subject titles.

= 0.1.40 =
* Removed class-level suffixes from teacher subject titles.

= 0.1.39 =
* Added teacher subject titles to profile headers and strengthened public rating text.

= 0.1.38 =
* Refined teacher directory/profile ratings, profile badge sizing, and subject fallback.

= 0.1.37 =
* Added the public /live-teachers/ directory route.

= 0.1.36 =
* Added a public teacher directory shortcode with search, subjects, ratings, and profile links.

= 0.1.35 =
* Enlarged teacher profile photos and moved verification status beside the teacher name.

= 0.1.34 =
* Renamed the teacher profile About section to Bio.

= 0.1.33 =
* Kept an empty sidebar column on teacher profile pages without blog widgets.

= 0.1.32 =
* Made teacher profile pages full-width and suppressed the blog sidebar.

= 0.1.31 =
* Simplified public empty-state wording.

= 0.1.30 =
* Removed custom profile sidebar column and moved teacher details into the main profile content.

= 0.1.29 =
* Restored teacher profile summary panel with clearer naming.

= 0.1.28 =
* Shortened teacher profile verified badge text.

= 0.1.27 =
* Removed repeated teacher details from the profile sidebar.

= 0.1.26 =
* Improved teacher profile layout with theme wrapper, sidebar summary, section cards, and stronger browser title fallback.

= 0.1.25 =
* Added older theme title support and visible initials fallback for teacher profile avatars.

= 0.1.24 =
* Improved teacher profile page title, avatar display, verified badge, and class label.

= 0.1.23 =
* Linked class and teacher names from student review screens.

= 0.1.22 =
* Updated review form recommendation and written review labels.

= 0.1.21 =
* Reduced student review ratings to Teaching quality and Punctuality.

= 0.1.20 =
* Removed Overall and Understanding Improved from the review form and calculates overall rating from category ratings.

= 0.1.19 =
* Reduced review page typography and control sizes.

= 0.1.18 =
* Enlarged review form radio controls.

= 0.1.17 =
* Normalized review form label and star sizing.

= 0.1.16 =
* Adjusted review prompt font sizes.

= 0.1.15 =
* Reduced review prompt sizing and simplified the prompt card styling.

= 0.1.14 =
* Simplified and brightened the student review prompt.

= 0.1.13 =
* Improved the review page prompt and converted understanding improvement to a larger five-star rating.

= 0.1.12 =
* Added class and teacher context to the student review form and review picker.

= 0.1.11 =
* Ensured standalone review pages load star-rating assets and update star selection immediately.

= 0.1.10 =
* Refined review star ratings so the stars themselves are the visible clickable controls.

= 0.1.9 =
* Changed review ratings to five-star controls and made book-again a Yes/No radio field.

= 0.1.8 =
* Added student class-held confirmation and completed-booking picker on the review page.

= 0.1.7 =
* Added class-held completion flow that completes paid bookings, releases earnings for payout, and enables student reviews.

= 0.1.6 =
* Added teacher payout bank fields and displays account information on the admin payout screen.

= 0.1.5 =
* Added teacher dashboard earnings and payout history tracking.

= 0.1.4 =
* Added an admin Earnings & Payouts screen for teacher balances, payout batch creation, manual paid confirmation, and payout reversal.
