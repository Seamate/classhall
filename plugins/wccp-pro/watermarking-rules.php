<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
How this file works
wccp_replace_image_urls_in_content function is called inside the main function wccp_pro_run()
it replaces image urls inside post content with watermarking urls through function wccp_replace_image_urls_in_content( $content )
wccp_replace_image_urls_in_content() uses function wccp_add_watermark_to_url() which decide to use pretty src or encrypted src
this decision must be handled as an option inside the plugin admin page

pretty_process_images_as_pages_for_watermark() function is called when any image requested with / at the end of its name
Example: localhost.com/wordpress/wp-content/uploads/2023/12/Frame-21-min.jpg/
This allow us to watermark images by doing just one change to the end of its url (only slash added at the end)
*/

add_filter('query_vars', function($vars) {
// Register the necessary query variables
$vars[] = 'wccp-watermark';
$vars[] = 'src';
return $vars;
});

// Handle requests for 'wccp-watermark'
// This is fast because its run before init action and exit before any other wordpress action
add_action('template_redirect', 'encrypted_process_images_as_pages_for_watermark');
function encrypted_process_images_as_pages_for_watermark() {
	if (get_query_var('wccp-watermark') == 1)
	{
		// send a 200 status header before any output.
		status_header(200);
        nocache_headers();
		
		// Include watermarking script
		include plugin_dir_path(__FILE__) . 'watermark.php';
		
		// Prevent WordPress from rendering the rest of the page, this make loading faster
		exit;
	}
}

// Register custom rewrite rules and query variables
add_action('init', function() {
	// Register the 'wccp-watermark' rewrite rule
	add_rewrite_rule(
		'^wccp-watermark/?$', // The URL endpoint
		'index.php?wccp-watermark=1', // Query var to identify the endpoint
		'top'
	);
});
add_action('template_redirect', 'pretty_process_images_as_pages_for_watermark');
function pretty_process_images_as_pages_for_watermark()
{
	$src = wccp_get_pretty_watermark_src_from_request();

	if ( false === $src ) {
		return;
	}

	$watermark_file = plugin_dir_path(__FILE__) . 'watermark.php';

	if ( ! file_exists( $watermark_file ) ) {
		status_header(404);
		exit('Watermark handler not found.');
	}

	status_header(200);
	nocache_headers();
	$_GET['src'] = $src;
	include $watermark_file;
	exit;
}

function wccp_get_pretty_watermark_src_from_request()
{
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return false;
	}

	$request_path = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );

	if ( ! is_string( $request_path ) || '' === $request_path ) {
		return false;
	}

	$request_path = rawurldecode( $request_path );

	if ( ! preg_match( '#\.(jpg|jpeg|png|gif|webp)/$#i', $request_path ) ) {
		return false;
	}

	$uploads = wp_upload_dir();

	if ( empty( $uploads['baseurl'] ) || empty( $uploads['basedir'] ) ) {
		return false;
	}

	$uploads_url_path = wp_parse_url( $uploads['baseurl'], PHP_URL_PATH );
	$uploads_url_path = '/' . trim( (string) $uploads_url_path, '/' );

	if ( 0 !== strpos( $request_path, trailingslashit( $uploads_url_path ) ) ) {
		return false;
	}

	$uploads_relative_path = untrailingslashit( substr( $request_path, strlen( $uploads_url_path ) ) );
	$image_file           = wp_normalize_path( trailingslashit( $uploads['basedir'] ) . ltrim( $uploads_relative_path, '/' ) );
	$wp_content_dir       = wp_normalize_path( WP_CONTENT_DIR );

	if ( ! is_file( $image_file ) || 0 !== strpos( $image_file, trailingslashit( $wp_content_dir ) ) ) {
		status_header(404);
		exit('Image is not found.');
	}

	return '/' . ltrim( substr( $image_file, strlen( $wp_content_dir ) ), '/' );
}
////////////////////////////////////////////////////////////////////////
function wccp_replace_image_urls_in_content( $content ) {
	// Ensure $content is a non-empty string
    if ( ! is_string( $content ) || trim( $content ) === '' ) {
        return ''; // Return an empty string or handle it gracefully
    }
    // Wrap the content to ensure valid HTML
	if(is_array($content)) return $content;
    //$content = '<!DOCTYPE html><html><body>' . $content . '</body></html>';
	if ( !wccp_pro_is_valid_html( $content ) ) return $content;

    // Use DOMDocument to parse and modify the content
    $dom = new DOMDocument();
    libxml_use_internal_errors( true ); // Suppress warnings for invalid HTML
    $dom->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );

    // Get the site's base URL and home URL
    $site_base_url = site_url();
    $home_url = home_url();

    // Find all <img> elements
    $images = $dom->getElementsByTagName( 'img' );

    foreach ( $images as $img ) {
        // Process the src attribute
        $src = $img->getAttribute( 'src' );
        if ( $src && strpos( $src, '?wccp-watermark=1' ) === false ) {
            // Modify the src URL
            $src = wccp_add_watermark_to_url( $src, $site_base_url, $home_url );
            $img->setAttribute( 'src', $src );
        }

        // Process the srcset attribute
        $srcset = $img->getAttribute( 'srcset' );
        if ( $srcset ) {
            $new_srcset = [];
            $srcset_entries = explode( ',', $srcset );

            foreach ( $srcset_entries as $entry ) {
                $entry_parts = preg_split( '/\s+/', trim( $entry ) ); // Split URL and descriptor
                $url = $entry_parts[0];
                $descriptor = isset( $entry_parts[1] ) ? $entry_parts[1] : '';

                // Modify the URL
                if ( strpos( $url, '?wccp-watermark=1' ) === false ) {
                    $url = wccp_add_watermark_to_url( $url, $site_base_url, $home_url );
                }

                // Reconstruct the srcset entry
                $new_srcset[] = $url . ( $descriptor ? ' ' . $descriptor : '' );
            }

            // Update the srcset attribute
            $img->setAttribute( 'srcset', implode( ', ', $new_srcset ) );
        }
    }

    // Save the modified content
    $new_content = $dom->saveHTML();

    libxml_clear_errors(); // Clear any parsing errors
	
    return $new_content;
}
////////////////////////////////////////////////////////////////////////
function wccp_pro_is_valid_html( $content ) {
    // Create a new DOMDocument instance
    $dom = new DOMDocument();

    // Suppress warnings for invalid HTML using libxml
    libxml_use_internal_errors( true );

    // Try loading the content as HTML
    $isValid = $dom->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );

    // Clear the libxml error buffer
    libxml_clear_errors();

    // Return true if the content is valid, false otherwise
    return $isValid;
}
////////////////////////////////////////////////////////////////////////
/**
 * Helper function to add watermark parameter to a URL.
 */
