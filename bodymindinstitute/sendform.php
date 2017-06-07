<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);

        // Check that data was sent to the mailer.
        if ( empty($email) AND empty($phone)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Vyplňte jedno pole";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "info@bodymindinstitute.cz";

        // Set the email subject.
        $subject = "Message from bodymindinstitute.cz";

        // Build the email content.
        $email_content .= '<html><body>';
        $email_content .= '<h3>Message from bodymindinstitute.cz</h3>';
        $email_content .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        $email_content .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>$email</td></tr>";
        $email_content .= "<tr><td><strong>Phone:</strong> </td><td>$phone</td></tr>";
        $email_content .= "</table>";
        $email_content .= "</body></html>";

        // Build the email headers.
        $email_headers = "From: info@bodymindinstitute.cz\r\n";
        $email_headers .= "MIME-Version: 1.0\r\n";
        $email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Odesláno";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Nastala chyba";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Nastala chyba";
    }

?>