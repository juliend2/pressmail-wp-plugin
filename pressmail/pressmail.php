<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pressmail.co/
 * @since             1.0.0
 * @package           Pressmail
 *
 * @wordpress-plugin
 * Plugin Name:       Pressmail
 * Plugin URI:        https://pressmail.co/
 * Description:       The simplest way to send emails from your WordPress site. No SMTP or DNS to manage.
 * Version:           1.0.0
 * Author:            Pressmail
 * Author URI:        https://pressmail.co/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pressmail
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRESSMAIL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pressmail-activator.php
 */
function activate_pressmail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressmail-activator.php';
	Pressmail_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pressmail-deactivator.php
 */
function deactivate_pressmail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressmail-deactivator.php';
	Pressmail_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pressmail' );
register_deactivation_hook( __FILE__, 'deactivate_pressmail' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pressmail.php';





// COPY PASTED:
add_action( 'admin_menu', 'pressmail_add_admin_menu' );
add_action( 'admin_init', 'pressmail_settings_init' );


function pressmail_add_admin_menu(  ) { 

	add_options_page( 'Pressmail', 'Pressmail', 'manage_options', 'pressmail', 'pressmail_options_page' );

}


function pressmail_settings_init(  ) { 


    if (!get_option('pressmail_settings')) {
        add_option( 'pressmail_settings', [
            'pressmail_field_sender_key' => ''
        ]);
    }
	register_setting( 'pm_settings', 'pressmail_settings' );

	add_settings_section(
		'pressmail_pm_settings_section', 
		__( 'Pressmail Plugin Settings', 'pressmail' ), 
		'pressmail_settings_section_callback', 
		'pm_settings'
	);

	add_settings_field( 
		'pressmail_field_sender_key', 
		__( 'Sender Key', 'pressmail' ), 
		'pressmail_field_sender_key_render', 
		'pm_settings', 
		'pressmail_pm_settings_section' 
	);


}


function pressmail_field_sender_key_render(  ) { 

	$options = get_option( 'pressmail_settings' );
    // var_dump($options);
	?>
	<input type='text' name='pressmail_settings[pressmail_field_sender_key]' value='<?php echo $options['pressmail_field_sender_key']; ?>' placeholder="a0b1c2d3e4f5...">
    <p>Find it in <a href="https://www.pressmail.co/profile/" target="_blank">your user's profile</a></p>
	<?php

}


function pressmail_settings_section_callback(  ) { 

	// echo __( 'This section description', 'pressmail' );

}


function pressmail_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h2>Pressmail</h2>

			<?php
			settings_fields( 'pm_settings' );
			do_settings_sections( 'pm_settings' );
			submit_button();
			?>

		</form>
		<?php

}
// END COPY PASTED





/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pressmail() {

	$plugin = new Pressmail();
	$plugin->run();

}
run_pressmail();



