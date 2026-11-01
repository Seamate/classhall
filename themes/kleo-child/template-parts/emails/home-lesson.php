<?php
/** Variables are supplied by classhall_home_lesson_send_scheduled_email(). */
defined( 'ABSPATH' ) || exit;
$zone = new DateTimeZone( 'Africa/Lagos' );
$days = array( 1 => 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' );
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?php echo esc_html( $title ); ?></title></head>
<body style="margin:0;background:#f3f6fb;color:#292929;font-family:Arial,sans-serif;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center" style="padding:20px 12px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;background:#fff;border-top:5px solid #245eec;"><tr><td style="padding:24px;">
<p style="color:#245eec;font-size:22px;font-weight:bold;margin:0 0 20px;">Classhall</p>
<h1 style="font-size:24px;line-height:1.3;margin:0 0 20px;"><?php echo esc_html( $title ); ?></h1>
<p style="line-height:1.6;">Hello <?php echo esc_html( $order->get_billing_first_name() ?: 'there' ); ?>,</p>
<p style="line-height:1.6;"><?php echo $session ? 'Your next online class is coming up.' : 'Your payment has been received and your online classes enrolment is confirmed.'; ?></p>
<p><strong>Class:</strong> <?php echo esc_html( $class_label ); ?> (Online Classes)</p>
<p><strong>Core Subjects:</strong> <?php echo esc_html( classhall_home_lesson_subjects( $class ) ); ?></p>
<?php if ( $session ) : ?>
<p style="padding:16px;background:#edf3ff;line-height:1.7;"><strong><?php echo esc_html( $sessions[ $session ] ); ?></strong><br><?php echo esc_html( wp_date( 'l, j F Y', $session, $zone ) ); ?><br><?php echo esc_html( wp_date( 'g:i a', $session, $zone ) . ' - ' . wp_date( 'g:i a', $session + 3600, $zone ) ); ?> WAT</p>
<?php endif; ?>
<h2 style="font-size:18px;margin:24px 0 12px;">Your weekly timetable</h2>
<?php foreach ( classhall_home_lesson_schedule( $class ) as $slot ) : ?>
<p style="margin:0;padding:12px 0;border-bottom:1px solid #dce5f3;line-height:1.6;"><strong><?php echo esc_html( $days[ $slot[0] ] . ' - ' . $slot[2] ); ?></strong><br><?php echo '16:30' === $slot[1] ? '4:30 - 5:30 pm' : '5:30 - 6:30 pm'; ?> WAT</p>
<?php endforeach; ?>
<p style="font-size:14px;line-height:1.6;">All times are Nigeria time (WAT, UTC+1). Three one-hour sessions per week.</p>
<p style="line-height:1.6;"><strong>Enrolment period:</strong><br><?php echo esc_html( wp_date( 'j F Y, g:i a', (int) $item->get_meta( '_chl_access_start', true ), $zone ) . ' to ' . wp_date( 'j F Y, g:i a', (int) $item->get_meta( '_chl_access_end', true ), $zone ) ); ?> WAT</p>
<p style="margin:24px 0;"><a href="<?php echo esc_url( $join_url ); ?>" style="display:inline-block;background:#245eec;color:#fff;padding:14px 22px;border-radius:6px;text-decoration:none;font-weight:bold;">Join on Google Meet</a></p>
<p style="font-size:14px;line-height:1.6;">Keep this email. Your private join button opens the current meeting link throughout your paid enrolment. Please do not share it.</p>
<p style="font-size:14px;line-height:1.6;"><a href="<?php echo esc_url( classhall_home_lesson_renewal_url( $order, $item ) ); ?>" style="color:#1746bb;font-weight:bold;">Renew Online Classes</a><br>Renewal is optional. No automatic charges.</p>
<p style="font-size:14px;line-height:1.6;">Need help? <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="color:#1746bb;">Contact Classhall</a>.</p>
</td></tr></table></td></tr></table>
</body></html>
