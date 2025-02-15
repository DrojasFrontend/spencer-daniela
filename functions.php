<?php

define('URL_BASE', get_stylesheet_directory_uri() . '/');
define('IMG_BASE', URL_BASE . 'img/');

// Configuración SMTP para WordPress
add_action('phpmailer_init', 'configurar_smtp');
function configurar_smtp($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.hostinger.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 465;
    $phpmailer->Username = 'rsvp@spenceranddanielawedding.com';
    $phpmailer->Password = 'Ad;30cK4O6P5';
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->From = 'rsvp@spenceranddanielawedding.com';
    $phpmailer->FromName = 'Daniela & Spencer\'s wedding';
}

// Agregar logging para debuggear emails
if (!function_exists('log_mailer_errors')) {
    function log_mailer_errors($wp_error) {
        $file = fopen(ABSPATH . '/wp-content/mail-errors.log', 'a');
        fputs($file, "Mailer Error: " . $wp_error->get_error_message() ."\n");
        fclose($file);
    }
    add_action('wp_mail_failed', 'log_mailer_errors', 10, 1);
}

function enqueue_webpack_scripts() {
    $cssFilePath = glob( get_template_directory() . '/css/build/main.min.*.css' );
    $cssFileURI = get_template_directory_uri() . '/css/build/' . basename($cssFilePath[0]);
    wp_enqueue_style( 'main_css', $cssFileURI );

    $jsFilePath = glob( get_template_directory() . '/js/build/main.min.*.js' );
    $jsFileURI = get_template_directory_uri() . '/js/build/' . basename($jsFilePath[0]);
    wp_enqueue_script( 'main_js', $jsFileURI , null , null , true );

    wp_localize_script('main_js', 'wpData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('rsvp_nonce')
    ));
}
add_action( 'wp_enqueue_scripts', 'enqueue_webpack_scripts' );

// Agregar scripts necesarios
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('invitados-data', get_template_directory_uri() . '/data/invitados.js', [], '2.0', true);
    wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?render=6Lf-UdIqAAAAAMUnAwZ3LO0lInGTx667TNOqGkEA', [], null, true);
});

// RSVP Email Handler
add_action('wp_ajax_send_rsvp_email', 'send_rsvp_email');
add_action('wp_ajax_nopriv_send_rsvp_email', 'send_rsvp_email');

