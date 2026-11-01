<?php
/** Run with: php tests/home-lesson-schedule-test.php (no real emails or database). */
if ( PHP_SAPI !== 'cli' ) { exit; }
define( 'ABSPATH', __DIR__ );
define( 'DAY_IN_SECONDS', 86400 );
function add_action( ...$args ) {}
function add_filter( ...$args ) {}
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); }
function __( $s, ...$args ) { return $s; }
function esc_html__( $s, ...$args ) { return esc_html( $s ); }
function wp_strip_all_tags( $s ) { return strip_tags( $s ); }
function esc_url( $s ) { return esc_html( $s ); }
function wp_kses_post( $s ) { return $s; }
function wc_price( $price ) { return 'NGN ' . $price; }
function classhall_home_lesson_price() { return 20000; }
function wp_hash( $s ) { return hash_hmac( 'sha256', $s, 'isolated-test-key' ); }
function get_current_user_id() { return $GLOBALS['test_user'] ?? 0; }
function WC() { return $GLOBALS['test_wc']; }
function home_url( $path ) { return 'https://classhall.test' . $path; }
function add_query_arg( $args, $url ) { return $url . '?' . http_build_query( $args ); }
function wp_generate_password( ...$args ) { return bin2hex( random_bytes( 20 ) ); }
function wp_date( $format, $time, $zone ) { return ( new DateTimeImmutable( '@' . $time ) )->setTimezone( $zone )->format( $format ); }
$source = file_get_contents( __DIR__ . '/../themes/kleo-child/functions.php' );
$start = strpos( $source, 'function classhall_home_lesson_classes(' );
$end = strpos( $source, 'function classhall_home_lesson_price_minor(' );
if ( false === $start || false === $end ) { throw new RuntimeException( 'Class catalogue not found.' ); }
eval( substr( $source, $start, $end - $start ) );
$options = $queue = $mails = $orders = array();
$mail_result = true;
function get_option( $key, $default = false ) { return $GLOBALS['options'][ $key ] ?? $default; }
function add_option( $key, $value, ...$args ) {
    if ( isset( $GLOBALS['options'][ $key ] ) ) { return false; }
    $GLOBALS['options'][ $key ] = $value;
    return true;
}
function delete_option( $key ) { unset( $GLOBALS['options'][ $key ] ); }
function wc_get_order( $id ) { return $GLOBALS['orders'][ $id ] ?? false; }
function wc_get_orders( $args ) {
    return array_values( array_filter( $GLOBALS['orders'], fn( $order ) => $order->paid && (string) $order->get_meta( $args['meta_key'] ) === (string) $args['meta_value'] ) );
}
function as_schedule_single_action( $time, $hook, $args, $group, $unique ) {
    $key = $hook . serialize( $args );
    $GLOBALS['queue'][ $key ] = array( $time, $hook, $args );
    return count( $GLOBALS['queue'] );
}
function wp_mail( $to, $subject, $body, $headers ) {
    $GLOBALS['mails'][] = compact( 'to', 'subject', 'body', 'headers' );
    return $GLOBALS['mail_result'];
}
class LessonItem {
    public $meta;
    public function __construct( public $id, $class ) { $this->meta = array( '_classhall_home_lesson' => 'yes', '_classhall_home_lesson_class' => $class ); }
    public function get_meta( $key, ...$args ) { return $this->meta[ $key ] ?? ''; }
    public function update_meta_data( $key, $value ) { $this->meta[ $key ] = $value; }
    public function save() {}
    public function get_id() { return $this->id; }
    public function get_quantity() { return 1; }
}
class LessonOrder {
    public $paid = true;
    public $refunded = 0;
    public $notes = array();
    public $meta = array();
    public $customer_id = 7;
    public function __construct( public $id, public $items, public $date ) {}
    public function get_id() { return $this->id; }
    public function get_customer_id() { return $this->customer_id; }
    public function get_meta( $key, ...$args ) { return $this->meta[ $key ] ?? ''; }
    public function update_meta_data( $key, $value ) { $this->meta[ $key ] = $value; }
    public function is_paid() { return $this->paid; }
    public function get_date_paid() { return new DateTimeImmutable( '@' . $this->date ); }
    public function get_items() { return $this->items; }
    public function get_item( $id ) { return $this->items[ $id ] ?? false; }
    public function get_qty_refunded_for_item( $id ) { return $this->refunded; }
    public function get_billing_email() { return 'parent@example.test'; }
    public function get_billing_first_name() { return 'Parent'; }
    public function add_order_note( $note ) { $this->notes[] = $note; }
}
require __DIR__ . '/../themes/kleo-child/inc/home-lesson-schedule.php';
function check( $condition, $message ) {
    if ( ! $condition ) { throw new RuntimeException( $message ); }
    echo "PASS: $message\n";
}
function stamp( $s ) { return ( new DateTimeImmutable( $s, new DateTimeZone( 'Africa/Lagos' ) ) )->getTimestamp(); }

