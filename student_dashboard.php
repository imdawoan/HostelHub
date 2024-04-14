<?php 
    include ("database.php");
    $id = $_SESSION['id'];
    $query = mysqli_query($hostelhub,"SELECT * FROM student WHERE id = '$id'")or die(mysqli_error());
    $row = mysqli_fetch_array($query);
    
    if (!isset($_SESSION['student_username']))
        {
            header('location: student_login.php');
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><!--import bootstrap-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abril Fatface"><!--import Google Font API-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather"><!--import Google Font API-->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script><!--import Box Icons API-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://code.jquery.com/jquery3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/forkawesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
    
    <style>
        header
        {
            padding-left: 25px;
            padding-top: 8px;
        }
        .website-name
        {
            font-size: 30px;
            color: #2A4935;
            margin: 0; /* Removing default margin */
            text-align: left;
            font-family: 'Abril Fatface';
        }
    </style>
    <title>Student Dashboard</title>
</head>
<body>
    <header>
        <div class="website-name">HostelHub</div>
    </header>

        <?php if (isset($_SESSION['student_username'])) : ?>
 
            <div class = "container" style = "margin-top: 30px;">
                <div class = "container" style = "border: 1px solid white;margin-bottom: 50px;">
                    <h3 style = "float: left"><b>Information on <?php echo $_SESSION['student_username'];?></b></h3>
                    <span><button type = "button" class="btn" style = "float: right;background-color: #2A4935; margin-top: 8px;color: #ffffff; font-size: 15px" onclick = "document.location='student_form.php'">Update Form</button></span>
                </div>
                <div class = "container">
                    <?php 
                        $q = "SELECT id, student_name, student_nric, student_email, student_address, student_phone FROM student WHERE id = '$id'";
                        $result = @mysqli_query($hostelhub, $q);
                    
                        if($result)
                            {
                                echo '
                                    <br><b>Name:</b> '.$row['student_name']. '
                                    <br><b>NRIC:</b> '.$row['student_nric']. '
                                    <br><b>Email:</b> '.$row['student_email']. '
                                    <br><b>Address:</b> '.$row['student_address']. '
                                    <br><b>Phone:</b> '.$row['student_phone']. '<br>
                                    ';
                                mysqli_free_result($result);
                            }
                        else
                            {
                                echo '<p class = "error">The current student couldnt be retrieved. We apologize for any inconvenience.</p>';
                                echo '<p>'.mysqli_error($hostelhub). '<br><br>Query: 
                                    '.$q.'</p>';
                            }
                        mysqli_close($hostelhub);
                    ?>
                </div>
            </div>
        <?php endif ?>
</body>
</html>