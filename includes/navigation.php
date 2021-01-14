
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <?php 
                    $query = "SELECT * FROM category LIMIT 5";
                    $result = mysqli_query($connection, $query);
                    
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                ?>
                        <li><a href="category.php?cat_id=<?php echo $row['cat_id']; ?>"><?php echo $row['cat_title']; ?></a></li>
                <?php    
                        }
                    }
                ?>
                <?php if(isset($_SESSION['user_id'])){ ?>
                    <li><a href="./admin/index.php">Admin</a></li>
                    <li><a href="./includes/logout.php">Log Out</a></li>
                <?php }else{ ?>
                    <li><a href="./registration.php">Resgister</a></li>
                <?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>