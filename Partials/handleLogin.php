<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['lognpass'];

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE user_email=?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result);

        if($numRows == 1){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($pass, $row['user_pass'])){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['sno'] = $row['sno'];
                $_SESSION['useremail'] = $email;
                // Redirect to home page after successful login
                header("Location: /forum/index.php");
                exit(); // Terminate script after redirect
            } else {
                $showError = "Invalid credentials";
            }
        } else {
            $showError = "User not found";
        }
    } else {
        $showError = "Database error";
    }

    // Display error message if login fails
    if($showError !== "false"){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> '. $showError .'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
?>
