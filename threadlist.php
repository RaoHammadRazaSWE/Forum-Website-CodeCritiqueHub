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
    if(isset($_GET['catid'])) {
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id= $id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];      
        }
    }
    ?>

    <?php
    $showAlert = false;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Insert Thread into DB
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        $th_title = str_replace("<", "&lt;",$th_title);
        $th_title = str_replace(">", "&gt;",$th_title);

        $th_desc = str_replace("<", "&lt;",$th_desc);
        $th_desc = str_replace(">", "&gt;",$th_desc);

        $sql = "INSERT INTO `threads`(`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '0', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your thread has been added! Please wait for the community to respond.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }
    ?>

    <div class="container my-4">
        <div class="jumbotron bg-light">
            <h1 class="display-4 text-center">Welcome to <?php echo $catname;?> Forums</h1>
            <p class="lead text-center"><?php echo $catdesc;?></p>
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
                    <img src="https://source.unsplash.com/500x400/?coding" class="card-img-top"
                        alt="Logo provided by Category">
                </div>
            </div>
            <div class="mt-4">
                <p>Posted by: <b>Rao Hammad Raza</b></p>
            </div>
            <div class="mt-4">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn More</a>
            </div>
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo '<div class="container">
                <h1 class="py-2">Start a Discussion</h1>
                <form action="'. $_SERVER["REQUEST_URI"].'" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Problem Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible</div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="form-label">Elaborate Your Concern</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                        <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                    </div>
                    <div style="margin-top: 10px;">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>';
    } else {
        echo '<div class="container my-4">
                <h1 class="py-2">Start a Discussion</h1>
                <p class="lead">You are not logged in. Please login to start a Discussion.</p>
            </div>';
    }
    ?>

    <!-- Category container start here -->
    <div class="container my-4" id="ques">
        <h1 class="py-2">Browse Questions</h1>

        <?php
if(isset($_GET['catid']) && !empty($_GET['catid'])) {
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result = mysqli_query($conn, $sql);
    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['thread_id']; 
            $title = $row['thread_title']; 
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            if($result2 && mysqli_num_rows($result2) > 0) {
                $row2 = mysqli_fetch_assoc($result2);
                $user_email = $row2['user_email'];
            } else {
                $user_email = "Unknown User";
            }
            
            echo '<div class="media my-3">
                    <img src="https://img.freepik.com/premium-vector/account-icon-user-icon-vector-graphics_292645-552.jpg" width="54px" height="54px" class="mr-3" alt="...">
                    <div class="media-body">
                        <p class="font-weight-bold my-0">'. $user_email .' at ' .$thread_time. '</p>
                        <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='. $id .'">'. $title .'</a></h5>
                        '. $desc .'
                    </div>
                </div>';
        }
    } else {
        echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <p class="display-5">No Threads Found</p>
                    <p class="lead">Be the first person to ask a question.</p>
                </div>
            </div>';
    }
} else {
    echo "Category ID is not set or empty.";
}
?>

    </div>

    <?php include 'partials/_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
