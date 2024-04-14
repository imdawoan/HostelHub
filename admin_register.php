<?php include('database.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!--ensure responsiveness for all screens-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><!--import bootstrap-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abril Fatface"><!--import Google Font API-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather"><!--import Google Font API-->
    <title>Admin Registration</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #FFFFFF;
        }
        header{
            padding-left: 25px;
            padding-top: 8px;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #EDE4DC;
            border-radius: 20px;
            box-shadow: 0px 10px 15px -3px rgba(0,0,0,0.2);;
        }
        .heading {
            margin-bottom: 20px;
            text-align: left; /* Aligning the text to the left */
        }
        .website-name {
            font-size: 30px;
            color: #2A4935;
            margin: 0; /* Removing default margin */
            text-align: left;
            font-family: 'Abril Fatface';
        }
        .custom-select{
            width: 49.5%;
            border: 1px solid #cccccc;
        }
        h4
        {
            font-family: 'Merriweather';
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <div class="website-name">HostelHub</div>
    </header>

    <div class="container">
        <div class="row" style = "padding-left: 10px;padding-right: 10px;">
            <div class="col-sm" style = "background: #ffffff; border-radius: 18px; padding-top: 18px; padding-bottom: 18px;">
                <form method = "post" action="admin_register.php">
                    <h4>Create Admin Account</h4>
                    <div class = "col mb-2">
                        <!--id-->
                        <div style = "margin-bottom: 20px;">
                            <input type="text" class="form-control" id="ip1" name="admin_id" placeholder = "ID" autocomplete="off" required>
                        </div>
                        <div style = "margin-bottom: 20px;">
                            <input type="email" class="form-control" id="ip1" name="admin_email" placeholder = "Email" autocomplete="off" required>
                        </div>
                        <div style = "margin-bottom: 20px;"><!--many modern browsers don't support autocomplete="off", so use autocomplete="new-password" instead-->
                            <input type="password" class="form-control" id="ip1" name="admin_password_1" placeholder = "Password" autocomplete="new-password" required>
                        </div>
                        <div style = "margin-bottom: 20px;">
                            <input type="password" class="form-control" id="ip1" name="admin_password_2" placeholder = "Confirm Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="reg_admin" style = "margin-bottom: 12px; width: 100%; background-color: #637265;border: 1px solid #8770A4">Sign Up</button>
                    </div>
                    <hr>
                    <p style = "text-align: center; color: #949eb4;">Already a member? <a href="admin_login.php" style = "color: #0d1766;text-decoration: none"><b>Log In</b></a></p>
                </form>
                <?php include('error_handling.php'); ?>
            </div>
            <div class="col-sm">
                <img src="admin.png" alt="Italian Trulli" style = "height: 50%; width: 100%; margin-top: 120px;">
            </div>
        </div>
    </div>
</body>
</html>