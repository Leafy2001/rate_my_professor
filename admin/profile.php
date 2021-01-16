<?php include "./includes/admin_header.php";?>

<?php
if(isset($_POST['update_user'])){
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];

    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];

    if(empty($user_image)){
        $query = "SELECT * FROM users WHERE user_id = $user_id LIMIT 1";
        $select_img = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($select_img);
        $new_name = $row['user_image'];
    }else{
        $milliseconds = round(microtime(true) * 1000);
        $new_name = $milliseconds.$user_image;
        move_uploaded_file($user_image_temp, "../images/$new_name");
    }

    if(empty($user_password)){
        $query = "SELECT * FROM users WHERE user_id = $user_id LIMIT 1";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $orignal_password = $row['user_password'];
        $user_password = $orignal_password;
    }else{
        $query = "SELECT user_randSalt FROM users WHERE user_id = $user_id LIMIT 1";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $salt = $row['user_randSalt'];
        $user_password = crypt($user_password, $salt);
    }

    $query = "UPDATE users ";
    $query .= "SET username = '$username', ";
    $query .= "username = '$username', ";
    $query .= "user_firstname = '$user_firstname', ";
    $query .= "user_lastname = '$user_lastname', ";
    $query .= "user_email = '$user_email', ";
    $query .= "user_image = '$new_name', ";
    $query .= "user_password = '$user_password' ";
    $query .= "WHERE user_id = $user_id;";
    // echo $query;
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("ERROR OCCURED ".mysqli_error($connection));
    }
    
    $_SESSION['username'] = $username;
    $_SESSION['user_firstname'] = $user_firstname;
    $_SESSION['user_lastname'] = $user_lastname;
    $_SESSION['user_email'] = $user_email;
    $_SESSION['user_image'] = $new_name;

    header("Location: profile.php");
}
?>


<div id="wrapper">
    <?php include "./includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                    <?php echo $_SESSION['username'] ?>
                        <small><?php echo $_SESSION['user_firstname']." ".$_SESSION['user_lastname'] ?></small>
                    </h1>
                    
                    <form action="" method = "post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="title">Username</label>
                        <input type="text" class="form-control" name = "username" value="<?php echo $_SESSION['username'] ?>"/>
                    </div>

                    <div class="form-group">
                        <label for="author">Password</label>
                        <input type="text" class="form-control" name = "user_password"/>
                    </div>

                    <div class="form-group">
                        <label for="post_status">Firstname</label>
                        <input type="text" class="form-control" name = "user_firstname" value="<?php echo $_SESSION['user_firstname'] ?>"/>
                    </div>

                    <div class="form-group">
                        <label for="user_lastname">Lastname</label>
                        <input type="text" class="form-control" name = "user_lastname" value="<?php echo $_SESSION['user_lastname'] ?>"/>
                    </div>

                    <div class="form-group">
                        <img src = "../images/<?php echo $_SESSION['user_image']; ?>" width = "300" alt = <?php echo $_SESSION['user_image']; ?>/><br/>
                        <label for="user_image">User Image</label>
                        <input type="file" name = "user_image"/>
                    </div>

                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input type="email" class="form-control" name = "user_email" value="<?php echo $_SESSION['user_email'] ?>"/>
                    </div>

                    <!-- <div class="form-group">
                        <label for="user_role">User Role</label>
                        <select name = "user_role">
                            <option value = "Admin" <?php #if($_SESSION['user_role'] === 'Admin'){echo 'selected';} ?>>Admin</option>
                            <option value = "Subscriber" <?php #if($_SESSION['user_role'] === 'Subscriber'){echo 'selected';} ?>>Subscriber</option>
                        </select>
                    </div> -->

                    <div class = "form-group">
                        <input class = 'btn btn-primary' type='submit' name = 'update_user' value = 'Update User'/>
                    </div>

                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include "./includes/admin_footer.php"; ?>