check( classhall_home_lesson_period_end( stamp( '2026-01-31 17:15' ) ) === stamp( '2026-02-28 17:15' ), 'Calendar month clamps to February and preserves local time' );
check( classhall_home_lesson_period_end( stamp( '2028-01-31 17:15' ) ) === stamp( '2028-02-29 17:15' ), 'Leap year expiry' );
check( classhall_home_lesson_period_end( stamp( '2026-12-15 09:00' ) ) === stamp( '2027-01-15 09:00' ), 'Year boundary expiry' );
$expected = array(
    1 => array( '2026-09-21 16:30' => 'Mathematics', '2026-09-23 16:30' => 'English', '2026-09-24 16:30' => 'Other subjects' ),
    2 => array( '2026-09-21 17:30' => 'English', '2026-09-22 16:30' => 'Mathematics', '2026-09-24 17:30' => 'Other subjects' ),
    3 => array( '2026-09-22 17:30' => 'English', '2026-09-23 17:30' => 'Other subjects', '2026-09-25 16:30' => 'Mathematics' ),
);
foreach ( range( 1, 6 ) as $number ) {
    $want = array();
    foreach ( $expected[ (int) ceil( $number / 2 ) ] as $date => $subject ) { $want[ stamp( $date ) ] = $subject; }
    check( classhall_home_lesson_sessions( 'primary-' . $number, stamp( '2026-09-21 00:00' ), stamp( '2026-09-28 00:00' ) ) === $want, 'Exact timetable for Primary ' . $number );
}
check( ! classhall_home_lesson_schedule( 'primary-7' ), 'Invalid class has no sessions' );
check( ! classhall_home_lesson_sessions( 'primary-1', stamp( '2026-09-21 16:31' ), stamp( '2026-09-23 16:30' ) ), 'No past session or session at expiry' );
foreach ( array( 86400, 3600 ) as $lead ) {
    check( classhall_home_lesson_reminder_due( 200000, $lead, 200000 - $lead ), 'Reminder is due at exact offset ' . $lead );
    check( ! classhall_home_lesson_reminder_due( 200000, $lead, 200000 - $lead - 1 ), 'No early reminder ' . $lead );
    check( ! classhall_home_lesson_reminder_due( 200000, $lead, 200000 - $lead + 3601 ), 'Skip stale reminder ' . $lead );
    check( ! classhall_home_lesson_reminder_due( 200000, $lead, 200000 ), 'No reminder after start ' . $lead );
}

