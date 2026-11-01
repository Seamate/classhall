<?php
/** Isolated regression test; no WordPress boot or outgoing emails. */
if ( PHP_SAPI !== 'cli' ) { exit; }
function add_action( ...$args ) {}
function get_post_meta( $id, $key, $single ) { return 20 === $id ? 'yes' : ''; }
function wp_strip_all_tags( $value ) { return strip_tags( $value ); }
function esc_html( $value ) { return htmlspecialchars( $value, ENT_QUOTES ); }
function esc_url( $value ) { return $value; }
function esc_url_raw( $value ) { return $value; }
class WC_Order_Item_Product {
    public function __construct( public $meta = array(), public $product_id = 1 ) {}
    public function get_meta( $key, $single ) { return $this->meta[ $key ] ?? ''; }
    public function get_product_id() { return $this->product_id; }
}
class WC_Order {
    public function __construct( public $items ) {}
    public function get_items() { return $this->items; }
    public function get_user_id() { return 1; }
}
function classhall_email_order_subjects_for_live_classes( $order ) { return array( array( 'label' => 'Government' ) ); }
function classhall_email_normalized_user_role( $id ) { return 'student'; }
function classhall_email_live_classes_copy( $role, $subject ) { return array( 'heading' => 'Live Classes', 'message' => 'Explore live classes', 'url' => 'https://example.test/live-classes/', 'button' => 'Explore' ); }

// Load the actual callbacks without booting the unrelated child-theme hooks.
$source = file_get_contents( __DIR__ . '/../themes/kleo-child/functions.php' );
$start = strpos( $source, 'function classhall_email_is_home_lesson_order_item(' );
$end = strpos( $source, 'function classhall_email_live_classes_copy(' );
if ( false === $start || false === $end ) { throw new RuntimeException( 'Email callbacks not found.' ); }
eval( substr( $source, $start, $end - $start ) );

$home = new WC_Order_Item_Product( array( '_classhall_home_lesson' => 'yes' ) );
$legacy = new WC_Order_Item_Product( array(), 20 );
$subject = new WC_Order_Item_Product();
foreach ( array( array( $home ), array( $legacy ), array( $subject, $home ) ) as $items ) {
    foreach ( array( false, true ) as $plain ) {
        foreach ( array( 'customer_processing_order', 'customer_completed_order', 'customer_processing_renewal_order', 'customer_invoice' ) as $id ) {
            ob_start();
            classhall_email_live_classes_cta( new WC_Order( $items ), false, $plain, (object) array( 'id' => $id ) );
            if ( '' !== ob_get_clean() ) { throw new RuntimeException( 'Live Classes promotion leaked into a Home Lessons email.' ); }
        }
    }
}
ob_start();
classhall_email_live_classes_cta( new WC_Order( array( $subject ) ), false, true, (object) array( 'id' => 'customer_completed_order' ) );
if ( ! str_contains( ob_get_clean(), 'Live Classes' ) ) { throw new RuntimeException( 'Unrelated subject email promotion was removed.' ); }
echo "PASS: Home Lessons, renewals, legacy products and mixed orders omit Live Classes in HTML/plain-text emails. Ordinary subject emails retain their promotion.\n";
