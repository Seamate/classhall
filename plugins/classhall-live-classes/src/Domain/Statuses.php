<?php
/**
 * Shared status constants.
 */

namespace Classhall\LiveClasses\Domain;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Statuses {
	const TEACHER_DRAFT        = 'draft';
	const TEACHER_SUBMITTED    = 'submitted';
	const TEACHER_UNDER_REVIEW = 'under_review';
	const TEACHER_APPROVED     = 'approved';
	const TEACHER_REJECTED     = 'rejected';
	const TEACHER_SUSPENDED    = 'suspended';

	const CLASS_DRAFT      = 'draft';
	const CLASS_SUBMITTED  = 'submitted';
	const CLASS_APPROVED   = 'approved';
	const CLASS_PUBLISHED  = 'published';
	const CLASS_FULL       = 'fully_booked';
	const CLASS_COMPLETED  = 'completed';
	const CLASS_CANCELLED  = 'cancelled';
	const CLASS_REJECTED   = 'rejected';
	const CLASS_SUSPENDED  = 'suspended';

	const BOOKING_PENDING   = 'pending_payment';
	const BOOKING_CONFIRMED = 'confirmed';
	const BOOKING_COMPLETED = 'completed';
	const BOOKING_CANCELLED = 'cancelled';
	const BOOKING_REFUNDED  = 'refunded';
	const BOOKING_DISPUTED  = 'disputed';

	const REVIEW_PENDING  = 'pending';
	const REVIEW_APPROVED = 'approved';
	const REVIEW_REJECTED = 'rejected';
	const REVIEW_HIDDEN   = 'hidden';
}

