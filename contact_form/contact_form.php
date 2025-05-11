<?php

// configure
$from = 'no-reply@yourdomain.com'; // ✅ Must be your domain's valid email
$sendTo = 'mdshamimislamapi2023@gmail.com'; // ✅ Your real inbox
$subject = 'New message from contact form';
$fields = array(
  'name' => 'Name',
  'email' => 'Email',
  'subject' => 'Subject',
  'message' => 'Message'
);
$okMessage = 'Message sent successfully. Thank you!';
$errorMessage = 'There was an error sending the message. Please try again later.';

// process form
try {
  $emailText = nl2br("You have received a new message:\n\n");

  foreach ($_POST as $key => $value) {
    if (isset($fields[$key])) {
      $emailText .= nl2br("$fields[$key]: $value\n");
    }
  }
  $headers = array(
    'Content-Type: text/html; charset="UTF-8";',
    'From: ' . $from,
    'Reply-To: ' . $_POST['email'], // ✅ user's email so you can reply
    'Return-Path: ' . $from,
  );

  mail($sendTo, $subject, $emailText, implode("\n", $headers));

  $responseArray = array('type' => 'success', 'message' => $okMessage);
} catch (\Exception $e) {
  $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  header('Content-Type: application/json');
  echo json_encode($responseArray);
} else {
  echo $responseArray['message'];
}
?>
