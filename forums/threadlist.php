<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
</head>

<body>
    <?php
        include 'partials/_dbconnect.php';
    ?>
    <?php
        include 'partials/_header.php';
    ?>
    <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE `category_id` = $id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row['category_name'];
            $catdesc = $row['category_des'];
        }
    ?>
    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        $th_title = $_POST['title'];
        $th_des = $_POST['des'];
        $th_title = str_replace("<","&lt",$th_title);
        $th_title = str_replace(">","&rt",$th_title);
        $th_des = str_replace("<","&lt",$th_des);
        $th_des = str_replace(">","&rt",$th_des);
        $th_user_id = $_SESSION['userid'];
        $sql = "INSERT INTO `threads` (`thread_title`,`thread_des`,`thread_cat_id`,`thread_user_id`,`timestamp`) VALUES ('$th_title','$th_des','$id','$th_user_id',current_timestamp())";
        $result = mysqli_query($conn,$sql);
        $showAlert = true;
        if($showAlert == true)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Your comment has been added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }
    ?>

    <div class="container my-4">
        <div class="container-fluid text-sm-center p-5 bg-light">
            <h1 class="display-2">Welcome to <?php echo $catname;?> forums</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>
                This is a peer to peer platform. No Spam / Advertising / Self-promote in the forums. Do not post
                copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Do not PM users asking for help. Remain respectful of other members at all times.
            </p>
            <a href="#" class="btn btn-success btn-lg" role="button">yeahh</a>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == "true"){
        echo '<div class="container">
                    <h2 class="py-2" style="text-align:center">Start a Discussion</h2>
                    <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="des" class="form-label">Describe your probleam</label>
                    <textarea class="form-control" id="des" name="des" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
                </form>
                </div>';
    }
    else{
       echo '<div class="container">
                <p class="lead">Login to start a discussion</p>
            </div>';
    }
    ?>

    <div class="container" id="ques">
        <h1 class="py-2" style="text-align:center">Browse Questions</h1>
        <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE `thread_cat_id` = $id";
            $result = mysqli_query($conn,$sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
                $noResult = false;
                $tid = $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_des'];
                $thread_time = $row['timestamp'];
                $thread_user_id = $row['thread_user_id'];
                $sql2 = "SELECT `user_name` FROM `users` WHERE `sno` = '$thread_user_id'";
                $result2 = mysqli_query($conn,$sql2);
                $row2 = mysqli_fetch_assoc($result2);

                echo '<div class="d-flex my-3">
            <div class="flex-shrink-0">
                <img src="userdef.jpeg" width ="60px" alt="...">
            </div>
            <div class="flex-grow-1 ms-3">
            <p class="font-weight-bold my-0">'.$row2['user_name'].' at'.$thread_time.'</p>
                <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$tid.'">'.$title.'</a></h5>
                '.$desc.'
            </div>
        </div>';
            }
            if($noResult){
                echo '<h3>
                        No questions yet,
                        <small class="text-body-secondary">Be the first to start a discussion.</small>
                      </h3>';
            }
        ?>
    </div>


    <?php
        include 'partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>