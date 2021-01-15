<?php include("./includes/header.php"); ob_start(); ?>
<?php
include "./includes/db.php"; global $connection;
if(!isset($_GET['prof_id'])){
    header("Location: index.php");   
}
?>

<body>
    <?php include("./includes/navigation.php"); ?>
<!-- Page Content -->
    <div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php if(isset($_SESSION['user_id'])){ ?>
                <h1 class="page-header">
                    <img src = "./images/<?php echo $_SESSION['user_image'] ?>" style="border-radius:50%; width:60px; height:60px;"/>
                    <?php echo $_SESSION['username'] ?>
                    <small><?php echo $_SESSION['user_firstname']." ".$_SESSION['user_lastname'] ?></small>
                </h1>
            <?php }else{ ?>
                <h1 class="page-header">
                    <!-- Guest -->
                    <small>Hi Guest</small>
                </h1>
            <?php } ?>
            <?php
                $prof_id = $_GET['prof_id'];
                $query = "SELECT * from professionals WHERE (professional_id = $prof_id AND professional_status = 'Approved') LIMIT 1";
                $result = mysqli_query($connection, $query);
                if(!$result){
                    die("ERROR ".mysqli_error($connection));
                }
                if(mysqli_num_rows($result) == 0){
                    die("POST IS UNAPPROVED");
                }
                $row = mysqli_fetch_assoc($result);
            ?>

            <h2>
                <a href="professional.php?prof_id=<?php echo $row['professional_id'] ?>"><?php echo $row['professional_name'] ?></a>
            </h2>
            <p class="lead">
                <!-- by <a href="index.php"><?php #echo $row['post_author'] ?></a> -->
                <h3 style="color:DeepPink;"><?php echo $row['professional_organization'] ?></h3>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $row['add_date'] ?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $row['professional_image']; ?>" alt="<?php echo $row['professional_name']; ?>">
            <hr>
            <p><?php echo $row['professional_description'] ?></p>
            
            <hr/>
            

            <!-- Blog Comments -->
<?php
if(isset($_POST['create_review'])){
    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
    }
    $prof_id = $_GET['prof_id'];
    $user_id = $_SESSION['user_id'];
    $content = $_POST['review_content'];
    $rating = $_POST['review_rating'];

    $query = "INSERT INTO reviews (review_professional_id, review_user_id, review_rating, review_content, review_date) ";
    $query .= "VALUES ($prof_id, $user_id, $rating, '$content', now()) ;";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("ERROR ".mysqli_error($connection));
    }

    $query = "UPDATE professionals SET ratings_sum = ratings_sum+$rating, reviews_added = reviews_added+1 WHERE professional_id = $prof_id;";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("ERROR ".mysqli_error($connection));
    }

    header("Location: professional.php?prof_id=$prof_id");
}?>
                <!-- Comments Form -->

                <div class="well">
                    <h4>Leave a Review:</h4>
                    <?php
                        if(!isset($_SESSION['user_id'])){
                            echo "Pls sign in to post a review";
                        }else{
                    ?>
                    <form role="form" method = "post" action="">
                        <br/>
                        <div class="form-group">
                            <label for="review_rating">Rating : </label>
                            <!-- <textarea class="form-control" rows="3" name = "comment_content"></textarea> -->
                            <select name = "review_rating">
                            <?php
                                for($i = 1; $i <= 10; $i++){
                                    ?>
                                    <option value=<?php echo $i; ?>><?php echo $i; ?></option>
                                    <?php
                                }
                            ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="review_content">Review Description : </label>
                            <textarea class="form-control" rows="3" name = "review_content" placeholder="(optional)..."></textarea>
                        </div>
                        <button type="submit" name="create_review" class="btn btn-primary">Add Review</button>
                    </form>
                    <?php } ?>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php
                    $prof_id = $_GET['prof_id'];
                    $query = "SELECT * FROM reviews ";
                    $query .= "INNER JOIN users ON users.user_id = reviews.review_user_id ";
                    $query .= "WHERE (review_professional_id=$prof_id);";
                    $result = mysqli_query($connection, $query);
                    if(!$result){
                        // echo $query;
                        die("ERROR ".mysqli_error($connection));
                    }
                    while($row = mysqli_fetch_assoc($result)){
                        $author = $row['username'];
                        $author_image = $row['user_image'];
                        $content = $row['review_content'];
                        $date = $row['review_date'];
                        $review_rating = $row['review_rating'];
                ?>
                
                    <!-- Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="./images/<?php echo $author_image ?>" 
                                alt="" width = "50px" height = "50px" style="border-radius:50%";>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $author ?>
                                <small><?php echo $date ?></small>
                            </h4>
                            <small><b>Rating: <?php echo $review_rating; ?></b></small><br/>
                            <?php echo $content ?>
                        </div>
                    </div>
                        <hr/>
                <?php
                    }
                ?>

        </div>
        <?php include "./includes/side_bar.php"; ?>
        
    </div>
    <!-- /.row -->

<hr>


<?php include "./includes/footer.php"; ?>