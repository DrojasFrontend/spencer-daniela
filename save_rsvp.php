<?php
header('Content-Type: application/json');

// Recibir datos JSON
$data = json_decode(file_get_contents('php://input'), true);

// Validar datos recibidos
if (!$data || !isset($data['invitados']) || !isset($data['email'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Preparar el mensaje de correo
$to = 'rsvp@boda.com';
$subject = 'Nueva confirmación RSVP';

$message = "Nueva confirmación de asistencia:\n\n";
$message .= "Email: " . $data['email'] . "\n";
$message .= "Teléfono: " . $data['phone'] . "\n\n";

// Procesar confirmaciones para cada invitado
$message .= "CONFIRMACIONES:\n";
$message .= "================\n\n";

foreach ($data['invitados'] as $invitado) {
    $message .= "Invitado: " . $invitado['nombre'] . "\n";
    
    // Wedding
    if (isset($invitado['wedding'])) {
        $message .= "- Boda: " . ($invitado['wedding'] ? 'Asistirá' : 'No asistirá') . "\n";
    }
    
    // Cocktail
    if (isset($invitado['cocktail'])) {
        $message .= "- Cocktail: " . ($invitado['cocktail'] ? 'Asistirá' : 'No asistirá') . "\n";
    }
    
    // Beach Day
    if (isset($invitado['beach'])) {
        $message .= "- Beach Day: " . ($invitado['beach'] ? 'Asistirá' : 'No asistirá') . "\n";
    }
    
    $message .= "\n";
}

// Agregar restricciones alimentarias si existen
if (!empty($data['restrictions'])) {
    $message .= "\nRESTRICCIONES ALIMENTARIAS:\n";
    $message .= "========================\n";
    $message .= $data['restrictions'] . "\n";
}

// Preparar headers
$headers = [
    'From' => $data['email'],
    'Reply-To' => $data['email'],
    'X-Mailer' => 'PHP/' . phpversion(),
    'Content-Type' => 'text/plain; charset=UTF-8'
];

// Enviar correo
$mailSent = mail($to, $subject, $message, implode("\r\n", array_map(
    function ($v, $k) { return "$k: $v"; },
    $headers,
    array_keys($headers)
)));

// Enviar copia al invitado
if ($mailSent) {
    $guestSubject = 'Confirmación de tu RSVP - Daniela & Spencer';
    $guestMessage = "¡Gracias por confirmar tu asistencia!\n\n";
    $guestMessage .= "Hemos recibido tu RSVP con los siguientes detalles:\n\n";
    $guestMessage .= $message;
    $guestMessage .= "\nSi necesitas hacer algún cambio, por favor contáctanos.\n";
    
    mail($data['email'], $guestSubject, $guestMessage, implode("\r\n", array_map(
        function ($v, $k) { return "$k: $v"; },
        $headers,
        array_keys($headers)
    )));
}

// Responder al cliente
if ($mailSent) {
    echo json_encode([
        'success' => true, 
        'message' => 'Tu confirmación ha sido enviada exitosamente'
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Hubo un error al enviar tu confirmación. Por favor intenta nuevamente.'
    ]);
}
?>