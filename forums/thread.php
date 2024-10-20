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
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE `thread_id` = $id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_des'];
            $id2 = $row['thread_user_id'];
            $sql2 = "SELECT `user_name` FROM `users` WHERE `sno` = '$id2'";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $name = $row2['user_name'];
        }
    ?>
    <div class="container my-4">
        <div class="container-fluid text-sm-center p-5 bg-light">
            <h1 class="display-2 text-left"><?php echo $title;?></h1>
            <p class="lead text-left"><?php echo $desc;?></p>
            <hr class="my-4">
            <p>
                Posted by: <b><?php echo $name?></b>
            </p>
        </div>
    </div>
    <?php
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        $comment = $_POST['comment'];
        $comment = str_replace("<","&lt",$comment);
        $comment = str_replace(">","&rt",$comment);
        $comment_by = $_SESSION['userid'];
        $sql = "INSERT INTO `comment` (`comment_content`,`thread_id`,`comment_by`,`comment_time`) VALUES ('$comment','$id','$comment_by',current_timestamp())";
        $result = mysqli_query($conn,$sql);
    }
    ?>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == "true"){
        echo '<div class="container">
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
            <div class="mb-3">
                <label for="comment" class="form-label">Type Your Comment.</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
    }
    else{
       echo '<div class="container">
                <label for="comment" class="form-label">Type Your Comment.</label>
                <p class="lead">Login to Comment</p>
            </div>';
    }
    ?>


    <div class="container" id="ques">
        <h1 class="py-2">Comments</h1>
        <?php
            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `comment` WHERE `thread_id` = $id";
            $result = mysqli_query($conn,$sql);
            $noResult = false;
            while($row = mysqli_fetch_assoc($result)){
                $noResult = true;
                $id = $row['comment_id'];
                $content = $row['comment_content'];
                $comment_time = $row['comment_time'];
                $commentor_id = $row['comment_by'];
                $sql2 = "SELECT `user_name` FROM `users` WHERE `sno` = '$commentor_id'";
                $result2 = mysqli_query($conn,$sql2);
                $row2 = mysqli_fetch_assoc($result2);
                
                echo '<div class="d-flex my-3">
                        <div class="flex-shrink-0">
                            <img src="userdef.jpeg" width ="60px" alt="...">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="font-weight-bold my-0">'.$row2['user_name'].' at '.$comment_time.'</p>
                            '.$content.'
                        </div>
                    </div>';
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