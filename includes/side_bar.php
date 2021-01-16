
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
<!-- Blog Search Well -->
<div class="well">
    <h4>Search</h4>
    <form action = "search_result.php" method = "post" target="_blank">
        <div class="input-group">
            <input name = "search" type="text" class="form-control">
            <span class="input-group-btn">
                <button name = "submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
        </div>
    </form>
    <!-- /.input-group -->
</div>

<!-- LOGIN -->
<?php if(!isset($_SESSION['user_id'])){ ?>
<div class="well">
    <h4>Login</h4>
    <?php #echo "<h1>".$_SERVER['REQUEST_URI']."</h1>" ?>
    <form action = "includes/login.php" method = "post">
        <div class="form-group">
            <input name = "username" placeholder="Username" type="text" class="form-control">
        </div>
        <div class="form-group">
            <input name = "password" placeholder="Password" type="password" class="form-control">
        </div>
        <button class="btn btn-primary" name = "Login" type = "submit">Log In</button>
    </form>
    <!-- /.input-group -->
</div>
<?php } ?>

<!-- Blog Categories Well -->
<div class="well">
    <h4>Categories</h4>
    <div class="row">
        <div class="col-lg-6">
            <ul class="list-unstyled">
                <?php 
                $query = "SELECT * FROM category LIMIT 20";
                $result = mysqli_query($connection, $query);
                
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                        <li><a href="category.php?cat_id=<?php echo $row['cat_id'] ?>"><?php echo $row['cat_title']; ?></a></li>
                <?php    
                    }
                }
                ?>
                
            </ul>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<div class="well">
    <h4>From the Developers</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
</div>

</div>