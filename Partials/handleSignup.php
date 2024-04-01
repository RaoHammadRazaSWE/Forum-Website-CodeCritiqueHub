<?php
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupcPassword'];

    // Check if email already exists
    $existSql = "SELECT * FROM `users` WHERE user_email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $existSql)) {
        mysqli_stmt_bind_param($stmt, "s", $user_email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $numRows = mysqli_stmt_num_rows($stmt);
        if ($numRows > 0) {
            $showError = "Email already in use";
        } else {
            if ($pass == $cpass) {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES (?, ?, current_timestamp())";
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ss", $user_email, $hash);
                    $result = mysqli_stmt_execute($stmt);
                    if ($result) {
                        header("Location: /forum/index.php?signupsuccess=true");
                        exit();
                    } else {
                        $showError = "Signup failed. Please try again later.";
                    }
                } else {
                    $showError = "SQL error. Please try again later.";
                }
            } else {
                $showError = "Passwords do not match";
            }
        }
    } else {
        $showError = "Database error. Please try again later.";
    }

    header("Location: /forum/index.php?signupsuccess=false&error=" . urlencode($showError));
}
?>
