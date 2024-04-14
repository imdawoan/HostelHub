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
   
   <?php
      if((isset ($_GET['id'])) && (is_numeric($_GET['id'])))
      {
         $id = $_GET['id'];
      }
      else if((isset ($_POST['id'])) && (is_numeric($_POST['id'])))
      {
         $id = $_POST['id'];
      }
      else
      {
         echo '<p class = "error">Cannot access page</p>';
         exit();
      }
         
      if($_SERVER ['REQUEST_METHOD']=='POST')
      {
         if($_POST['sure'] == 'Yes')
         {
            $q = "DELETE FROM student WHERE id = $id LIMIT 1";
            $result = @mysqli_query($hostelhub, $q);
         
            if(mysqli_affected_rows($hostelhub) == 1)
            {
               echo '
               <div class="alert alert-success" role="alert">
                  Student successfully deleted!<a href = "admin_dashboard.php"><button class="button2" id = "b2a">OK</button></a>
               </div>';
            }
            else
            {
               echo '
               <div class="alert alert-danger" role="alert">
                  The student cannot be deleted<a href = "admin_dashboard.php"><button class="button2" id = "b2b">OK</button></a>
               </div>';
               echo '<p>' .mysqli_error($hostelhub).'<br>Query: '.$q.'</p>';
            }
         }
         else
         {
            echo '
            <div class="alert alert-danger" role="alert">
               The student has not been deleted<a href = "admin_dashboard.php"><button class="button2" id = "b2b">OK</button></a>
            </div>';
         }
      }
      else
      {
         $q = "SELECT student_name FROM student WHERE id = $id";
         
         $result = @mysqli_query($hostelhub, $q);
         if(mysqli_num_rows($result)==1)
         {
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            echo
            '
            <div class="container">
               <form method="post" action="student_delete.php">
                  <h6>Delete Student</h6>
                  <p>Permanently delete the student?</p>
                  <button class = "btn btn-primary" id = "submit-yes" type = "submit" name = "sure" value = "Yes" style = "margin-bottom: 12px; width: 100%; background-color: #637265;border: 1px solid #8770A4">Yes</button>
                  <button class = "btn btn-primary" id = "submit-no" type = "submit" name = "sure" value = "No" style = "margin-bottom: 12px; width: 100%; background-color: #637265;border: 1px solid #8770A4">No</button>
                  <input type = "hidden" name = "id" value = "'.$id.'">
               </form>
            </div>
            ';
         }
         else
         {
            echo '<p class = "error">Cannot access page</p>';
            echo '<p>&nbsp;</p>';
         }
      }
         mysqli_close($hostelhub);
   ?>
</body>
</html>   