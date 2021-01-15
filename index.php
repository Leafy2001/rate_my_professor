<?php include("./includes/header.php"); ?>
<?php
include "./includes/db.php"; 
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
                    $query = "SELECT * from professors ";
                    $query .= "INNER JOIN category ON category.cat_id = professors.professor_category_id ";
                    $query .= "WHERE professor_status='Approved';";
                    $result = mysqli_query($connection, $query);
                    if(!$result){
                        echo $query;
                        die("ERROR ".mysqli_error($connection));
                    }
                    while($row = mysqli_fetch_assoc($result)){
                ?>

                <!-- Professor LIST -->
                
                <div class = "prof_info">
                    <div class = "prof_image">
                        <img src = "./images/<?php echo $row['professor_image']; ?>" width="70vw" class="" />
                    </div>
                    <div class = "prof_descrip">
                        <h4><?php echo $row['professor_name'] ?></h4>
                        <?php echo substr($row['professor_description'], 0, 150) ?><br/>
                        <small><b>
                            <?php echo $row['professor_institute'] ?>, 
                            <?php echo $row['cat_title'] ?>
                        </b></small>
                        <a class="btn btn-primary" href="post.php?post_id=<?php ?>">
                            Rate <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
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