$item = new LessonItem( 10, 'primary-2' );
check( classhall_home_lesson_reminder_due( 200000, 3600, 198200 ), 'Hourly run accepts a reminder 30 minutes late' );
check( ! classhall_home_lesson_reminder_due( 200000, 600, 199400 ), 'Previously queued 10-minute reminders are ignored' );
$order = $orders[1] = new LessonOrder( 1, array( 10 => $item ), time() );
classhall_home_lesson_enrol_paid_order( 1 );
$count = count( $queue );
check( $count > 20, 'Paid enrolment queues confirmation and a month of reminders' );
$token = $item->get_meta( '_chl_join_token' );
classhall_home_lesson_enrol_paid_order( 1 );
check( count( $queue ) === $count && $token === $item->get_meta( '_chl_join_token' ), 'Repeated payment hooks do not duplicate jobs or rotate access token' );
$offsets_valid = true;
foreach ( $queue as $job ) {
    list( $due, $hook, $args ) = $job;
    if ( 'classhall_home_lesson_email' === $hook && $args[2] ) {
        $offsets_valid = $offsets_valid && $due === $args[2] - $args[3] && in_array( $args[3], array( 86400, 3600 ), true );
    }
}
check( $offsets_valid, 'All queued reminders have correct offsets' );
classhall_home_lesson_send_scheduled_email( 1, 10, 0, 0 );
check( count( $mails ) === 1 && str_contains( $mails[0]['body'], 'Primary 2' ) && str_contains( $mails[0]['body'], 'Monday - Mathematics' ) && str_contains( $mails[0]['body'], '4:30 - 5:30 pm' ) && str_contains( $mails[0]['body'], 'chl_token=' ), 'Confirmation includes selected class, timetable, and private join link' );
classhall_home_lesson_send_scheduled_email( 1, 10, 0, 0 );
check( count( $mails ) === 1, 'Confirmation sent only once' );
$stable_url = classhall_home_lesson_join_url( $order, $item );
$options['classhall_home_lesson_meet_url'] = 'https://meet.google.com/abc-defg-hij';
check( classhall_home_lesson_meet_url() === $options['classhall_home_lesson_meet_url'] && classhall_home_lesson_join_url( $order, $item ) === $stable_url, 'Meeting setting changes without changing existing private join links' );
$order->paid = false;
check( ! classhall_home_lesson_active_item( $order, $item ), 'Unpaid or cancelled enrolment denied' );
$order->paid = true;
$order->refunded = -1;
check( ! classhall_home_lesson_active_item( $order, $item ), 'Refunded item denied' );
$order->refunded = 0;
$item->update_meta_data( '_chl_access_end', time() - 1 );
check( ! classhall_home_lesson_active_item( $order, $item ), 'Expired enrolment denied' );
$unpaid = $orders[2] = new LessonOrder( 2, array( 20 => new LessonItem( 20, 'primary-4' ) ), time() );
$unpaid->paid = false;
classhall_home_lesson_enrol_paid_order( 2 );
check( count( $queue ) === $count, 'Unpaid registration queues no emails or reminders' );
$unpaid->paid = true;
classhall_home_lesson_enrol_paid_order( 2 );
$mail_result = false;
classhall_home_lesson_send_scheduled_email( 2, 20, 0, 0 );
check( ! $unpaid->items[20]->get_meta( '_chl_sent_0_0' ) && count( array_filter( $queue, fn( $job ) => count( $job[2] ) === 5 ) ) === 1, 'Failed mail is not marked sent and schedules a retry' );
// Separate paid periods preserve history while extending access without overlaps.
$mail_result = true;
$root_item = new LessonItem( 30, 'primary-3' );
$root = $orders[3] = new LessonOrder( 3, array( 30 => $root_item ), time() - 86400 );
classhall_home_lesson_enrol_paid_order( 3 );
$root_end = (int) $root_item->get_meta( '_chl_access_end' );
function renewal_order( $id, $root, $root_item, $paid_at ) {
    $item = new LessonItem( $id * 10, $root_item->get_meta( '_classhall_home_lesson_class' ) );
    $item->update_meta_data( '_chl_root_order', $root->get_id() );
    $item->update_meta_data( '_chl_root_item', $root_item->get_id() );
    $order = new LessonOrder( $id, array( $id * 10 => $item ), $paid_at );
    $order->update_meta_data( '_chl_renewal_root', $root_item->get_id() );
    $GLOBALS['orders'][$id] = $order;
    return array( $order, $item );
}
list( $renewal, $renew_item ) = renewal_order( 4, $root, $root_item, time() );
$renewal->paid = false;
classhall_home_lesson_enrol_paid_order( 4 );
check( ! $renew_item->get_meta( '_chl_access_end' ), 'Unpaid renewal does not extend access' );
$renewal->paid = true;
classhall_home_lesson_enrol_paid_order( 4 );
check( (int) $renew_item->get_meta( '_chl_access_start' ) === $root_end, 'Early renewal starts at existing expiry' );
check( (int) $renew_item->get_meta( '_chl_access_end' ) === classhall_home_lesson_period_end( $root_end ), 'Early renewal adds a full calendar month' );
check( (int) $root_item->get_meta( '_chl_access_end' ) === $root_end, 'Original paid period remains unchanged' );
$renew_end = (int) $renew_item->get_meta( '_chl_access_end' );
classhall_home_lesson_enrol_paid_order( 4 );
check( (int) $renew_item->get_meta( '_chl_access_end' ) === $renew_end, 'Duplicate renewal payment callbacks do not extend twice' );
classhall_home_lesson_send_scheduled_email( 4, 40, 0, 0 );
check( str_contains( end( $mails )['subject'], 'renewal is confirmed' ), 'Early renewal sends confirmation before its future period starts' );
list( $second, $second_item ) = renewal_order( 5, $root, $root_item, time() );
classhall_home_lesson_enrol_paid_order( 5 );
check( (int) $second_item->get_meta( '_chl_access_start' ) === $renew_end, 'Second paid renewal extends latest paid expiry' );
$second->refunded = -1;
check( classhall_home_lesson_renewal_start( 0, classhall_home_lesson_periods( $root, $root_item ) ) === $renew_end, 'Refunded renewal no longer grants an access period' );
check( count( classhall_home_lesson_periods( $root, $root_item ) ) === 2, 'Old joining link can resolve original and renewed paid periods' );
$mail_count = count( $mails );
classhall_home_lesson_send_expiry_email( 3, 30, time() - 1, 'expired' );
check( count( $mails ) === $mail_count, 'Superseded expiry email is suppressed after renewal' );
check( classhall_home_lesson_can_renew( $root, $root_item, '', 7 ), 'Account owner is authorised' );
check( ! classhall_home_lesson_can_renew( $root, $root_item, '', 99 ), 'Other account cannot renew without a valid private link' );
check( ! classhall_home_lesson_can_renew( $root, $root_item, 'forged', 0 ), 'Forged guest renewal token rejected' );
check( classhall_home_lesson_can_renew( $root, $root_item, $root_item->get_meta( '_chl_join_token' ), 0 ), 'Valid guest email renewal token accepted' );
check( ! classhall_home_lesson_can_renew( $root, false, 'forged', 7 ), 'Foreign or missing order item rejected' );

