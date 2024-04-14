<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

// initializing variables
$errors = array();

// a database connection object to connect to the database
$hostelhub = mysqli_connect('localhost', 'root', 'mysql', 'hostelhub');

//Logs-------------------------------------------------------------------------------------------

// Get the IP address of the client
$ipAddress = $_SERVER['REMOTE_ADDR'];

//This function will take a message as input and append it to a log file along with the timestamp
function logEvent($message) {
    //define the file to be used as the location to put logs
    $logFile = 'security.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

// STUDENTS REGISTER----------------------------------------------------------------------------
if (isset($_POST['reg_user']))
{
   // receive all input values from the form
   $student_username = $_POST['student_username'];
   $student_email = $_POST['student_email'];
   $student_password_1 = $_POST['student_password_1'];
   $student_password_2 = $_POST['student_password_2'];
   $student_name = $_POST['student_name'];
   $student_nric = $_POST['student_nric'];
   $student_phone = $_POST['student_phone'];
   $student_address = $_POST['student_address'];

   // form validation: ensure that the form is correctly filled by adding (array_push()) corresponding error unto $errors array
   if (empty($student_username))
      {
         array_push($errors, "Username is required");
      }
   if (empty($student_email))
      {
         array_push($errors, "Email is required");
      }
   if (empty($student_password_1))
      {
         array_push($errors, "Password is required");
      }
   if ($student_password_1 != $student_password_2)
      {
         array_push($errors, "The two passwords do not match");
      }
   if (empty($student_name))
      {
         array_push($errors, "Name is required");
      }
   if (empty($student_nric))
      {
         array_push($errors, "NRIC is required");
      }
   if (empty($student_phone))
      {
         array_push($errors, "Phone is required");
      }
   if (empty($student_address))
      {
         array_push($errors, "Address is required");
      }
   
    // first check the database to make sure a user does not already exist with the same student_username and/or student_email and/or nric
    $user_check_query = "SELECT * FROM student WHERE student_username = ? OR student_email = ? OR student_nric = ? LIMIT 1";
    $stmt = mysqli_prepare($hostelhub, $user_check_query);
    mysqli_stmt_bind_param($stmt, "sss", $student_username, $student_email, $student_nric);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $result = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

   if ($result)
      {
         // if user exists
        // if user exists
        $user = mysqli_fetch_assoc($result);
         if ($user['student_nric'] === $student_nric)
            {
               array_push($errors, "NRIC already exists");
            }
         if ($user['student_username'] === $student_username)
            {
               array_push($errors, "Username already exists");
            }
         if ($user['student_email'] === $student_email)
            {
               array_push($errors, "Email already exists");
            }
      }

   // Finally, register user if there are no errors in the form
   if (count($errors) == 0)
      {
        // Hash the password using Bcrypt before storing it in the database
        $hashed_password = password_hash($student_password_1, PASSWORD_BCRYPT);
         
         $query = "INSERT INTO student (student_username, student_password, student_email, student_name, student_nric, student_phone, student_address) VALUES(?, ?, ?, ?, ?, ?, ?)";
         $stmt = mysqli_prepare($hostelhub, $query);
         mysqli_stmt_bind_param($stmt, "sssssss", $student_username, $hashed_password, $student_email, $student_name, $student_nric, $student_phone, $student_address);
         mysqli_stmt_execute($stmt);

         if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['student_username'] = $student_username;
            $_SESSION['success'] = "You are now logged in";
            header('location: student_login.php');
            exit(); // Don't forget to exit after redirecting
        } else {
            array_push($errors, "Error occurred while registering user");
        }
 
        mysqli_stmt_close($stmt);
      }
}