function wccp_add_watermark_to_url( $url, $site_base_url, $home_url ) {
	
	//Only mask uploads (not theme or plugin images)
	if (strpos($url, '/wp-content/uploads/') === false) return $url; // Skip non-upload images
    // Parse the URL to extract the path
    $parsed_url = parse_url( $url );
	
    $relative_path = isset( $parsed_url['path'] ) ? $parsed_url['path'] : '';

	if ( ! preg_match( '#\.(jpg|jpeg|png|gif|webp)$#i', $relative_path ) ) {
		return $url;
	}

    // Remove the subdirectory if applicable
    $home_url_path = parse_url( $home_url, PHP_URL_PATH );
	
    if ( $home_url_path && strpos( $relative_path, $home_url_path ) === 0 )
	{
        $relative_path = substr( $relative_path, strlen( $home_url_path ) );
    }
	
	$img_urls_mode = "pretty"; //pretty or encrypted
	
	if ($img_urls_mode == "pretty") {
		// Ensure there's no trailing slash
		$relative_path = rtrim($relative_path, '/');

		$relative_path .= "/";

		return $site_base_url . $relative_path;
	}
	else if ($img_urls_mode == "encrypted")
	{
		$relative_path = "__enc__" . wccp_pro_encrypt_string($relative_path);
	}

    // Construct the new URL with the watermark parameter
    return $site_base_url . '/?wccp-watermark=1&src=' . $relative_path;
}
/**
 * Get a site-specific encryption key.
 *
 * @return string A unique key for encryption.
 */
function wccp_pro_get_encryption_key() {
    // Use SECURE_AUTH_KEY if it's defined
    if (defined('SECURE_AUTH_KEY') && !empty(SECURE_AUTH_KEY)) {
		return SECURE_AUTH_KEY;
    }
	//error_log("SECURE_AUTH_KEY not found");
    // Fallback: Generate a key based on the site and admin email
    $site_url = get_site_url();
    $admin_email = get_option('admin_email');
    $fallback_key = hash('sha256', $site_url . $admin_email . NONCE_SALT);
	
    return $fallback_key;
}

/**
 * Encrypt a string using a site-specific salt key and make it URL-safe.
 *
 * @param string $data The string to encrypt.
 * @return string The URL-safe encrypted string.
 */
function wccp_pro_encrypt_string($data)
{
    $key = wccp_pro_get_encryption_key();

    // Generate an initialization vector (IV) for AES-256-CBC
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($iv_length);

    // Encrypt the data
    $encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

    // Combine the IV and encrypted data
    $result = $iv . $encrypted_data;

    // Encode as URL-safe base64
    return rtrim(strtr(base64_encode($result), '+/', '-_'), '=');
}

/**
 * Decrypt a URL-safe encrypted string.
 *
 * @param string $encrypted_data The URL-safe encrypted string.
 * @return string|false The decrypted string, or false on failure.
 */
function wccp_pro_decrypt_string($encrypted_data)
{
    $key = wccp_pro_get_encryption_key();

    // Decode the URL-safe base64 string
    $data = base64_decode(strtr($encrypted_data, '-_', '+/'));

    if ($data === false) {
        error_log('Error: Failed to base64 decode encrypted data.');
        return false;
    }

    // Extract the IV and encrypted data
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    if (strlen($data) < $iv_length) {
        error_log('Error: Encrypted data is too short for the IV length.');
        return false;
    }

    $iv = substr($data, 0, $iv_length);
    $encrypted_data = substr($data, $iv_length);

    // Decrypt the data
    $decrypted_data = openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);

    if ($decrypted_data === false) {
        error_log('Error: openssl_decrypt() failed. Possible key/IV mismatch.');
    }

    return $decrypted_data;
}