$expired_item = new LessonItem( 60, 'primary-5' );
$expired_order = $orders[6] = new LessonOrder( 6, array( 60 => $expired_item ), time() - 50 * 86400 );
classhall_home_lesson_enrol_paid_order( 6 );
list( $late, $late_item ) = renewal_order( 7, $expired_order, $expired_item, time() );
classhall_home_lesson_enrol_paid_order( 7 );
check( (int) $late_item->get_meta( '_chl_access_start' ) === $late->date, 'Expired renewal starts at new payment date' );
check( (int) $late_item->get_meta( '_chl_access_end' ) === classhall_home_lesson_period_end( $late->date ), 'Expired renewal grants one new calendar month' );

$notice_item = new LessonItem( 80, 'primary-1' );
$notice_order = $orders[8] = new LessonOrder( 8, array( 80 => $notice_item ), time() - 20 * 86400 );
classhall_home_lesson_enrol_paid_order( 8 );
$notice_item->update_meta_data( '_chl_access_end', time() + 2 * 86400 );
classhall_home_lesson_send_expiry_email( 8, 80, $notice_item->get_meta( '_chl_access_end' ), 'before' );
check( str_contains( end( $mails )['subject'], 'expires soon' ) && str_contains( end( $mails )['body'], 'chl_renew=' ), 'Before-expiry email contains private renewal link' );
$mail_count = count( $mails );
classhall_home_lesson_send_expiry_email( 8, 80, $notice_item->get_meta( '_chl_access_end' ), 'before' );
check( count( $mails ) === $mail_count, 'Before-expiry email is sent only once' );
$notice_item->update_meta_data( '_chl_access_end', time() - 1 );
classhall_home_lesson_send_expiry_email( 8, 80, $notice_item->get_meta( '_chl_access_end' ), 'expired' );
check( str_contains( end( $mails )['subject'], 'has expired' ), 'Expired enrolment receives renewal email without active access' );
$checkout_item = array( 'chl_root_order' => 3, 'chl_root_item' => 30, 'chl_renewal_proof' => wp_hash( '3:30' ), 'classhall_home_lesson_class' => 'primary-3' );
$test_wc = (object) array( 'cart' => new class {
    public $items = array();
    public function get_cart() { return $this->items; }
} );
$test_wc->cart->items = array( $checkout_item );
$errors = new class {
    public $messages = array();
    public function add( $key, $message ) { $this->messages[$key] = $message; }
};
classhall_home_lesson_validate_renewal_checkout( array( 'billing_email' => 'parent@example.test' ), $errors );
check( ! $errors->messages, 'Guest checkout accepts original billing email and signed renewal cart' );
classhall_home_lesson_validate_renewal_checkout( array( 'billing_email' => 'other@example.test' ), $errors );
check( isset( $errors->messages['chl_renewal_email'] ), 'Guest checkout rejects changed enrolment owner email' );
$errors->messages = array();
$test_user = 7;
classhall_home_lesson_validate_renewal_checkout( array( 'billing_email' => 'updated@example.test' ), $errors );
check( ! $errors->messages, 'Authenticated original owner may use updated billing email' );
$test_wc->cart->items[0]['chl_renewal_proof'] = 'forged';
classhall_home_lesson_validate_renewal_checkout( array( 'billing_email' => 'parent@example.test' ), $errors );
check( isset( $errors->messages['chl_renewal_invalid'] ), 'Checkout rejects tampered renewal cart' );
require __DIR__ . '/../themes/kleo-child/inc/home-lesson-order-display.php';
$formatted = array();
foreach ( array( 'Primary class' => 'Primary 2', 'Subjects' => 'All primary subjects', 'Time' => 'Monday: 4:30 - 5:30 pm; Wednesday: 4:30 - 5:30 pm', 'Location' => 'Online via Google Meet' ) as $key => $value ) {
    $formatted[] = (object) array( 'key' => $key, 'value' => $value, 'display_key' => $key, 'display_value' => $value );
}
check( classhall_home_lesson_order_display_meta( $formatted, $root_item ) === $formatted, 'Order metadata unchanged outside frontend details' );
$GLOBALS['classhall_home_order_display'] = true;
$display = classhall_home_lesson_order_display_meta( $formatted, $root_item );
check( count( $display ) === 3 && $display[0]->display_key === 'Class' && $display[1]->display_key === 'Core Subjects' && $display[2]->display_key === 'Timetable', 'Confirmation labels simplified and Location removed' );
check( str_contains( $display[2]->display_value, '<br>' ) && str_contains( $display[1]->display_value, 'Digital Technology' ), 'Timetable wraps by day and lists core subjects' );
check( $formatted[0]->display_key === 'Primary class', 'Stored and shared order metadata not mutated' );
$other_item = new LessonItem( 90, 'primary-1' );
$other_item->meta['_classhall_home_lesson'] = 'no';
check( classhall_home_lesson_order_display_meta( $formatted, $other_item ) === $formatted, 'Other products keep existing order details' );
unset( $GLOBALS['classhall_home_order_display'] );
check( count( classhall_home_lesson_classes() ) === 12, 'Primary, junior and senior secondary classes are selectable' );
foreach ( array( 'jss1', 'jss2', 'jss3', 'ss1', 'ss2', 'ss3' ) as $index => $class ) {
    $group = $index % 3 + 1;
    $sessions = classhall_home_lesson_sessions( $class, stamp( '2026-09-21 00:00' ), stamp( '2026-09-28 00:00' ) );
    check( array_keys( $sessions ) === array_map( 'stamp', array_keys( $expected[ $group ] ) ), $class . ' reuses the assigned timetable group' );
    $subject = $index < 3 ? 'Business Studies' : 'Physics';
    check( str_contains( classhall_home_lesson_subjects( $class ), $subject ), $class . ' has level-specific subjects' );
    $id = 100 + $index;
    $item = new LessonItem( $id * 10, $class );
    $order = $orders[ $id ] = new LessonOrder( $id, array( $id * 10 => $item ), time() );
    classhall_home_lesson_enrol_paid_order( $id );
    check( (int) $item->get_meta( '_chl_access_end' ) === classhall_home_lesson_period_end( $order->date ), $class . ' receives monthly access' );
    classhall_home_lesson_send_scheduled_email( $id, $id * 10, 0, 0 );
    check( str_contains( end( $mails )['body'], $subject ), $class . ' confirmation includes its subjects' );
    list( $renewal, $renew_item ) = renewal_order( 200 + $index, $order, $item, time() );
    classhall_home_lesson_enrol_paid_order( $renewal->get_id() );
    check( (int) $renew_item->get_meta( '_chl_access_start' ) === (int) $item->get_meta( '_chl_access_end' ), $class . ' renewal extends existing access' );
}
echo "All online class, renewal and display tests passed. No real emails sent.\n";