// STUDENTS LOGIN
if (isset($_POST['login_student']))
{
   $student_username = mysqli_real_escape_string($hostelhub, $_POST['student_username']);
   $student_password = mysqli_real_escape_string($hostelhub, $_POST['student_password']);

   if (empty($student_username)) 
   {
       array_push($errors, "Username is required");
   }
   if (empty($student_password)) 
   {
       array_push($errors, "Password is required");
   }

   if (count($errors) == 0)
   {
    $query = "SELECT * FROM student WHERE student_username = ?";
    $stmt = mysqli_prepare($hostelhub, $query);
    mysqli_stmt_bind_param($stmt, "s", $student_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

       if (mysqli_num_rows($result) == 1)
       {
           $row = mysqli_fetch_assoc($result);
           $hashed_password = $row['student_password'];

           if (password_verify($student_password, $hashed_password))
           {
               //Password is correct, set the 'id' in session
               $_SESSION['id'] = $row['id'];

               //Password is correct, generate and send verification code
               $verification_code = mt_rand(100000, 999999); // You can customize the range

               //Save the verification code in the session for later verification
               $_SESSION['verification_code'] = $verification_code;
               $_SESSION['verification_username'] = $student_username;

               //Update the verification_code in the student table
               $update_query = "UPDATE student SET verification_code = ? WHERE student_username = ?";
               $stmt_update = mysqli_prepare($hostelhub, $update_query);
               mysqli_stmt_bind_param($stmt_update, "ss", $verification_code, $student_username);
               mysqli_stmt_execute($stmt_update);
               mysqli_stmt_close($stmt_update);
               
               //Send verification email
               $mail = new PHPMailer(true);
               $mail->isSMTP();

               //Configure your SMTP settings here
               $mail->Host = 'smtp.gmail.com';
               $mail->SMTPAuth = true;
               $mail->Username = 'email';
               $mail->Password = 'password';
               $mail->SMTPSecure = 'tls';
               $mail->Port = 587;
               $mail->setFrom('email', 'Subject');
               $mail->addAddress($row['student_email'], $student_username);
               $mail->isHTML(true);
               $mail->Subject = 'Verification Code for Login';
               $mail->Body = 'Your verification code is: ' . $verification_code;

               if (!$mail->send())
               {
                   array_push($errors, "Email could not be sent.");
               }
               // Redirect to the verification page
               header('location: verify_code.php');
            }
            else
            {
               array_push($errors, "Incorrect password");

               // Log failed student login attempt
               logEvent('Failed student login attempt from ' . $_SERVER['REMOTE_ADDR']);
            }
        }
        else
        {
            array_push($errors, "Username not found");

            // Log failed student login attempt
            logEvent('Failed student login attempt from ' . $_SERVER['REMOTE_ADDR']);
        }
        mysqli_stmt_close($stmt);
    }
}

// VERIFY CODE
if (isset($_POST['verify_code']))
{
    $entered_code = mysqli_real_escape_string($hostelhub, $_POST['verification_code']);

    if (empty($entered_code))
    {
        array_push($errors, "Verification code is required");
    }

    if (count($errors) == 0 && isset($_SESSION['verification_code']))
    {
        $saved_code = $_SESSION['verification_code'];
        $student_username = $_SESSION['verification_username'];

        if ($entered_code == $saved_code)
        {
            // Verification successful, log in the user
            $_SESSION['student_username'] = $student_username;
            $_SESSION['success'] = "You are now logged in";
            unset($_SESSION['verification_code']);
            unset($_SESSION['verification_username']);
            header('location: student_dashboard.php');

            // Log successful student login attempt
            logEvent('Successful student login attempt from ' . $_SERVER['REMOTE_ADDR']);     
            //log event if student access the student dashboard
            logEvent('Access to the student dashboard from ' . $_SERVER['REMOTE_ADDR']);      
        }
        else
        {
            array_push($errors, "Incorrect verification code");
            //log event if student entered the wrong verification code
            logEvent('Failed student login attempt from ' . $_SERVER['REMOTE_ADDR']);
        }
    }
}

// ADMINS REGISTER
if (isset($_POST['reg_admin']))
{
   // receive all input values from the form
   $admin_id = mysqli_real_escape_string($hostelhub, $_POST['admin_id']);
   $admin_email = mysqli_real_escape_string($hostelhub, $_POST['admin_email']);
   $admin_password_1 = mysqli_real_escape_string($hostelhub, $_POST['admin_password_1']);
   $admin_password_2 = mysqli_real_escape_string($hostelhub, $_POST['admin_password_2']);

   // form validation: ensure that the form is correctly filled by adding (array_push()) corresponding error unto $errors array
   if (empty($admin_id))
      {
         array_push($errors, "Id is required");
      }
   if (empty($admin_email))
      {
         array_push($errors, "Email is required");
      }
   if (empty($admin_password_1))
      {
         array_push($errors, "Password is required");
      }
   if ($admin_password_1 != $admin_password_2)
      {
         array_push($errors, "The two passwords do not match");
      }
   
   // first check the database to make sure a user does not already exist with the same student_username and/or student_email
   $user_check_query = "SELECT * FROM admin WHERE admin_id = ? OR admin_email = ? LIMIT 1";
   $stmt = mysqli_prepare($hostelhub, $user_check_query);
   mysqli_stmt_bind_param($stmt, "ss", $admin_id, $admin_email);
   mysqli_stmt_execute($stmt);
   mysqli_stmt_store_result($stmt);
   $result = mysqli_stmt_num_rows($stmt);
   mysqli_stmt_close($stmt);

   if ($result)
      {
         // if user exists
         $user = mysqli_fetch_assoc($result);
         if ($user['admin_id'] === $admin_id)
            {
               array_push($errors, "admin id already exists");
            }
         if ($user['admin_email'] === $admin_email)
            {
               array_push($errors, "admin email already exists");
            }
      }

   // Finally, register user if there are no errors in the form
   if (count($errors) == 0)
      {
         // Hash the password using Bcrypt before storing it in the database
         $hashed_password = password_hash($admin_password_1, PASSWORD_BCRYPT);
         $query = "INSERT INTO admin (admin_id, admin_password, admin_email) VALUES(?, ?, ?)";
         $stmt = mysqli_prepare($hostelhub, $query);
        mysqli_stmt_bind_param($stmt, "sss", $admin_id, $hashed_password, $admin_email);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['admin_email'] = $admin_email;
            $_SESSION['success'] = "You are now logged in";
            header('location: admin_login.php');
            exit(); // Don't forget to exit after redirecting
        } else {
            array_push($errors, "Error: " . mysqli_error($hostelhub)); // Add error message to errors array
        }
        mysqli_stmt_close($stmt);
    }
}

