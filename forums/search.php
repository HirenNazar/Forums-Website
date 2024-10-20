<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    .unsplash-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .container {
        min-height: 100vh;
    }

    .c-box {
        height: 540px;
    }

    .c-box2 {
        height: 540px;
    }

    .c-img {
        width: 100%;
        object-fit: contain;
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

    <div class="container my-3">
        <h1 class="py-3">Search results for "<?php echo $_GET['search'] ?>"</h1>
        <?php
        $noresult = true;
        $search = $_GET["search"];
        $sql = "SELECT * FROM `threads` WHERE MATCH (`thread_title`,`thread_des`) against ('$search')";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $noresult = false;
            $title = $row['thread_title'];
            $desc = $row['thread_des'];
            $thread_id = $row['thread_id'];
            $url = "thread.php?threadid='$thread_id";
            echo '<div class="result">
                    <h3><a href="'.$url.'" class="text-dark">'.$title.'</a></h3>
                    <p>'.$desc.'</p>
                  </div>';
        }
        if($noresult){
            echo '<div class="mt-4 p-5 bg-primary text-white rounded bg-secondary">
                    <h1>No results found.</h1>
                    <p>Check your spelling or try different keywords.</p>
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