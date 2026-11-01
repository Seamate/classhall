<?php
defined( 'ABSPATH' ) || exit;
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?php echo esc_html( $title ); ?></title></head>
<body style="margin:0;background:#f3f6fb;font-family:Arial,sans-serif;color:#292929;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center" style="padding:20px 12px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;background:#fff;border-top:5px solid #245eec;"><tr><td style="padding:24px;line-height:1.6;">
<p style="font-size:22px;font-weight:bold;color:#245eec;">Classhall</p>
<h1 style="font-size:24px;line-height:1.3;"><?php echo esc_html( $title ); ?></h1>
<p>Hello <?php echo esc_html( $order->get_billing_first_name() ?: 'there' ); ?>,</p>
<p><strong>Class:</strong> <?php echo esc_html( $class_label ); ?> (Online Classes)<br><strong>Expiry:</strong> <?php echo esc_html( wp_date( 'j F Y, g:i a', $end, new DateTimeZone( 'Africa/Lagos' ) ) ); ?> WAT</p>
<p>Renew for one calendar month at <?php echo wp_kses_post( wc_price( classhall_home_lesson_price() ) ); ?>. Renewing before expiry adds a month to your existing period. Renewing after expiry starts a new month from payment.</p>
<p><a href="<?php echo esc_url( $renewal_url ); ?>" style="display:inline-block;padding:14px 22px;background:#245eec;color:#fff;border-radius:6px;text-decoration:none;font-weight:bold;">Renew Online Classes</a></p>
<p>Renewal is optional. You will not be charged automatically.</p>
</td></tr></table></td></tr></table></body></html>
