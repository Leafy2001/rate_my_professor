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
                    $query = "SELECT * from professionals ";
                    $query .= "INNER JOIN category ON category.cat_id = professionals.professional_category_id ";
                    $query .= "WHERE professional_status='Approved' ORDER BY reviews_added DESC LIMIT 20;";
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
                        <img src = "./images/<?php echo $row['professional_image']; ?>" width="70vw" class="" />
                    </div>
                    <div class = "prof_descrip">
                        <h4><u><?php echo $row['professional_name'] ?></u></h4>
                        <?php echo substr($row['professional_description'], 0, 150) ?>.....<br/>
                        <small><b>
                            <?php echo $row['professional_organization'] ?>, 
                            <?php echo $row['cat_title'] ?>
                        </b></small>
                        <small><b>
                            Average Rating : 
                            <?php 
                                $total_reviews = $row['reviews_added'];
                                $ratings_sum = $row['ratings_sum'];
                                if($total_reviews == 0){
                                    echo "Unrated<br/>";
                                }else{
                                    $stars = $ratings_sum/$total_reviews;
                                    echo number_format($stars, 2)."/10.00 &nbsp; (".$row['reviews_added'].")<br/>";
                                    for($i = 1; $i <= floor($stars); $i++){
                                        ?>
                                        <img src = "./images/front_images/full start.png" alt="f_s" width="15px"/>
                                        <?php
                                    }
                                    if(floor($stars) != $stars){
                                        ?>
                                        <img src = "./images/front_images/half filled str.png" alt = "h_s" width = "15px"/>
                                        <?php
                                    }
                                    // echo "<h1>$stars-ceil($stars)</h1>";
                                    for($i = 1; $i <= 10-ceil($stars); $i++){
                                        ?>
                                        <img src = "./images/front_images/empty star.png" alt = "e_s" width = "15px" />
                                        <?php
                                    }
                                }
                            ?>
                        </b></small>
                        <a class="btn btn-primary" href="professional.php?prof_id=<?php echo $row['professional_id']; ?>">
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