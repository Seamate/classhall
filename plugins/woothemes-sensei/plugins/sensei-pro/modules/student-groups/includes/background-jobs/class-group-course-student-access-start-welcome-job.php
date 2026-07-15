<?php
/**
 * File containing the class \Sensei_Pro_Student_Groups\Background_Jobs\Group_Course_Student_Access_Start_Welcome_Job.
 *
 * @package sensei-pro
 * @since   1.24.2
 */

namespace Sensei_Pro_Student_Groups\Background_Jobs;

use Sensei_Pro_Student_Groups\Access_Control;
use Sensei_Pro\Background_Jobs\Scheduler;
use Sensei_Pro\Background_Jobs\Completable_Job;
use Sensei_Pro_Student_Groups\Repositories\Group_Course_Repository;
use Sensei_Pro_Student_Groups\Repositories\Group_Student_Repository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Group_Course_Student_Access_Start_Welcome_Job is responsible for sending welcome emails to students
 * on the day they get access to the course through group cohort.
 *
 * @since 1.24.2
 */
class Group_Course_Student_Access_Start_Welcome_Job implements Completable_Job {
	const NAME               = 'sensei_pro_student_group_course_access_start_welcome';
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
	 * Group course repository.
	 *
	 * @var Group_Course_Repository
	 */
	private static $group_course_repository;

	/**
	 * Group student repository.
	 *
	 * @var Group_Student_Repository
	 */
	private static $group_student_repository;

	/**
	 * Access control.
	 *
	 * @var Access_Control
	 */
	private static $access_control;

	/**
	 * Group_Course_Student_Access_Start_Welcome_Job constructor.
	 *
	 * @param array $args Arguments to run for the job.
	 */
	public function __construct( $args ) {
		$this->batch_size = isset( $args['batch_size'] ) ? intval( $args['batch_size'] ) : self::DEFAULT_BATCH_SIZE;
		$this->last_item  = isset( $args['last_item'] ) ? intval( $args['last_item'] ) : 0;
	}

	/**
	 * Initialize necessary hooks.
	 *
	 * @param Group_Course_Repository  $group_course_repository  Group course repository instance.
	 * @param Group_Student_Repository $group_student_repository Group student repository instance.
	 * @param Access_Control           $access_control           Group access control instance.
	 */
	public static function init( $group_course_repository, $group_student_repository, $access_control ) {
		self::$group_course_repository  = $group_course_repository;
		self::$group_student_repository = $group_student_repository;
		self::$access_control           = $access_control;

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
		$current_date   = current_datetime()->setTime( 0, 0, 0 );
		$from_timestamp = $current_date->getTimestamp();
		$to_timestamp   = $current_date->modify( '1 day' )->getTimestamp();

		// Getting all the group courses that have access start date in the range.
		$results = self::$group_course_repository->get_group_courses_by_access_start_date_range(
			$from_timestamp,
			$to_timestamp,
			$this->last_item,
			$this->batch_size
		);

		$count_results     = is_countable( $results ) ? count( $results ) : 0;
		$this->is_complete = $count_results < $this->batch_size;

		foreach ( $results as $group_course ) {
			$group_id       = $group_course->get_group_id();
			$course_id      = $group_course->get_course_id();
			$group_students = self::$group_student_repository->find_group_students( $group_id );

			foreach ( $group_students as $student_id ) {
				if ( ! self::$access_control->should_send_group_course_welcome_email( $student_id, $group_course ) ) {
					continue;
				}

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
				do_action( 'sensei_pro_course_access_start_student_email_send', $student_id, $course_id );
			}

			$this->last_item = intval( $group_course->get_id() );
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
