<?php include('database.php');?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!--ensure responsiveness for all screens-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><!--import bootstrap-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abril Fatface"><!--import Google Font API-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather"><!--import Google Font API-->
        <title>Admin Login</title>

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
            margin: 70px auto;
            padding: 20px;
            background: #EDE4DC;
            border-radius: 20px;
            box-shadow: 0px 10px 15px -3px rgba(0,0,0,0.2);
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
            <div class="row">
                <div class="col-sm" style = "background: #ffffff; border-radius: 18px; padding-top: 18px; padding-bottom: 18px; margin-left: 18px">
                    <form method="post" action="admin_login.php">
                        <h4>Welcome Admin</h4>
                        <div class = "col mb-2">
                            <!--email-->
                            <div id="key-input" class="key-input" style = "margin-bottom: 20px;">
                                <input type="email" id="ip1" name="admin_email" class="form-control" aria-label="With textarea" placeholder = "Admin Email" autocomplete="off" required>
                            </div>
                            <!--password-->
                            <div id="key-input" class="key-input" style = "margin-bottom: 20px;">
                                    <input type="password" id="ip1" name="admin_password" class="form-control" aria-label="With textarea" placeholder = "Admin Password" autocomplete="off" required>
                            </div>
                            <!--button-->
                            <button type="submit" name="login_admin" class="btn btn-primary" style = "margin-bottom: 12px; width: 100%; background-color: #637265;border: 1px solid #8770A4">Login</button>        
                            <?php include('error_handling.php'); ?>
                        </div>
                    </form>
                </div>
                <div class="col-sm">
                    <img src="admin.png" alt="Italian Trulli" style = "height: 84%; width: 100%; margin-top: 39px;">
                </div>
            </div>
        </div>
    </body>
</html>