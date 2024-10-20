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
    #ques {
        min-height: 433px;
    }
    .c-box{
        height:540px;
    }
    .c-box2{
        height:540px;
    }
    .c-img{
        width:100%;
        object-fit:contain;
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
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner c-box">
            <div class="carousel-item active c-box2">
                <img src="imgOne.jpg" class="d-block w-100 c-img">
            </div>
            <div class="carousel-item c-box2">
                <img src="imgTwo.jpg" class="d-block w-100 c-img ayo">
            </div>
            <div class="carousel-item c-box2">
                <img src="imgThree.jpg" class="d-block w-100 c-img">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container" id="ques">
        <h2 class="text-center my-4">vDiscuss - Categories</h2>
        <div class="row my-4">
            <?php
        $access_key = 'nzC_hcOV0pCF6__lmoDcTcnE10d_yUZsO32Pf2MxsMY';
        $per_page = 1;
        $page = 1;
        $sql = "SELECT * FROM `categories`";
        $additional_keyword = 'programming';
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['category_id'];
            $cat = $row['category_name'];
            $desc = $row['category_des'];
            $query = urlencode($cat);
            $url = "https://api.unsplash.com/search/photos?page=" . $page . "&query=" . urlencode($query) . "&per_page=" . $per_page . "&client_id=" . $access_key;
            $response = file_get_contents($url);
            if ($response === false) {
                echo 'Error: Unable to fetch results.';
            } else {
                // Decode the JSON response
                $data = json_decode($response, true);
            
                // Check if the request was successful
                if (isset($data['results']) && count($data['results']) > 0) {
                    // Get the first photo
                    $photo = $data['results'][0];
                    // Get the URL of the full image
                    $image_url = $photo['urls']['full'];
                } else {
                    echo 'Error: Unable to fetch results.';
                    $image_url = null;
                }
            }
            echo '<div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <img src="' . $image_url . '"  class="card-img-top unsplash-image"
                        alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><a href="threadlist.php?catid='.$id.'">'.$cat.'</a></h5>
                        <p class="card-text">'.substr($desc,0,90).'....</p>
                        <a href="threadlist.php?catid='.$id.'" class="btn btn-primary">View Threads</a>
                    </div>
                </div>
            </div>';
        }

    ?>
        </div>
    </div>


    <?php
        include 'partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>