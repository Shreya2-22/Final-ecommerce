<?php
// pass_reset_email.php
session_start();
require 'includes/connect.php';

// Validate parameters
$token  = $_GET['token']  ?? '';
$userId = (int)($_GET['id'] ?? 0);
$email  = $_GET['email']  ?? '';

if (!$token || !$userId || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['failmessage'] = 'Invalid reset request.';
    header('Location: pass_reset.php');
    exit;
}

// Build link to pass_change.php
$resetUrl = sprintf(
    'http://%s/Cleck-E-Mart/pass_change.php?token=%s&id=%d',
    $_SERVER['HTTP_HOST'],
    urlencode($token),
    $userId
);

require 'smtp/PHPMailerAutoload.php';
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'cleckemart@gmail.com';
$mail->Password   = 'gtqnoxoosxfcdmxa';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;

$mail->setFrom('cleckemart@gmail.com','Cleck-E-Mart');
$mail->addAddress($email);
$mail->isHTML(true);
$mail->Subject = 'Your Cleck-E-Mart Password Reset Link';

$mailBody = <<<HTML
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: sans-serif; color: #333; }
    .btn {
      display:inline-block; padding:12px 24px; background:#28a745;
      color:#fff!important; text-decoration:none; border-radius:4px;
      font-weight:bold; margin-top:1em;
    }
    .footer { margin-top:2em; font-size:0.9em; color:#666; }
  </style>
</head>
<body>
  <h2>Cleck-E-Mart Password Reset</h2>
  <p>Click the button below to reset your password:</p>
  <a href="{$resetUrl}" class="btn">Reset Password</a>
  <p class="footer">If you did not request this, simply ignore this email.</p>
</body>
</html>
HTML;

$mail->Body = $mailBody;
$mail->SMTPOptions = [
  'ssl'=> [
    'verify_peer'      => false,
    'verify_peer_name' => false,
    'allow_self_signed'=> false
  ]
];

if (!$mail->send()) {
    $_SESSION['failmessage'] = 'Mail error: ' . $mail->ErrorInfo;
    header('Location: pass_reset.php');
    exit;
}

$_SESSION['passmessage'] = 'A reset link has been sent to your email.';
header('Location: login.php');
exit;
