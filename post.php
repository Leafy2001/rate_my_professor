<?php include("./includes/header.php"); ob_start(); ?>
<?php
include "./includes/db.php"; global $connection;
if(!isset($_GET['post_id'])){
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
                $post_id = $_GET['post_id'];
                $query = "SELECT * from posts WHERE (post_id = $post_id AND post_status = 'Approved') LIMIT 1";
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
                <a href="post.php?post_id=<?php echo $row['post_id'] ?>"><?php echo $row['post_title'] ?></a>
            </h2>
            <p class="lead">
                <!-- by <a href="index.php"><?php #echo $row['post_author'] ?></a> -->
                <h3 style="color:DeepPink;">by <?php echo $row['post_author'] ?></h3>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $row['post_date'] ?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $row['post_image']; ?>" alt="">
            <hr>
            <p><?php echo $row['post_content'] ?></p>
            
            <hr/>
            

            <!-- Blog Comments -->
<?php
if(isset($_POST['create_comment'])){
    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
    }
    $post_id = $_GET['post_id'];
    $author = $_SESSION['username'];
    $email = $_SESSION['user_email'];
    $content = $_POST['comment_content'];
    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
    $query .= "VALUES ($post_id, '$author', '$email', '$content', 'Approved', now()) ;";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("ERROR ".mysqli_error($connection));
    }
    header("Location: post.php?post_id=$post_id");
}?>
                <!-- Comments Form -->

                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <?php
                        if(!isset($_SESSION['user_id'])){
                            echo "Pls sign in to post a comment";
                        }else{
                    ?>
                    <form role="form" method = "post" action="">
                        <div class="form-group">
                            <label for="comment_content">Comment : </label>
                            <textarea class="form-control" rows="3" name = "comment_content"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                    <?php } ?>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php
                    $post_id = $_GET['post_id'];
                    $query = "SELECT * FROM comments WHERE (comment_post_id=$post_id AND comment_status='Approved')";
                    $result = mysqli_query($connection, $query);
                    if(!$result){
                        die("ERROR ".mysqli_error($connection));
                    }
                    while($row = mysqli_fetch_assoc($result)){
                        $author = $row['comment_author'];

                        $q = "SELECT user_image FROM users WHERE username = '$author' LIMIT 1";
                        $r = mysqli_query($connection, $q);
                        if(!$r){
                            die("ERROR ".mysqli_error($connection));
                        }
                        $rw = mysqli_fetch_assoc($r);
                        $comment_user_image = $rw['user_image'];

                        $content = $row['comment_content'];
                        $date = $row['comment_date'];
                ?>
                
                    <!-- Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="./images/<?php echo $comment_user_image ?>" 
                                alt="" width = "50px" height = "50px" style="border-radius:50%";>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $author ?>
                                <small><?php echo $date ?></small>
                            </h4>
                            <?php echo $content ?>
                        </div>
                    </div>

                <?php
                    }
                ?>

        </div>
            <?php include "./includes/side_bar.php"; ?>
        
    </div>
    <!-- /.row -->

<hr>


<?php include "./includes/footer.php"; ?>