<?php
$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
include '_dbconnect.php';
$email = $_POST['email'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['number']; // Changed 'phone' to 'number' to match input name
$education = $_POST['education']; // Changed 'phone' to 'number' to match input name
$subject = $_POST['subject'];
$message = $_POST['message'];

// SQL query to insert form data into database table
$sql = "INSERT INTO `contact` (`email_id`, `name`, `address`,`phone_number`, `education`,`subject`, `message`, `timestamp`)
VALUES ('$email', '$name','$address', '$phone','$education', '$subject', '$message', current_timestamp())";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

if ($result) {
$showAlert = true;
} else {
$showError = "Failed to submit data"; // Show error message if query failed
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Me</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body>

    <?php
        if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your message has been successfully submitted. We will get back to you soon.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        if($showError){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>'.$showError.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        ?>
    <?php include '_dbconnect.php';?>
    <?php include '_header.php';?>
    <div class="container">
        <h1>Contact Me</h1>
        <form action="/forum/partials/contact.php" method="post">
            <div class="mb-3 col-md-6">
                <label for="email">Email ID</label>
                <input type="email" maxlength="30" class="form-control" id="email" name="email"
                    aria-describedby="emailHelp">
            </div>
            <div class="mb-3 col-md-6">
                <label for="name">Name</label>
                <input type="text" maxlength="30" class="form-control" id="name" name="name"
                    aria-describedby="emailHelp">
            </div>
            <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" maxlength="200" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3 col-md-6">
                <label for="number">Phone Number</label>
                <input type="tel" class="form-control" id="number" name="number" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 col-md-6">
                <label for="education" class="form-label">Your Education</label>
                <input type="text" maxlength="30" class="form-control" id="education" name="education">
            </div>
            <div class="mb-3 col-md-6">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 col-md-6">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary col-md-6">Submit</button>

    </div>
    </form>

    </div>
    <!-- Social Media Links -->
    <div class="row justify-content-center mt-5">
        <p>MY Social Media Links</p>
        <div class="col-auto">
            <a href="https://github.com/RAOHammadraza9443"><img src="github-icon.png" alt="Github" width="50"></a>
        </div>
        <div class="col-auto">
            <a href="https://www.linkedin.com/in/rao-hammad-raza-2b0881246/"><img src="linkedin-icon.png" alt="Linkedin"
                    width="50"></a>
        </div>
        <div class="col-auto">
            <a href="https://www.facebook.com/profile.php?id=100077971148520"><img src="facebook-icon.png"
                    alt="Facebook" width="50"></a>
        </div>
    </div>
    <?php include '_footer.php';?>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </script>
</body>

</html>
