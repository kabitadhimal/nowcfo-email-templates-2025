<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // composer autoload


function sendEMail($to, $subject, $templatePath, $recipients,$data = []) {
    $mail = new PHPMailer(true);
    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.sendgrid.net';
        $mail->Port = 587;                 // or 465 for SSL
        $mail->SMTPSecure = 'tls';         // or 'ssl'
        $mail->SMTPAuth = true;

        // SendGrid uses "apikey" as the username, and the API key as the password
        $mail->Username = 'apikey';
        $mail->Password = ''; // your real API key

        // Sender and recipient
        $mail->setFrom('no-reply@yourdomain.com', 'Devfinity');
        
           // 👇 Array of recipients
            $recipients = [
                'kdhimal@devfinity.com',
               // 'sbarber@devfinity.io',
               // 'ari.horton@devfinity.com'
            ];

            // 👇 Loop through array and add each address
            foreach ($recipients as $email) {
                $mail->addAddress($email);
            }


        // Content
        $mail->isHTML(true);

        $mail->setFrom('no-reply@email.test','Devfinity');
        $mail->addAddress($to,'himalisov@gmail.com');
        $html = file_get_contents($templatePath);
       // $html = file_get_contents(__DIR__.'/mail-1/mail-1.html');
        

        $mail->isHTML(true);
        $mail->Subject = $subject;
      //  $mail->Body = '<h1>Hello</h1><p>Test via Mailpit (no auth)</p>';
       // $mail->AltBody = 'Hello — test via Mailpit (no auth)';

        $mail->Body = $html;


        if ($mail->send()) {
            echo "Sent (captured by Mailpit)\n";
        } else {
            echo "Error: {$mail->ErrorInfo}\n";
        }


    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}\n";
    }
}



    //$templatePath = __DIR__ . "/test-old-emails/mail_5_2_fixed_for_dark_mode.html";
    $templatePath = __DIR__ . "/simple-email-template/simple-email-template-new.html";

   //$templatePath = __DIR__ . "/mail-3/v3-mail-3.html";

   // echo $templatePath;

    // Use the subject from the array (fallback in case index missing)
    $subject =  "Simple Email Template";

    sendEmail(
        'kdhimal@devfinity.com',
        $subject,
        $templatePath,
        ['name' => 'Kabita']
    );


// Define subjects for each email

/*
$subjects = [
    1 => "Do not Let Year-End Overwhelm Your Finance Team",
    2 => "NOW CFO helps businesses wrap up",
    3 => "Year-end is crunch time, and your finance team feels it.",
];

for ($i = 1; $i <= 3; $i++) {
    $templatePath = __DIR__ . "/mail-{$i}/v3-mail-{$i}.html";

    // Use the subject from the array (fallback in case index missing)
    $subject = isset($subjects[$i]) ? $subjects[$i] : "Email Template Test - {$i}";

    sendEmail(
        'kdhimal@devfinity.com',
        $subject,
        $templatePath,
        ['name' => 'Kabita']
    );
}
    */