// ADMIN LOGIN
if (isset($_POST['login_admin']))
{
   $admin_email = mysqli_real_escape_string($hostelhub, $_POST['admin_email']);
   $admin_password = mysqli_real_escape_string($hostelhub, $_POST['admin_password']);

   if (empty($admin_email))
   {
       array_push($errors, "Email is required");
   }
   if (empty($admin_password))
   {
       array_push($errors, "Password is required");
   }
   if (count($errors) == 0)
   {
    $query = "SELECT * FROM admin WHERE admin_email = ?";
    $stmt = mysqli_prepare($hostelhub, $query);
    mysqli_stmt_bind_param($stmt, "s", $admin_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

       if (mysqli_num_rows($result) == 1)
       {
           $row = mysqli_fetch_assoc($result);
           $hashed_password = $row['admin_password'];
           
           if (password_verify($admin_password, $hashed_password))
           {
                // Password is correct, set the 'id' in session
                $_SESSION['id'] = $row['id'];
                
                // Password is correct, generate and send verification code
                $verification_code = mt_rand(100000, 999999);

                // Store admin email and verification code in session for verification
                $_SESSION['verification_code'] = $verification_code;
                $_SESSION['admin_email'] = $admin_email;

                // Store the verification code in the database
                $update_query = "UPDATE admin SET verification_code = ? WHERE admin_email = ?";
                $stmt = mysqli_prepare($hostelhub, $update_query);
                mysqli_stmt_bind_param($stmt, "ss", $verification_code, $admin_email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            
                // Send verification email
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                // Configure your SMTP settings here
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kl2304013100@student.uptm.edu.my'; // Update with your email address
                $mail->Password = 'u@1Ni*V5eR%mE7#en8'; // Update with your email password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('kl2304013100@student.uptm.edu.my', 'crypt'); // Update with your name and email address
                $mail->addAddress($admin_email); // Send email to admin email

                $mail->isHTML(true);
                $mail->Subject = 'Admin Verification Code';
                $mail->Body = 'Your verification code is: ' . $verification_code;

                if (!$mail->send())
                {
                    array_push($errors, "Email could not be sent.");
                }
                // Redirect to the verification page
                header('location: verify_admin_code.php');
            }
            else
            {
               array_push($errors, "Incorrect password");

               // Log failed admin login attempt
               logEvent('Failed admin login attempt from ' . $_SERVER['REMOTE_ADDR']);
            }
        }
        else
        {
            array_push($errors, "Admin Email not found");

            // Log failed admin login attempt
            logEvent('Failed admin login attempt from ' . $_SERVER['REMOTE_ADDR']);
        }
    }
}

// VERIFY ADMIN CODE
if (isset($_POST['verify_admin_code'])) 
{
   $entered_code = mysqli_real_escape_string($hostelhub, $_POST['verification_code']);

   if (empty($entered_code)) 
   {
       array_push($errors, "Verification code is required");
   }

   if (count($errors) == 0 && isset($_SESSION['verification_code'])) 
   {
       $saved_code = $_SESSION['verification_code'];
       $admin_email = $_SESSION['verification_email'];

       if ($entered_code == $saved_code) 
       {
           // Verification successful, log in the user
           $_SESSION['admin_email'] = $admin_email;
           $_SESSION['success'] = "You are now logged in";
           unset($_SESSION['verification_code']);
           unset($_SESSION['verification_email']);
           header('location: admin_dashboard.php');

           // Log successful admin login attempt
           logEvent('Successful admin login attempt from ' . $_SERVER['REMOTE_ADDR']);

           //log event if admin access the admin dashboard
           logEvent('Access to the admin dashboard from ' . $_SERVER['REMOTE_ADDR']);
        } 
        else 
        {
            array_push($errors, "Incorrect verification code");

            //log event if admin entered the wrong verification code
            logEvent('Failed admin login attempt from ' . $_SERVER['REMOTE_ADDR']);
       }
    }
}

// STUDENT DATA UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_form'])) {
   $student_name = mysqli_real_escape_string($hostelhub, $_POST['student_name']);
   $student_nric = mysqli_real_escape_string($hostelhub, $_POST['student_nric']);
   $student_address = mysqli_real_escape_string($hostelhub, $_POST['student_address']);
   $student_phone = mysqli_real_escape_string($hostelhub, $_POST['student_phone']);
   $student_email = mysqli_real_escape_string($hostelhub, $_POST['student_email']);

   // Prepare the update query with placeholders
   $update_query = "UPDATE student SET student_name=?, student_nric=?, student_address=?, student_phone=?, student_email=? WHERE id=?";
   
   // Prepare the statement
   $stmt = mysqli_prepare($hostelhub, $update_query);
   
   // Bind parameters to the statement
   mysqli_stmt_bind_param($stmt, "sssssi", $student_name, $student_nric, $student_address, $student_phone, $student_email, $student_id);
   
   // Execute the statement
   mysqli_stmt_execute($stmt);

   // Check if the update was successful
   if (mysqli_stmt_affected_rows($stmt) > 0) {
       // Student data updated successfully
       header('Location: admin_dashboard.php');
       exit();
   } else {
       array_push($errors, "Error updating student data");
   }
   
   // Close the statement
   mysqli_stmt_close($stmt);
}

// STUDENT DATA CREATE
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_create'])) {
   // Receive all input values from the form   
   $student_username = mysqli_real_escape_string($hostelhub, $_POST['student_username']);
   $student_email = mysqli_real_escape_string($hostelhub, $_POST['student_email']);
   $student_password_1 = mysqli_real_escape_string($hostelhub, $_POST['student_password_1']);
   $student_password_2 = mysqli_real_escape_string($hostelhub, $_POST['student_password_2']);
   $student_name = mysqli_real_escape_string($hostelhub, $_POST['student_name']);
   $student_nric = mysqli_real_escape_string($hostelhub, $_POST['student_nric']);
   $student_phone = mysqli_real_escape_string($hostelhub, $_POST['student_phone']);
   $student_address = mysqli_real_escape_string($hostelhub, $_POST['student_address']);

   // First, check the database to make sure a user does not already exist with the same student_username and/or student_email
   $user_check_query = "SELECT * FROM student WHERE student_username = ? OR student_email = ?";
   $stmt = mysqli_prepare($hostelhub, $user_check_query);
   mysqli_stmt_bind_param($stmt, "ss", $student_username, $student_email);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);
   $user = mysqli_fetch_assoc($result);

   if ($user) {
       // If user exists
       if ($user['student_nric'] === $student_nric) {
           array_push($errors, "NRIC already exists");
       }
       if ($user['student_username'] === $student_username) {
           array_push($errors, "Username already exists");
       }
       if ($user['student_email'] === $student_email) {
           array_push($errors, "Email already exists");
       }
   }

   // Finally, create student data if there are no errors in the form
   if (count($errors) == 0) {
       // Hash the password using Bcrypt before storing it in the database
       $hashed_password = password_hash($student_password_1, PASSWORD_BCRYPT);

       // Prepare the insert query with placeholders
       $query = "INSERT INTO student (student_username, student_password, student_email, student_name, student_nric, student_phone, student_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
       $stmt = mysqli_prepare($hostelhub, $query);
       mysqli_stmt_bind_param($stmt, "sssssss", $student_username, $hashed_password, $student_email, $student_name, $student_nric, $student_phone, $student_address);
       mysqli_stmt_execute($stmt);

       $_SESSION['student_username'] = $student_username;
       $_SESSION['success'] = "Student data created successfully";
       header('location: admin_dashboard.php');
   }

   // Close the statement
   mysqli_stmt_close($stmt);
}

?>