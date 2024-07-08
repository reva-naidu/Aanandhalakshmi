<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require './autoload.php';



   #Cleaning Html,Script Tags and special characters
   function postTextClean($text) {
      $text            = trim(addslashes(htmlspecialchars(strip_tags($_POST[$text]))));
      return $text;
   }

   function getTextClean($text) {
      $text            = trim(addslashes(htmlspecialchars(strip_tags($_GET[$text]))));
      $search          = array('Ã‡','Ã§','Äž','ÄŸ','Ä±','Ä°','Ã–','Ã¶','Åž','ÅŸ','Ãœ','Ã¼');
      $replace         = array('c','c','g','g','i','i','o','o','s','s','u','u');
      $new_text        = str_replace($search,$replace,$text);
      return $new_text;
   }

   $getActionURI       = getTextClean('mail');


      #Let's get the data from the form   
      $name             = postTextClean('name');
      $email            = postTextClean('email');
      $phone_number     = postTextClean('phone');
      $msg_subject      = "";
      $formName         = postTextClean('formName');
      $message          = postTextClean('message');
      $mail_content     = "<h2>Name</h2>
                           <p>{$name}</p>
                           <h2>Email</h2>
                           <p>{$email}</p>
                           <h2>Phone</h2>
                           <p>{$phone_number}</p>
                           <h2>Subject</h2>
                           <p>{$msg_subject}</p>                           
                           <h2>Message</h2>
                           <p>".nl2br($message)."</p>";

      // Hosting SMTP Settings
      $smtp_host        = 'smtp.gmail.com';                         // Enter the smtp server address you got from your hosting here
      $smtp_port        =  587;                                        // TCP port to connect to
      $smtp_username    = 'info@aanandalakshmi.com';             // SMTP username
      $smtp_password    = 'rrsbkldlscdrrhbe';                         // SMTP password

      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);

      try {
         // //Server settings
         // $mail->isSMTP();                                                 
         // $mail->SMTPAuth   = true;                        
         // $mail->Host       = $smtp_host;                     
         // $mail->Username   = $smtp_username;                   
         // $mail->Password   = $smtp_password;               
         // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         // $mail->Port       = $smtp_port;                                    
         // $mail->CharSet    = "UTF-8";                              
         // $mail->setFrom($smtp_username, $contact_subject);
         // $mail->addAddress("info@aanandalakshmi.com");                  // Enter the email address you want to send here
         // $mail->addReplyTo($email, $name);

         // // Content
         // $mail->isHTML(true);                                  
         // $mail->Subject = "GetVCFO Contact Query";
         // $mail->Body    = $mail_content;
         // $mail->AltBody = strip_tags($mail_content);
         // $mail->send();
         // $message       = true;
         // echo $message;   

         $mail->isSMTP();                                                 
    $mail->SMTPAuth   = true;                        
    $mail->Host       = $smtp_host;                     
    $mail->Username   = $smtp_username;                   
    $mail->Password   = $smtp_password;               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $smtp_port;                                    
    $mail->CharSet    = "UTF-8";                              
    $mail->setFrom($smtp_username, $contact_subject);
    $mail->addAddress("info@aanandalakshmi.com");                  // Enter the email address you want to send here
    $mail->addReplyTo($email, $name);

    // Content for the first email
    $mail->isHTML(true);                                  
    $mail->Subject = "Aanandalakshmi Spinning Mills ($formName)";
    $mail->Body    = $mail_content;
    $mail->AltBody = strip_tags($mail_content);
    $mail->send();
    
    // Prepare the mailer for the second email
    $mail->clearAddresses();
    $mail->clearReplyTos();

    // Server settings for the second email
    $mail->setFrom($smtp_username, $contact_subject);
    $mail->addAddress($email);  // Email address from the $email variable
    $mail->addReplyTo($smtp_username, "Aanandalakshmi Spinning Mills");

    // Content for the second email
    $mail->isHTML(true);                                  
    $mail->Subject = "Aanandalakshmi Spinning Mills ($formName)";
    $mail->Body    = "Thank you for submitting the form. Our team will reach out to you for further updates.<br><br>Aanandalakshmi Spinning Mills";
    $mail->AltBody = "Thank you for submitting the form. Our team will reach out to you for further updates.\n\nAanandalakshmi Spinning Mills";
    $mail->send();
    
    $message = true;
    echo $message;
      } catch (Exception $e) {
        $message       = false;
        echo $message;
        echo "Mailer Error: {$mail->ErrorInfo}";
      }
    header('Location: index.html');

?>
