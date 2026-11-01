# Classhall Live Classes Database Schema

Runtime migrations use `$wpdb->prefix` and `dbDelta()`. The SQL reference file is documentation only and uses `{prefix}` placeholders.

## Storage Decisions
Live classes use both a WordPress post (`classhall_live_class`) and custom table rows. The post provides public URLs, titles, descriptions, featured images, author ownership, revisions, and SEO compatibility. Custom tables store transactional, private, and high-volume state that should not depend on postmeta.

Money is stored as integer minor units. NGN values are kobo. Canonical timestamps are UTC `datetime`; display converts to the WordPress site timezone. Soft deletion uses `deleted_at` nullable UTC columns where records may be hidden without losing dispute history.

## Tables Evaluated
All requested tables are needed in Phase 1 except a separate high-volume referral event table is deferred. `{prefix}classhall_live_referrals` stores first-touch and conversion data; detailed clickstream can be added later.

## `{prefix}classhall_live_teacher_profiles`
Purpose: teacher application, approval, public profile, aggregates, and private admin metadata.

Key columns: `profile_id` PK, `user_id` unique, `teacher_slug` unique, `display_name`, `bio`, `photo_id`, `phone`, `qualifications`, `experience_years`, `class_levels`, `exam_specialisations`, `preferred_formats`, `document_refs`, `terms_accepted_at`, `application_status`, `is_verified`, `average_rating`, `rating_count`, `completed_class_count`, `ranking_score`, `admin_notes`, `rejection_reason`, `created_at`, `updated_at`, `deleted_at`.

Statuses: `draft`, `submitted`, `under_review`, `approved`, `rejected`, `suspended`.

Indexes: `user_id`, `teacher_slug`, `application_status`, `is_verified`, `ranking_score`.

## `{prefix}classhall_live_teacher_subjects`
Purpose: normalized teacher subject/class-level/exam coverage without hard-coding curricula.

Columns: `id` PK, `teacher_user_id`, `subject_key`, `subject_label`, `class_level_key`, `class_level_label`, `curriculum_key`, `exam_key`, `created_at`.

Unique: `teacher_subject_level` on teacher, subject, class level, curriculum, exam.

## `{prefix}classhall_live_classes`
Purpose: schedule, price, class type, capacity, status, meeting URL, WooCommerce product link, moderation state, and aggregate capacity fields.

Columns: `class_id` PK, `post_id` unique, `teacher_user_id`, `primary_subject_key`, `primary_subject_label`, `class_levels`, `course_id`, `exam_key`, `class_type`, `delivery_platform`, `meeting_url`, `start_at_utc`, `end_at_utc`, `duration_minutes`, `capacity`, `confirmed_seats`, `price_minor`, `currency`, `booking_opens_at_utc`, `booking_closes_at_utc`, `cancellation_policy`, `status`, `product_id`, `admin_notes`, `created_at`, `updated_at`, `deleted_at`.

Statuses: `draft`, `submitted`, `approved`, `published`, `fully_booked`, `in_progress`, `completed`, `cancelled`, `rejected`, `suspended`.

Indexes: teacher/status/start, subject/status/start, course, product, booking window.

Seat overselling: confirmed seats are incremented only with atomic guarded updates: `confirmed_seats + quantity <= capacity`.

## `{prefix}classhall_live_sessions`
Purpose: supports one-on-one slots and future multi-session classes.

Columns: `session_id` PK, `class_id`, `start_at_utc`, `end_at_utc`, `capacity`, `confirmed_seats`, `status`, `created_at`, `updated_at`, `deleted_at`.

Unique/indexes: class/start, status/start. One-on-one sessions have capacity `1`.

## `{prefix}classhall_live_bookings`
Purpose: authoritative booking ledger.

Columns: `booking_id` PK, `booking_uuid` unique, `student_user_id`, `teacher_user_id`, `class_id`, `session_id`, `order_id`, `order_item_id`, `status`, `payment_status`, `amount_paid_minor`, `currency`, `seat_quantity`, `booking_source`, `referral_id`, `created_at`, `updated_at`, `completed_at`, `cancelled_at`, `refunded_at`.

