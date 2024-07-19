<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "theboysofce@gmail.com";
    $email_subject = "Zeel Logistics Website Queries";

    function died($error)
    {
        // your error code can go here
        echo json_encode(array("error" => $error));
        exit(); // Terminate script
    }

    // validation expected data exists
    if (
        !isset($_POST['name']) ||
        !isset($_POST['lastname']) ||
        !isset($_POST['email']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['message'])
    ) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $first_name = $_POST['name']; // required
    $last_name = $_POST['lastname']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['phone']; // not required
    $comments = $_POST['message']; // required

    // Clean input to prevent injection
    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    // Construct email message
    $email_message = "Form details below.\n\n";
    $email_message .= "First Name: " . clean_string($first_name) . "\n";
    $email_message .= "Last Name: " . clean_string($last_name) . "\n";
    $email_message .= "Email: " . clean_string($email_from) . "\n";
    $email_message .= "Telephone: " . clean_string($telephone) . "\n";
    $email_message .= "Comments: " . clean_string($comments) . "\n";

    // create email headers
    $headers = 'From: ' . $email_from . "\r\n" .
        'Reply-To: ' . $email_from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Sending email
    if (@mail($email_to, $email_subject, $email_message, $headers)) {
        echo json_encode(array("success" => "Your message has been sent."));
    } else {
        echo json_encode(array("error" => "There was a problem sending your message."));
    }
    exit; // Terminate script after sending email
}
?>
