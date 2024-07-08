<?php

if (isset($_POST['email'])) {

    $email_to = "info@avtcs.com";
    $email_subject = "AVTCS Website- Contact Form";

    function died($error) {
        echo '<div class="alert alert-danger alert-dismissible wow fadeInUp" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Something is wrong:</strong><br>';
        echo $error . "<br />";
        echo '</div>';
        die();
    }

    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $telephone = isset($_POST['phone']) ? $_POST['phone'] : ''; // not required
    $message = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";
    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br />';
    }

    if (strlen($message) < 2) {
        $error_message .= 'The message you entered does not appear to be valid.<br />';
    }

    if (strlen($error_message) > 0) {
        died($error_message);
    }

    $email_message = "Form details below.\n\n";
    $email_message .= "Name: " . htmlspecialchars($name) . "\n";
    $email_message .= "Email: " . htmlspecialchars($email_from) . "\n";
    $email_message .= "Telephone: " . htmlspecialchars($telephone) . "\n";
    $email_message .= "Message: " . htmlspecialchars($message) . "\n";

    $sender_email = "info@aanandalakshmi.com";

    $headers = 'From: ' . $sender_email . "\r\n" .
               'Reply-To: ' . $email_from . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    $success = mail($email_to, $email_subject, $email_message, $headers);

    if ($success) {
        echo '<div class="alert alert-success alert-dismissible wow fadeInUp" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Your message has been sent.
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible wow fadeInUp" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Message could not be sent. Please try again later.
              </div>';
    }
}
?>
