<?php
/**
 * File containing the Group_Course_Student_Access_Start_Welcome_Recurring_Job class.
 *
 * @package sensei-wc-paid-courses
 */

namespace Sensei_Pro_Student_Groups\Background_Jobs;

use Sensei_Pro\Background_Jobs\Scheduler;
use Sensei_Pro\Background_Jobs\Cron_Job;
use Sensei_Pro_Student_Groups\Background_Jobs\Group_Course_Student_Access_Start_Welcome_Job;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Group_Course_Student_Access_Start_Welcome_Recurring_Job
 *
 * @since 1.24.2
 */
class Group_Course_Student_Access_Start_Welcome_Recurring_Job implements Cron_Job {

	/**
	 * The name of the job.
	 */
	const NAME = 'sensei_pro_student_group_course_access_start_welcome_recurring';

	/**
	 * Initialize necessary hooks.
	 */
	public static function init() {
		add_action( self::NAME, [ __CLASS__, 'on_job_hook' ] );
		add_action( 'init', [ __CLASS__, 'schedule_recurring_jobs' ] );
	}

	/**
	 * Student welcome email scheduling job. Hooked into the job action.
	 *
	 * @access private
	 *
	 * @param array $args Arguments for the job.
	 */
	public static function on_job_hook( $args ) {
		$job = new Group_Course_Student_Access_Start_Welcome_Job( $args );
		Scheduler::instance()->schedule_single_job( $job );
	}

	/**
	 * Schedule recurring student welcome email job.
	 *
	 * @access private
	 */
	public static function schedule_recurring_jobs() {
		$job = new self();
		Scheduler::instance()->schedule_cron_job( $job );
	}

	/**
	 * Get the action name for the scheduled job.
	 *
	 * @return string
	 */
	public function get_name() {
		return self::NAME;
	}

	/**
	 * Get the arguments to run with the job.
	 *
	 * @return array
	 */
	public function get_args() {
		return [];
	}

	/**
	 * Get the group name. No need to prefix with `sensei-wc-paid-listings`.
	 *
	 * @return string
	 */
	public function get_group() {
		return 'default';
	}

	/**
	 * Get the cron schedule. A cron-link schedule string.
	 *
	 * @return string
	 */
	public function get_schedule() {
		/**
		 * Schedule to send welcome email to students when their access to a group course access starts.
		 * The default value is daily at midnight.
		 *
		 * @since 1.24.2
		 *
		 * @param {string} $schedule A cron-link schedule string.
		 *
		 * @return {string} A cron-link schedule string.
		 */
		return apply_filters(
			'sensei_pro_student_group_access_start_welcome_recurring_job_schedule',
			'0 0 * * *'
		);
	}
}
