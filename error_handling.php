<?php
// Function to handle errors and redirect to appropriate error pages
function handle_error($error_message)
{
    // Check if the error message contains specific keywords to determine the error type
    if (strpos($error_message, 'Incorrect password') !== false) {
        // Redirect to 401 error page if the error message indicates incorrect password
        header('Location: error-401.html');
        exit();
    } elseif (strpos($error_message, 'Username not found') !== false) {
        // Redirect to 404 error page if the error message indicates username not found
        header('Location: error-404.html');
        exit();
    } elseif (strpos($error_message, 'Email not found') !== false) {
        // Redirect to 404 error page if the error message indicates email not found
        header('Location: error-404.html');
        exit();
    }
}

if (count($errors) > 0) {
    // If there are errors, handle each error individually
    foreach ($errors as $error) {
        // Output the error message
        echo "<p style='color: red; text-align: center'>$error</p>";
        
        // Handle the error by redirecting to appropriate error page
        handle_error($error);
    }
}
?>