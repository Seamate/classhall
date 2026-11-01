<?php
/**
 * Capability management.
 */

namespace Classhall\LiveClasses\Security;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Capabilities {
	const APPLY             = 'classhall_apply_live_teacher';
	const MANAGE_PROFILE    = 'classhall_manage_live_profile';
	const CREATE_CLASSES    = 'classhall_create_live_classes';
	const EDIT_OWN_CLASSES  = 'classhall_edit_own_live_classes';
	const VIEW_BOOKINGS     = 'classhall_view_own_live_bookings';
	const VIEW_EARNINGS     = 'classhall_view_own_live_earnings';
	const MANAGE_TEACHERS   = 'classhall_manage_live_teachers';
	const MODERATE_CLASSES  = 'classhall_moderate_live_classes';
	const MODERATE_REVIEWS  = 'classhall_moderate_live_reviews';
	const MANAGE_PAYOUTS    = 'classhall_manage_live_payouts';
	const MANAGE_SETTINGS   = 'classhall_manage_live_settings';

	/**
	 * Admin capabilities.
	 *
	 * @return string[]
	 */
	public static function admin_caps() {
		return array(
			self::APPLY,
			self::MANAGE_PROFILE,
			self::CREATE_CLASSES,
			self::EDIT_OWN_CLASSES,
			self::VIEW_BOOKINGS,
			self::VIEW_EARNINGS,
			self::MANAGE_TEACHERS,
			self::MODERATE_CLASSES,
			self::MODERATE_REVIEWS,
			self::MANAGE_PAYOUTS,
			self::MANAGE_SETTINGS,
		);
	}

	/**
	 * Approved teacher capabilities.
	 *
	 * @return string[]
	 */
	public static function teacher_caps() {
		return array(
			self::APPLY,
			self::MANAGE_PROFILE,
			self::CREATE_CLASSES,
			self::EDIT_OWN_CLASSES,
			self::VIEW_BOOKINGS,
			self::VIEW_EARNINGS,
		);
	}

	/**
	 * Add admin caps.
	 *
	 * @return void
	 */
	public static function add_admin_caps() {
		$role = get_role( 'administrator' );
		if ( ! $role ) {
			return;
		}

		foreach ( self::admin_caps() as $cap ) {
			$role->add_cap( $cap );
		}
	}

	/**
	 * Grant live teacher caps to a user.
	 *
	 * @param int $user_id User ID.
	 * @return void
	 */
	public static function grant_teacher_caps( $user_id ) {
		$user = get_user_by( 'id', absint( $user_id ) );
		if ( ! $user ) {
			return;
		}

		foreach ( self::teacher_caps() as $cap ) {
			$user->add_cap( $cap );
		}
	}

	/**
	 * Revoke live teacher caps from a user.
	 *
	 * @param int $user_id User ID.
	 * @return void
	 */
	public static function revoke_teacher_caps( $user_id ) {
		$user = get_user_by( 'id', absint( $user_id ) );
		if ( ! $user ) {
			return;
		}

		foreach ( self::teacher_caps() as $cap ) {
			$user->remove_cap( $cap );
		}
	}
}

