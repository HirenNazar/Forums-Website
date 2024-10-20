<?php
session_start();

echo '<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/forums">vDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forums">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Top Categories
        </a>
        <ul class="dropdown-menu">';
        
        $sql = "SELECT `category_name`,`category_id` FROM `categories` LIMIT 3";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
          $cat = $row['category_name'];
          $cat_id = $row['category_id'];
          echo '<li><a class="dropdown-item" href="/forums/threadlist.php?catid='.$cat_id.'">'.$cat.'</a></li>';
        }
          echo '</ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contacts.php">Contacts</a>
      </li>
    </ul>
        <form class="d-flex" role="search" method ="get" action="search.php">
            <input class="form-control me-2" name = "search" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>';
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == "true"){
          echo '<a href="partials/_logout.php" type="button" class="btn btn-outline-secondary mx-2">Logout</a>';
        }
        else{
          echo '<button type="button" class="btn btn-outline-secondary ms-2" data-bs-toggle="modal" data-bs-target="#LoginModal">Login</button>
        <button type="button" class="btn btn-outline-secondary mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">Sign up</button>';
        }
echo  '</div>
</div>
</nav>';
include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
if (isset($_GET['signupsuccess'])) {
  if ($_GET['signupsuccess'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Account created!</strong> Login to continue.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  } elseif ($_GET['signupsuccess'] == "false") {
    $error = isset($_GET['error']) ? $_GET['error'] : 'Unknown error.';
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
            '.$error.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
}
if (isset($_GET['loginSuccess'])) {
  if ($_GET['loginSuccess'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Welcome!</strong> '.$_SESSION['username'].'.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  } elseif ($_GET['loginSuccess'] == "false") {
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
            Invalid credentials.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
}
?>