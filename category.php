<?php include("./includes/header.php"); ?>
<?php
include "./includes/db.php"; global $connection;
if(!isset($_GET['cat_id'])){
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
                    $cat_id = $_GET['cat_id'];
                    $query = "SELECT * from professionals WHERE (professional_category_id = $cat_id AND professional_status = 'Approved')";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($result)){
                ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="professional.php?prof_id=<?php echo $row['professional_id'] ?>">
                        <?php echo $row['professional_name'] ?>
                    </a>
                </h2>
                <p class="lead">
                    <h3 style="color:DeepPink;"><?php echo $row['professional_organization'] ?></h3>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $row['add_date'] ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $row['professional_image']; ?>" alt="" width="200">
                <hr>
                <p><?php echo substr($row['professional_description'], 0, 150) ?>........</p>
                <a class="btn btn-primary" href="professional.php?prof_id=<?php echo $row['professional_id'] ?>">
                    Read More <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
                
                <hr>
                <?php
                    }
                ?>

            </div>

           <?php include "./includes/side_bar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>


        
<?php include "./includes/footer.php"; ?>