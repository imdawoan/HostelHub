<?php 
   include ("database.php");
   $id = $_SESSION['id'];
   $query = mysqli_query($hostelhub,"SELECT * FROM student WHERE id ='$id'")or die(mysqli_error());
   $row = mysqli_fetch_array($query);

   //student form
   if (isset($_POST['submit_form']))
   {
      //check the name
      if(!empty($_POST['student_name']))
      {
         $student_name = mysqli_real_escape_string($hostelhub, trim($_POST['student_name']));
      }
      //check the nric
      if(!empty($_POST['student_nric']))
      {
         $student_nric = mysqli_real_escape_string($hostelhub, trim($_POST['student_nric']));
      } 
      //check the address
      if(!empty($_POST['student_address']))
      {
         $student_address = mysqli_real_escape_string($hostelhub, trim($_POST['student_address']));
      }
      //check the phone
      if(!empty($_POST['student_phone']))
      {
         $student_phone = mysqli_real_escape_string($hostelhub, trim($_POST['student_phone']));
      }
      //check the email
      if(!empty($_POST['student_email']))
      {
         $student_email = mysqli_real_escape_string($hostelhub, trim($_POST['student_email']));
      }

      $q = "UPDATE student SET student_name = '$student_name', student_nric = '$student_nric', student_address = '$student_address', student_phone = '$student_phone', student_email = '$student_email' WHERE id = '$id'";
      $result = @mysqli_query($hostelhub, $q);

      if($result)//if record exist
      {
         echo '<div class="alert alert-success" role="alert">Form successfully submitted!<a href = "student_dashboard.php"><button class="button2" id = "b2a">OK</button></a></div>';
         exit();
      }
      else
      {
         echo '<div class="alert alert-warning" role="alert">Form submission unsuccessful<a href = "student_dashboard.php"><button class="button2" id = "b2b">OK</button></a></div>';
         echo '<p>' .mysqli_error($hostelhub).'<br><br>Query: '.$q. '</p>';
      }
      mysqli_close($hostelhub);
      exit();
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
    <title>Student List</title>
</head>
<body>

   <header>
        <div class="website-name">HostelHub</div>
   </header>

   <div class = "container" style = "margin-top: 30px">
      <div class = "container" style = "padding: 0 0 0 0;">
         <h1><b>REGISTRATION FORM</b></h1>
         <hr style = "border-color: #272727;width: 100%;">
         <form method = "post" action = "student_form.php" data-toggle="validator">
            <!--row 1-->
            <div class = "row mb-2">
               <div class = "col -md-6">
                  <label for="student_name">Name</label>
                  <input type="text" id="ip1" name="student_name" placeholder = "Full Name" class = "form-control" required value="<?php echo $row['student_name']; ?>">
               </div>

               <div class = "col -md-6">
                  <label for="student_nric">NRIC</label>
                  <input type="text" id="ip1" name="student_nric" placeholder = "NRIC/Passport No" class = "form-control" required value="<?php echo $row['student_nric']; ?>">
               </div>
            </div>

            <!--row 4-->
            <div>
               <label for="student_address">Address</label>
               <input type="text" id="ip1" name="student_address" placeholder = "Address" class = "form-control" required value="<?php echo $row['student_address']; ?>">
            </div>
            
            <!--row 6-->
            <div class = "row mb-2">
               <div class = "col -md-6">
                  <label for="student_phone">Phone Number</label>
                  <input type="tel" pattern="[0-9\.]+" id="ip1" name="student_phone" placeholder = "Phone Number" class = "form-control" required value="<?php echo $row['student_phone']; ?>">
               </div>
               <div class = "col -md-6">
                  <label for="student_email">Email</label>
                  <input type="text" id="ip1" name="student_email" placeholder = "Email" class = "form-control" required value="<?php echo $row['student_email']; ?>">
               </div>
            </div>
            <button class = "btn" type = "submit" name = "submit_form" style = "float: right;background-color: #2A4935; margin-left: 10px;margin-top: 8px;color: #ffffff; font-size: 15px">Submit</button>
         </form>
      </div>
      </div>
</body>
</html>   