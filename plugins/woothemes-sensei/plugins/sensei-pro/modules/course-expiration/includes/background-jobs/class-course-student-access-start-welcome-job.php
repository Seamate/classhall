<?php
/**
 * File containing the class \Sensei_Pro_Course_Expiration\Background_Jobs\Course_Student_Access_Start_Welcome_Job.
 *
 * @package sensei-pro
 * @since   1.24.2
 */

namespace Sensei_Pro_Course_Expiration\Background_Jobs;

use Sensei_Pro_Course_Expiration\Course_Expiration;
use Sensei_Pro\Background_Jobs\Scheduler;
use Sensei_Pro\Background_Jobs\Completable_Job;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Course_Student_Access_Start_Welcome_Job is responsible for sending welcome emails to students
 * on the day they get access to the course.
 *
 * @since 1.24.2
 */
class Course_Student_Access_Start_Welcome_Job implements Completable_Job {
	const NAME               = 'sensei_pro_student_course_access_start_welcome';
	const DEFAULT_BATCH_SIZE = 50;

	/**
	 * Number of expirations for each job run.
	 *
	 * @var int
	 */
	private $batch_size;

	/**
	 * Flag if the there are more batches to run.
	 *
	 * @var bool
	 */
	private $is_complete;

	/**
	 * Last sent item.
	 *
	 * @var int
	 */
	private $last_item;

	/**
	 * Course_Student_Access_Start_Welcome_Job constructor.
	 *
	 * @param array $args Arguments to run for the job.
	 */
	public function __construct( $args ) {
		$this->batch_size = isset( $args['batch_size'] ) ? intval( $args['batch_size'] ) : self::DEFAULT_BATCH_SIZE;
		$this->last_item  = isset( $args['last_item'] ) ? intval( $args['last_item'] ) : 0;
	}

	/**
	 * Initialize necessary hooks.
	 */
	public static function init() {
		add_action( self::NAME, [ __CLASS__, 'on_job_hook' ] );
	}

	/**
	 * Self scheduling job. Hooked into the job action.
	 *
	 * @access private
	 *
	 * @param array $args Arguments for the job.
	 */
	public static function on_job_hook( $args ) {
		$job = new self( $args );
		Scheduler::instance()->handle_self_scheduling_job_after_run( $job );
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
	 * Run the job.
	 */
	public function run() {
		global $wpdb;

		$current_date   = current_datetime()->setTime( 0, 0, 0 );
		$from_timestamp = $current_date->getTimestamp();
		$to_timestamp   = $current_date->modify( '1 day' )->getTimestamp();

		// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT `meta_id`, `post_id`, `meta_key` FROM {$wpdb->postmeta} WHERE `meta_key` RLIKE %s AND `meta_value` >= %s AND `meta_value` < %s AND `meta_id` > %d ORDER BY meta_id LIMIT %d",
				Course_Expiration::START_TIMESTAMP_COURSE_META_PREFIX,
				$from_timestamp,
				$to_timestamp,
				$this->last_item,
				$this->batch_size
			)
		);

		$count_results     = is_countable( $results ) ? count( $results ) : 0;
		$this->is_complete = $count_results < $this->batch_size;

		foreach ( $results as $item ) {
			$user_id   = intval(
				str_replace(
					Course_Expiration::START_TIMESTAMP_COURSE_META_PREFIX,
					'',
					$item->meta_key
				)
			);
			$course_id = intval( $item->post_id );

			// Send email.
			/**
			 * Action to send the welcome email when the student access starts.
			 *
			 * @since 1.24.2
			 *
			 * @hook sensei_pro_course_access_start_student_email_send
			 *
			 * @param {int} $user_id   The user ID.
			 * @param {int} $course_id The course ID.
			 */
			do_action( 'sensei_pro_course_access_start_student_email_send', $user_id, $course_id );

			$this->last_item = intval( $item->meta_id );
		}
	}

	/**
	 * After the job runs, check to see if it needs to be re-queued for the next batch.
	 *
	 * @return bool
	 */
	public function is_complete() {
		return $this->is_complete;
	}

	/**
	 * Get the arguments to run with the job.
	 *
	 * @return array
	 */
	public function get_args() {
		$args = [
			'last_item' => $this->last_item,
		];

		if ( self::DEFAULT_BATCH_SIZE !== $this->batch_size ) {
			$args['batch_size'] = $this->batch_size;
		}

		return $args;
	}

	/**
	 * Get the group name. No need to prefix with `sensei-wc-paid-listings`.
	 *
	 * @return string
	 */
	public function get_group() {
		return 'default';
	}
}
