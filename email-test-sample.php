<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // composer autoload


function sendEmail($to, $subject, $templatePath, $recipients = [], $data = [])
{
    $mail = new PHPMailer(true);

    try {
        // SMTP config
        $mail->isSMTP();
        $mail->Host = 'smtp.sendgrid.net';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;

        /*  
         * SendGrid login
         * Username is always 'apikey'
         * password: add you sendgrid api key as a password
         * 
         */
        $mail->Username = 'apikey';
        $mail->Password = ''; 

        /**
         * IMPORTANT:
         * This MUST be a verified sender identity in SendGrid
         */
        $mail->setFrom('no-reply@testemailtemplate.com', 'Devfinity');

        // Add main recipient
        if (!empty($to)) {
            $mail->addAddress($to);
        }

        // Add multiple recipients (if provided)
        if (!empty($recipients) && is_array($recipients)) {
            foreach ($recipients as $email) {
                $mail->addAddress($email);
            }
        }

        // Load email template
        $html = file_get_contents($templatePath);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html;

        // Send
        if ($mail->send()) {
            echo "Email sent successfully.";
        } else {
            echo "Error: {$mail->ErrorInfo}";
        }

    } catch (Exception $e) {
        echo "Mailer Error: {$e->getMessage()}";
    }
}

// Example usage
$templatePath = __DIR__ . "/simple-email-template/simple-email-template.html";

sendEmail(
    "himalisov@gmail.com",                       // primary recipient
    "Simple Email Template",                     // subject
    $templatePath,      
    ["kdhimal@devfinity.com"]                   // extra recipients
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

