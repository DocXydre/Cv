<?php
/**
 * Traitement du formulaire de contact
 */
function process_contact_form() {
    // Ajout de logs pour le débogage
    error_log('Traitement du formulaire de contact démarré');
    
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'contact_form')) {
        error_log('Échec de vérification du nonce');
        return [
            'success' => false,
            'message' => 'Vérification de sécurité échouée.'
        ];
    }

    // Récupérer et nettoyer les données
    $name = sanitize_text_field($_POST['name']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    error_log("Données reçues - Nom: $name, Sujet: $subject");
    
    // Validation des données
    if (empty($name) || empty($subject) || empty($message)) {
        return [
            'success' => false,
            'message' => 'Veuillez remplir tous les champs du formulaire.'
        ];
    }
    
    // Configuration de l'email
    $to = 'tmathis.dev@gmail.com'; 
    $email_subject = "Message de contact: $subject";
    $email_message = "Nom: $name\n\n";
    $email_message .= "Message:\n$message";
    $headers = "From: " . get_bloginfo('name') . " <wordpress@" . parse_url(home_url(), PHP_URL_HOST) . ">\r\n";
    
    error_log("Tentative d'envoi d'email à: $to avec sujet: $email_subject");
    
    // Envoi de l'email
    $mail_sent = wp_mail($to, $email_subject, $email_message, $headers);
    
    error_log("Résultat d'envoi d'email: " . ($mail_sent ? 'Succès' : 'Échec'));
    
    if ($mail_sent) {
        return [
            'success' => true,
            'message' => 'Votre message a bien été envoyé. Merci de m\'avoir contacté!'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Une erreur est survenue lors de l\'envoi du message.'
        ];
    }
}