if (!function_exists('wp_mail')) {
// Pluggable function... Plugged:
function wp_mail( $to, $subject, $message, $headers = '', $attachments = array() ) {
    // Compact the input, apply the filters, and extract them back out.
 
    /**
     * Filters the wp_mail() arguments.
     *
     * @since 2.2.0
     *
     * @param array $args {
     *     Array of the `wp_mail()` arguments.
     *
     *     @type string|string[] $to          Array or comma-separated list of email addresses to send message.
     *     @type string          $subject     Email subject.
     *     @type string          $message     Message contents.
     *     @type string|string[] $headers     Additional headers.
     *     @type string|string[] $attachments Paths to files to attach.
     * }
     */
    $atts = apply_filters( 'wp_mail', compact( 'to', 'subject', 'message', 'headers', 'attachments' ) );
 
    /**
     * Filters whether to preempt sending an email.
     *
     * Returning a non-null value will short-circuit {@see wp_mail()}, returning
     * that value instead. A boolean return value should be used to indicate whether
     * the email was successfully sent.
     *
     * @since 5.7.0
     *
     * @param null|bool $return Short-circuit return value.
     * @param array     $atts {
     *     Array of the `wp_mail()` arguments.
     *
     *     @type string|string[] $to          Array or comma-separated list of email addresses to send message.
     *     @type string          $subject     Email subject.
     *     @type string          $message     Message contents.
     *     @type string|string[] $headers     Additional headers.
     *     @type string|string[] $attachments Paths to files to attach.
     * }
     */
    $pre_wp_mail = apply_filters( 'pre_wp_mail', null, $atts );
 
    if ( null !== $pre_wp_mail ) {
        return $pre_wp_mail;
    }
 
    if ( isset( $atts['to'] ) ) {
        $to = $atts['to'];
    }
 
    if ( ! is_array( $to ) ) {
        $to = explode( ',', $to );
    }
 
    if ( isset( $atts['subject'] ) ) {
        $subject = $atts['subject'];
    }
 
    if ( isset( $atts['message'] ) ) {
        $message = $atts['message'];
    }
 
    if ( isset( $atts['headers'] ) ) {
        $headers = $atts['headers'];
    }
 
    if ( isset( $atts['attachments'] ) ) {
        $attachments = $atts['attachments'];
    }
 
    if ( ! is_array( $attachments ) ) {
        $attachments = explode( "\n", str_replace( "\r\n", "\n", $attachments ) );
    }
    // global $phpmailer;
 
    // (Re)create it, if it's gone missing.
    // if ( ! ( $phpmailer instanceof PHPMailer\PHPMailer\PHPMailer ) ) {
    //     require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
    //     require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
    //     require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
    //     $phpmailer = new PHPMailer\PHPMailer\PHPMailer( true );
 
    //     $phpmailer::$validator = static function ( $email ) {
    //         return (bool) is_email( $email );
    //     };
    // }
 
    // Headers.
    $cc       = array();
    $bcc      = array();
    $reply_to = array();
 
    if ( empty( $headers ) ) {
        $headers = array();
    } else {
        if ( ! is_array( $headers ) ) {
            // Explode the headers out, so this function can take
            // both string headers and an array of headers.
            $tempheaders = explode( "\n", str_replace( "\r\n", "\n", $headers ) );
        } else {
            $tempheaders = $headers;
        }
        $headers = array();
 
        // If it's actually got contents.
        if ( ! empty( $tempheaders ) ) {
            // Iterate through the raw headers.
            foreach ( (array) $tempheaders as $header ) {
                if ( strpos( $header, ':' ) === false ) {
                    if ( false !== stripos( $header, 'boundary=' ) ) {
                        $parts    = preg_split( '/boundary=/i', trim( $header ) );
                        $boundary = trim( str_replace( array( "'", '"' ), '', $parts[1] ) );
                    }
                    continue;
                }
                // Explode them out.
                list( $name, $content ) = explode( ':', trim( $header ), 2 );
 
                // Cleanup crew.
                $name    = trim( $name );
                $content = trim( $content );
 
                switch ( strtolower( $name ) ) {
                    // Mainly for legacy -- process a "From:" header if it's there.
                    case 'from':
                        $bracket_pos = strpos( $content, '<' );
                        if ( false !== $bracket_pos ) {
                            // Text before the bracketed email is the "From" name.
                            if ( $bracket_pos > 0 ) {
                                $from_name = substr( $content, 0, $bracket_pos - 1 );
                                $from_name = str_replace( '"', '', $from_name );
                                $from_name = trim( $from_name );
                            }
 
                            $from_email = substr( $content, $bracket_pos + 1 );
                            $from_email = str_replace( '>', '', $from_email );
                            $from_email = trim( $from_email );
 
                            // Avoid setting an empty $from_email.
                        } elseif ( '' !== trim( $content ) ) {
                            $from_email = trim( $content );
                        }
                        break;
                    case 'content-type':
                        if ( strpos( $content, ';' ) !== false ) {
                            list( $type, $charset_content ) = explode( ';', $content );
                            $content_type                   = trim( $type );
                            if ( false !== stripos( $charset_content, 'charset=' ) ) {
                                $charset = trim( str_replace( array( 'charset=', '"' ), '', $charset_content ) );
                            } elseif ( false !== stripos( $charset_content, 'boundary=' ) ) {
                                $boundary = trim( str_replace( array( 'BOUNDARY=', 'boundary=', '"' ), '', $charset_content ) );
                                $charset  = '';
                            }
 
                            // Avoid setting an empty $content_type.
                        } elseif ( '' !== trim( $content ) ) {
                            $content_type = trim( $content );
                        }
                        break;
                    case 'cc':
                        $cc = array_merge( (array) $cc, explode( ',', $content ) );
                        break;
                    case 'bcc':
                        $bcc = array_merge( (array) $bcc, explode( ',', $content ) );
                        break;
                    case 'reply-to':
                        $reply_to = array_merge( (array) $reply_to, explode( ',', $content ) );
                        break;
                    default:
                        // Add it to our grand headers array.
                        $headers[ trim( $name ) ] = trim( $content );
                        break;
                }
            }
        }
    }
 
    // Empty out the values that may be set.
    // $phpmailer->clearAllRecipients();
    // $phpmailer->clearAttachments();
    // $phpmailer->clearCustomHeaders();
    // $phpmailer->clearReplyTos();
 
    // Set "From" name and email.
 
    // If we don't have a name from the input headers.
    if ( ! isset( $from_name ) ) {
        $from_name = 'Pressmail';
    }
 
    /*
     * If we don't have an email from the input headers, default to wordpress@$sitename
     * Some hosts will block outgoing mail from this address if it doesn't exist,
     * but there's no easy alternative. Defaulting to admin_email might appear to be
     * another option, but some hosts may refuse to relay mail from an unknown domain.
     * See https://core.trac.wordpress.org/ticket/5007.
     */
    if ( ! isset( $from_email ) ) {
        $from_email = 'sender@pressmail.co';
    }
 
    /**
     * Filters the email address to send from.
     *
     * @since 2.2.0
     *
     * @param string $from_email Email address to send from.
     */
    $from_email = apply_filters( 'wp_mail_from', $from_email );
 
    /**
     * Filters the name to associate with the "from" email address.
     *
     * @since 2.3.0
     *
     * @param string $from_name Name associated with the "from" email address.
     */
    $from_name = apply_filters( 'wp_mail_from_name', $from_name );
  
    // // Set mail's subject and body.
    // $phpmailer->Subject = $subject;
    // $phpmailer->Body    = $message;
 
    // Set destination addresses, using appropriate methods for handling addresses.
    $address_headers = compact( 'to', 'cc', 'bcc', 'reply_to' );
 
    foreach ( $address_headers as $address_header => $addresses ) {
        if ( empty( $addresses ) ) {
            continue;
        }
 
        foreach ( (array) $addresses as $address ) {
            // try {
            //     // Break $recipient into name and address parts if in the format "Foo <bar@baz.com>".
            //     $recipient_name = '';
 
            //     if ( preg_match( '/(.*)<(.+)>/', $address, $matches ) ) {
            //         if ( count( $matches ) == 3 ) {
            //             $recipient_name = $matches[1];
            //             $address        = $matches[2];
            //         }
            //     }
 
            //     switch ( $address_header ) {
            //         case 'to':
            //             $phpmailer->addAddress( $address, $recipient_name );
            //             break;
            //         case 'cc':
            //             $phpmailer->addCc( $address, $recipient_name );
            //             break;
            //         case 'bcc':
            //             $phpmailer->addBcc( $address, $recipient_name );
            //             break;
            //         case 'reply_to':
            //             $phpmailer->addReplyTo( $address, $recipient_name );
            //             break;
            //     }
            // } catch ( PHPMailer\PHPMailer\Exception $e ) {
            //     continue;
            // }
        }
    }
 
    // Set to use PHP's mail().
    // $phpmailer->isMail();
 
    // Set Content-Type and charset.
 
    // If we don't have a content-type from the input headers.
    if ( ! isset( $content_type ) ) {
        $content_type = 'text/plain';
    }
 
    /**
     * Filters the wp_mail() content type.
     *
     * @since 2.3.0
     *
     * @param string $content_type Default wp_mail() content type.
     */
    $content_type = apply_filters( 'wp_mail_content_type', $content_type );
 
    // $phpmailer->ContentType = $content_type;
 
    // Set whether it's plaintext, depending on $content_type.
    if ( 'text/html' === $content_type ) {
        // $phpmailer->isHTML( true );
    }
 
    // If we don't have a charset from the input headers.
    if ( ! isset( $charset ) ) {
        $charset = get_bloginfo( 'charset' );
    }
 
    /**
     * Filters the default wp_mail() charset.
     *
     * @since 2.3.0
     *
     * @param string $charset Default email charset.
     */
    // $phpmailer->CharSet = apply_filters( 'wp_mail_charset', $charset );
 
    // Set custom headers.
    // if ( ! empty( $headers ) ) {
    //     foreach ( (array) $headers as $name => $content ) {
    //         // Only add custom headers not added automatically by PHPMailer.
    //         if ( ! in_array( $name, array( 'MIME-Version', 'X-Mailer' ), true ) ) {
    //             try {
    //                 $phpmailer->addCustomHeader( sprintf( '%1$s: %2$s', $name, $content ) );
    //             } catch ( PHPMailer\PHPMailer\Exception $e ) {
    //                 continue;
    //             }
    //         }
    //     }
 
    //     if ( false !== stripos( $content_type, 'multipart' ) && ! empty( $boundary ) ) {
    //         $phpmailer->addCustomHeader( sprintf( 'Content-Type: %s; boundary="%s"', $content_type, $boundary ) );
    //     }
    // }
 
    if ( ! empty( $attachments ) ) {
        foreach ( $attachments as $attachment ) {
            // try {
            //     $phpmailer->addAttachment( $attachment );
            // } catch ( PHPMailer\PHPMailer\Exception $e ) {
            //     continue;
            // }
        }
    }
 
    /**
     * Fires after PHPMailer is initialized.
     *
     * @since 2.2.0
     *
     * @param PHPMailer $phpmailer The PHPMailer instance (passed by reference).
     */
    // do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );
 
    $mail_data = compact( 'to', 'subject', 'message', 'headers', 'attachments' );

    $options = get_option('pressmail_settings');
    $api_token = $options['pressmail_field_sender_key'];
 
    write_log('Envoi du email...');
    // $api_token = 
    // Send!
    try {
        // $send = $phpmailer->send();
        // wp_remote_post( "https://my.statusmachine.com/api/v1/wp_notify?token=".$api_token,
	    wp_remote_post("https://api.pressmail.co/api/v1/send",
            [
                'headers' => [
                    'Authorization' => "Bearer ".$api_token,
                ],
                'body' => [
                    'to' => $to,
                    'subject' => $subject,
                    'body' => $message,
                ],
                'method'      => 'POST',
                // 'data_format' => 'body',
            ]
        );
        $send = true;

        write_log('Envoi du email... TRY!');
        write_log('to: '. print_r($to, 1));
        write_log('subject: '. $subject);
        write_log('message: '. $message);
 
        /**
         * Fires after PHPMailer has successfully sent a mail.
         *
         * The firing of this action does not necessarily mean that the recipient received the
         * email successfully. It only means that the `send` method above was able to
         * process the request without any errors.
         *
         * @since 5.9.0
         *
         * @param array $mail_data An array containing the mail recipient, subject, message, headers, and attachments.
         */
        do_action( 'wp_mail_succeeded', $mail_data );
 
        return $send;
    } catch ( Exception $e ) {
        $mail_data['pressmail_exception_code'] = $e->getCode();

        write_log('Envoi du email... CATCH!');
        write_log($e);

        /**
         * Fires after a PHPMailer\PHPMailer\Exception is caught.
         *
         * @since 4.4.0
         *
         * @param WP_Error $error A WP_Error object with the PHPMailer\PHPMailer\Exception message, and an array
         *                        containing the mail recipient, subject, message, headers, and attachments.
         */
        do_action( 'wp_mail_failed', new WP_Error( 'wp_mail_failed', $e->getMessage(), $mail_data ) );
 
        return false;
    }
}
} // END function_exists( 'wp_mail' )


if (!function_exists('write_log')) {

    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}