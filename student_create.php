<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Student</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Create New Student Data</h1>
        <form method="post" action="database.php">
            <!-- Input fields for student data -->
            <div class="mb-3">
                <label for="student_username" class="form-label">Username</label>
                <input type="text" class="form-control" id="student_username" name="student_username" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="student_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="student_email" name="student_email" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="student_password_1" class="form-label">Password</label>
                <input type="password" class="form-control" id="student_password_1" name="student_password_1" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="student_password_2" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="student_password_2" name="student_password_2" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="student_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="student_nric" class="form-label">NRIC</label>
                <input type="text" class="form-control" id="student_nric" name="student_nric" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="student_phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="student_phone" name="student_phone" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="student_address" class="form-label">Address</label>
                <input type="text" class="form-control" id="student_address" name="student_address" autocomplete="off" required>
            </div>
            <!-- Button to submit the form -->
            <button type="submit" class="btn btn-primary" name="student_create" style = "margin-bottom: 20px; background-color: #637265; border: 1px solid ; background-color: #637265">Create Student</button>
        </form>
    </div>
</body>
</html>