function send_rsvp_email() {
    try {
        // Verificar nonce
        check_ajax_referer('rsvp_nonce', 'nonce');

        if (!isset($_POST['rsvp_data']) || !isset($_POST['recaptcha_response'])) {
            wp_send_json_error('Missing required data');
            return;
        }

        // Verificar reCAPTCHA
        $recaptcha_verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret' => '6Lf-UdIqAAAAAEODRK41ycVHN4DBgFeAA-XQaevb',
                'response' => sanitize_text_field($_POST['recaptcha_response'])
            ]
        ]);

        $verify_response = json_decode(wp_remote_retrieve_body($recaptcha_verify));
        
        if (is_wp_error($recaptcha_verify) || !$verify_response || !$verify_response->success) {
            wp_send_json_error('reCAPTCHA verification failed');
            return;
        }

        $rsvp_data = json_decode(stripslashes($_POST['rsvp_data']), true);

        // Configuración del correo
        $to_admin = 'rsvp@spenceranddanielawedding.com';
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: "Daniela & Spencer\'s wedding" <rsvp@spenceranddanielawedding.com>'
        );

        // Construir tabla de invitados para el email admin
        $guests_table = "<table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
            <tr style='background: #f0f0f0;'>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Guest</th>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Wedding</th>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Menu Selection</th>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Cocktail</th>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Beach Day</th>
            </tr>";

        foreach ($rsvp_data['invitados'] as $invitado) {
            $menu_selection = isset($invitado['menu']) ? ucfirst($invitado['menu']) : 'Not selected';
            $guests_table .= "<tr>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$invitado['nombre']}</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . (isset($invitado['wedding']) ? ($invitado['wedding'] ? 'Confirmed' : 'Declined') : 'N/A') . "</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$menu_selection}</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . (isset($invitado['cocktail']) ? ($invitado['cocktail'] ? 'Confirmed' : 'Declined') : 'N/A') . "</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . (isset($invitado['beach']) ? ($invitado['beach'] ? 'Confirmed' : 'Declined') : 'N/A') . "</td>
            </tr>";
        }
        $guests_table .= "</table>";

        // Email para admin
        $subject_admin = 'New RSVP Confirmation - ' . $rsvp_data['invitados'][0]['nombre'];
        $message_admin = "
        <html>
        <body style='font-family: Arial, sans-serif;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: #333;'>New RSVP Confirmation</h2>
                <div style='background: #f5f5f5; padding: 20px; border-radius: 5px;'>
                    <h3>Guest Confirmations</h3>
                    {$guests_table}
                    <div style='margin-top: 20px;'>
                        <p><strong>Address:</strong> {$rsvp_data['phone']}</p>
                        <p><strong>Email:</strong> {$rsvp_data['email']}</p>
                        <p><strong>Song:</strong> {$rsvp_data['play']}</p>
                        <p><strong>Restrictions:</strong> {$rsvp_data['restrictions']}</p>
                    </div>
                </div>
            </div>
        </body>
        </html>";

        // Construir lista de eventos confirmados para el email del invitado
        $confirmed_events = "";
        foreach ($rsvp_data['invitados'] as $invitado) {
            $confirmed_events .= "<div style='margin: 15px 0; padding: 15px; background: #fff; border-radius: 5px;'>";
            $confirmed_events .= "<h4 style='margin: 0 0 10px 0;'>{$invitado['nombre']}</h4>";
            
            if (isset($invitado['wedding']) && $invitado['wedding']) {
                $confirmed_events .= "
                <p><strong>Wedding</strong><br>
                May 25th, 2025<br>
                5:00 P.M.<br>
                Sofitel Legend Santa Clara</p>";
            }

            if (isset($invitado['cocktail']) && $invitado['cocktail']) {
                $confirmed_events .= "
                <p><strong>Welcome Cocktail</strong><br>
                May 23th, 2025<br>
                5:00 - 7:00 P.M.<br>
                El Mirador Gastro Bar</p>";
            }
            
            if (isset($invitado['beach']) && $invitado['beach']) {
                $confirmed_events .= "
                <p><strong>Beach Day Makani</strong><br>
                May 24th, 2025<br>
                9:00 P.M.<br>
                Makani Beach Club</p>";
            }

            if (isset($invitado['menu']) && $invitado['menu']) {
                $menu_text = ucfirst($invitado['menu']);
                $confirmed_events .= "
                <p><strong>Menu Selection:</strong> <br>
                {$menu_text}</p>";
            }

            $confirmed_events .= "</div>";
        }

        // Email for guest
        $subject_guest = 'RSVP Confirmation - Daniela & Spencer\'s wedding';
        $message_guest = "
        <html>
        <body style='font-family: Arial, sans-serif;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: #333; text-align: center;'>Thank you for confirming your attendance</h2>
                <div style='background: #f5f5f5; padding: 20px; border-radius: 5px; text-align: center;'>
                    <p>Dear {$rsvp_data['invitados'][0]['nombre']},</p>
                    <p>We have received your confirmation for our wedding. We are very happy to share this special day with you.</p>
                    <div style='margin: 20px 0;'>
                        <h3 style='color: #666;'>Your confirmation details:</h3>
                        {$confirmed_events}
                    </div>
                    <p>We will send you more details soon.</p>
                    <p style='margin-top: 30px;'>Best regards,<br>Daniela & Spencer</p>
                </div>
            </div>
        </body>
        </html>";

        // Enviar emails
        $admin_sent = wp_mail($to_admin, $subject_admin, $message_admin, $headers);
        $guest_sent = wp_mail($rsvp_data['email'], $subject_guest, $message_guest, $headers);

        if ($admin_sent && $guest_sent) {
            wp_send_json_success('Confirmación enviada correctamente');
        } else {
            wp_send_json_error('Error al enviar los emails');
        }

    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
    wp_die();
}

