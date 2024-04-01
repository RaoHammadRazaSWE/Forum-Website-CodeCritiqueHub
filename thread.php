<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iDiscuss - Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <!-- Slider start here -->

    <?php 
    if(isset($_GET['threadid'])) {
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id']; // corrected variable name
            
            // Query the users table to find out the name of OP.
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
        }
    }
    ?>

    <?php
        $showAlert = false;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // insert comment into DB
            $comment = $_POST['comment'];
            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);
            $sno = $_POST['sno'];
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) 
                    VALUES ('$comment', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if($showAlert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your comment has been added! 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
        }
    ?>


    <div class="container my-4">
        <div class="jumbotron bg-light">
            <h1 class="display-4 text-center"><?php echo $title;?></h1>
            <p class="lead text-center"><?php echo $desc;?></p>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6">
                    <h4>Community Guidelines:</h4>
                    <ul>
                        <li>No Spam / Advertising / Self-promotion</li>
                        <li>Avoid posting copyright-infringing material</li>
                        <li>Respect other members</li>
                        <li>Do not cross-post questions</li>
                        <li>Avoid sending unsolicited PMs for help</li>
                        <li>Maintain a friendly and supportive atmosphere</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <img src="https://source.unsplash.com/500x400/?coding" class="card-img-top" alt="Coding Image">
                </div>

            </div>
            <div class="mt-4">
                <p>Posted by: <b>Rao Hammad Raza</b></p>
            </div>
        </div>
    </div>

    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { 
        echo '<div class="container">
            <h1 class="py-2">Post a Comment</h1>
            <form action="' . $_SERVER['REQUEST_URI']. '" method="post">
                <div class="form-group">
                    <label for="comment">Type of your comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                </div>
                <div style="margin-top: 10px;">
                    <button type="submit" class="btn btn-success">Post Comment</button>
                </div>
            </form>
        </div>';
    } else {
        echo '<div class="container">
            <h1 class="py-2">Post a Comment</h1>
            <p class="lead">You are not logged in. Please login to be able to post comments.</p>
        </div>';
    }
    ?>

    <div class="container my-4" id="ques">
        <h1 class=" py-2">Discussions</h1>
        <?php 
        if(isset($_GET['threadid'])) {
            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
                $noResult = false;
                $id = $row['comment_id']; 
                $content = $row['comment_content'];
                $comment_time = $row['comment_time'];
                $thread_user_id = $row['comment_by']; // corrected variable name
                
                $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);      
            
                echo '<div class="media my-3">
                        <img src="https://img.freepik.com/premium-vector/account-icon-user-icon-vector-graphics_292645-552.jpg" 
                            width="54px" height="54px" class="mr-3" alt="User Image">
                        <div class="media-body">
                            <p class="font-weight-bold my-0">' . $row2['user_email'] . ' at ' . $comment_time . '</p>
                            ' . $content . '
                        </div>
                    </div>';
            }
            
            if ($noResult) {
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-5">No Comments Found</p>
                            <p class="lead">Be The First Person To Comment.</p>
                        </div>
                    </div>';
            }
        }
        ?>
    </div>

    <?php include 'partials/_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
