<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate the input data
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Check if any fields are empty
    if (empty($name) || empty($email) || empty($message)) {
        // Send a JSON response back to the form (AJAX)
        echo json_encode(["message" => "All fields are required."]);
        exit;
    }

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["message" => "Please provide a valid email address."]);
        exit;
    }

    // Example: Send an email with the form data (requires a valid mail configuration)
    $to = "rafimoll49@gmail.com"; // Replace with your email address
    $subject = "New Contact Form Submission";
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Set email headers
    $headers = "From: $email";

    // Use the mail() function to send the email
    if (mail($to, $subject, $email_content, $headers)) {
        echo json_encode(["message" => "Thank you for your message. We'll get back to you soon."]);
    } else {
        echo json_encode(["message" => "Oops! Something went wrong and we couldn't send your message."]);
    }

} else {
    // Return an error response if the form is not submitted via POST
    echo json_encode(["message" => "There was a problem with your submission. Please try again."]);
}
?>
