<?php
include("database.php");

if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">Cannot access page</p>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission to update student data
    // Add your code here to update student data in the database
} else {
    $q = "SELECT * FROM student WHERE id = $id";
    $result = mysqli_query($hostelhub, $q);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Student</title>
   <!--bootstrap-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
   <!--google font api-->
   <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Righteous">
   <!--box icons css api-->
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   <style>
   </style>
</head>
<body>
   <div class="container mt-5">
      <form method="post" action="student_update.php" data-toggle="validator">
         <h1><b>Update Student Data</b></h1>
         
         <!--row 1-->
         <div class="row mb-2">
            <div class="col-md-6">
               <label for="student_name">Name</label>
               <input type="text" id="student_name" name="student_name" placeholder="Full Name" class="form-control" required value="<?php echo htmlspecialchars($row['student_name']); ?>">
            </div>
            <div class="col-md-6">
               <label for="student_nric">NRIC</label>
               <input type="text" id="student_nric" name="student_nric" placeholder="NRIC/Passport No" class="form-control" required value="<?php echo htmlspecialchars($row['student_nric']); ?>">
            </div>
         </div>

         <!--row 4-->
         <div class="mb-2">
            <label for="student_address">Address</label>
            <input type="text" id="student_address" name="student_address" placeholder="Address" class="form-control" required value="<?php echo htmlspecialchars($row['student_address']); ?>">
         </div>

         <!--row 6-->
         <div class="row mb-2">
            <div class="col-md-6">
               <label for="student_phone">Phone Number</label>
               <input type="tel" pattern="[0-9\.]+" id="student_phone" name="student_phone" placeholder="Phone Number" class="form-control" required value="<?php echo htmlspecialchars($row['student_phone']); ?>">
            </div>
            <div class="col-md-6">
               <label for="student_email">Email</label>
               <input type="email" id="student_email" name="student_email" placeholder="Email" class="form-control" required value="<?php echo htmlspecialchars($row['student_email']); ?>">
            </div>
         </div>
         <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
         <button class="btn btn-primary" type="submit" name="submit_form" style = "background: #637265; border: 1px solid #637265">Submit</button>
      </form>
   </div>
</body>
</html>
<?php
    } else {
        echo '<p class="error">Cannot access page</p>';
        echo '<p>&nbsp;</p>';
    }
    mysqli_close($hostelhub);
}
?>
