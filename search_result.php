<?php 
include "./includes/header.php";
include "./includes/db.php"; 
global $connection;
?>
<body>

    <?php include("./includes/navigation.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                   if(isset($_POST['search'])){
                        $search =  $_POST['search'];
                        $query = "SELECT * FROM posts WHERE (post_tags LIKE '%$search%' AND post_status = 'Approved') LIMIT 20";
                        $search_query = mysqli_query($connection, $query);
                        echo "<h1>QUERY : \"$search\"</h1>";
                        if(!$search_query){
                            die("QUERY FAILED". mysqli_error($connection));
                        }
                        $count = mysqli_num_rows($search_query);
                        if($count == 0){
                            echo "<h1>NO RESULT</h1>";
                        }else{
                            while($row = mysqli_fetch_assoc($search_query)){
                ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $row['post_title'] ?></a>
                </h2>
                <p class="lead">
                    <h3 style="color:DeepPink;">by <?php echo $row['post_author'] ?></h3>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $row['post_date'] ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $row['post_image']; ?>" alt="">
                <hr>
                <p><?php echo $row['post_content'] ?></p>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore, veritatis, tempora, necessitatibus inventore nisi quam quia repellat ut tempore laborum possimus eum dicta id animi corrupti debitis ipsum officiis rerum.</p> -->
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                
                <hr>
                <?php
                        }
                    }
                }else{
                    die("<h1>BAD QUERY</h1>");
                }
                ?>

            </div>

           <?php include "./includes/side_bar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>


        
<?php include "./includes/footer.php"; ?>