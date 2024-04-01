<?php
session_start(); // Start the session
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/forum">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/forum">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="partials/about.php">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Top Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
            $sql = "SELECT category_name, category_id FROM `categories` LIMIT 5";
            $result = mysqli_query($conn, $sql); 
            while($row = mysqli_fetch_assoc($result)){
                echo '<a class="dropdown-item" href="threadlist.php?catid='. $row['category_id']. '">' . $row['category_name']. '</a>'; 
            }
            // Add a default link if needed
            echo '<a class="dropdown-item" href="all_categories.php">View All Categories</a>';
                
            echo '</div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="partials/contact.php">Contact Me</a>
            </li>
        </ul>
        
        <div class="my-2 my-lg-0">';
        
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<form class="d-flex my-2 my-lg-0 mr-auto" method="get" action="partials/search.php">
            <input class="form-control me-2" name="search" type="search">
            <button class="btn btn-success" type="submit">Search</button>
            <p class="text-light my-0 mx-2">Welcome '.$_SESSION['useremail'].'</p>
            <a href="partials/_logout.php" class="btn btn-outline-success mx-2">Logout</a>
        </form>';
} else {
    echo '<div class="row mx-2 align-items-center">
    <div class="col">
        <form class="d-flex" role="search" action="partials/search.php" method="get">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-success" type="submit">Search</button>
        </form>
    </div>
    <div class="col-auto">
        <button type="button" class="btn btn-outline-success mx-2" data-bs-toggle="modal"
            data-bs-target="#loginModal">Login</button>
        <button type="button" class="btn btn-outline-success mx-2" data-bs-toggle="modal"
            data-bs-target="#signupModal">Signup</button>
    </div>
</div>
';
}

echo '</div>
    </div>
</nav>';

include '_loginModal.php';
include '_signupModal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You can now login
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
?>
