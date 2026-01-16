<?php
// send.php — envoi du formulaire vers alain.f.bertrand@orange.fr

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: contact.html');
  exit;
}

// Anti-spam (honeypot)
if (!empty($_POST['website'])) {
  header('Location: contact.html?error=1');
  exit;
}

$to = 'alain.f.bertrand@orange.fr';

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$subject = trim((string)($_POST['subject'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

if ($name === '' || $email === '' || $message === '') {
  header('Location: contact.html?error=1');
  exit;
}

// Validation email minimale
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header('Location: contact.html?error=1');
  exit;
}

// Nettoyage basique (évite l’injection d’en-têtes)
$bad = array("\r", "\n", "content-type:", "bcc:", "cc:", "to:");
$name = str_ireplace($bad, '', $name);
$email = str_ireplace($bad, '', $email);
$subject = str_ireplace($bad, '', $subject);

$headers = [];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/plain; charset=UTF-8';
$headers[] = 'From: Site Le Testament d’Azénor <no-reply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '>';
$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';

$body  = "Message envoyé depuis la page Contact\n\n";
$body .= "Nom : {$name}\n";
$body .= "Email : {$email}\n";
$body .= "Objet : {$subject}\n\n";
$body .= "Message :\n{$message}\n";

// Sujet mail lisible
$mailSubject = 'Contact – Le Testament d’Azénor' . ($subject ? ' — ' . $subject : '');

$ok = @mail($to, $mailSubject, $body, implode("\r\n", $headers));

header('Location: contact.html?' . ($ok ? 'sent=1' : 'error=1'));
exit;
?>