Unique: `order_item_booking` on `order_id`, `order_item_id`; `student_class_active` on student/class/status is represented by indexed checks because MySQL partial unique indexes are unavailable. For one-on-one, a guarded session seat update prevents double booking.

## `{prefix}classhall_live_reviews`
Purpose: verified booking reviews and moderated public testimonials.

Columns: `review_id` PK, `booking_id` unique, `student_user_id`, `teacher_user_id`, `class_id`, `subject_key`, `overall_rating`, `clarity_rating`, `knowledge_rating`, `punctuality_rating`, `communication_rating`, `understanding_improved`, `would_book_again`, `review_text`, `status`, `created_at`, `updated_at`, `moderated_at`, `moderated_by`.

Statuses: `pending`, `approved`, `rejected`, `hidden`.

Duplicate prevention: unique `booking_id`.

## `{prefix}classhall_live_earnings`
Purpose: immutable-ish ledger entries per completed booking.

Columns: `earning_id` PK, `booking_id` unique, `teacher_user_id`, `class_id`, `gross_minor`, `refund_minor`, `net_minor`, `commission_minor`, `teacher_minor`, `currency`, `earning_status`, `payout_status`, `created_at`, `updated_at`.

Statuses: earning `pending`, `eligible`, `held`, `paid`, `reversed`; payout `unpaid`, `in_payout`, `paid`, `reversed`.

## `{prefix}classhall_live_payouts`
Purpose: manual payout batch header.

Columns: `payout_id` PK, `teacher_user_id`, `currency`, `amount_minor`, `status`, `reference`, `notes`, `created_by`, `created_at`, `paid_at`, `reversed_at`.

Statuses: `draft`, `recorded`, `paid`, `reversed`.

## `{prefix}classhall_live_payout_items`
Purpose: earnings included in payout batches.

Columns: `id` PK, `payout_id`, `earning_id`, `amount_minor`, `created_at`.

Unique: `earning_id`.

## `{prefix}classhall_live_referrals`
Purpose: safe referral attribution without exposing user IDs.

Columns: `referral_id` PK, `referral_code`, `landing_url`, `platform`, `referring_teacher_user_id`, `visitor_hash`, `first_visit_at`, `converted_at`, `order_id`, `booking_id`, `campaign`.

Indexes: referral code, teacher, order, booking.

## `{prefix}classhall_live_audit_log`
Purpose: security and business audit trail.

Columns: `audit_id` PK, `actor_user_id`, `action`, `entity_type`, `entity_id`, `previous_value`, `new_value`, `ip_hash`, `request_id`, `created_at`.

Sensitive values such as payment secrets, access tokens, full meeting URLs, document contents, and excessive student data must not be logged.

## High-Volume Query Patterns
Public class search filters by status, subject, class level, start date, type, price, and teacher. Student dashboard filters bookings by student/status/date. Teacher dashboard filters classes/bookings/earnings by teacher/date/status. Admin lists filter applications, classes, reviews, earnings, payouts, and audit entries by status/date.

## Consistency Rules
Duplicate bookings are prevented by order-item uniqueness, student/class checks, idempotent order meta, and guarded inserts. Seat overselling is prevented by atomic seat increments. Order consistency is maintained by storing order ID, item ID, amount, currency, and payment status snapshots without mutating historical totals.

## Example Records
Teacher profile: `user_id=42`, `teacher_slug='mrs-ade-mathematics'`, `application_status='approved'`, `is_verified=1`.

Class: `post_id=9001`, `teacher_user_id=42`, `primary_subject_key='mathematics'`, `class_type='group'`, `capacity=25`, `confirmed_seats=7`, `price_minor=500000`, `currency='NGN'`, `status='published'`.

Booking: `student_user_id=77`, `class_id=1`, `order_id=8123`, `status='confirmed'`, `amount_paid_minor=500000`.

