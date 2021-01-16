<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
    
    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

        // echo $username." ".$password." ".$confirm_password;
        if($password !== $confirm_password){
            // echo "PASSWORD AND CONFIRM PASSWORD DONT MATCH";
            header("Location: registration.php");
            die;
        }
        if(strlen($username) == 0 || strlen($email) == 0 || strlen($password) == 0){
            // echo "BAD USERNAME/PASSWORD";
            header("Location: registration.php");
            die;
        }

        $query = "SELECT user_randSalt FROM users WHERE user_randSalt != '' LIMIT 1";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ".mysqli_error($connection));
        }
        $row = mysqli_fetch_assoc($result);
        $salt = $row['user_randSalt'];

        $password = crypt($password, $salt);

        $query = "INSERT INTO users (username, user_password, user_email, user_role, user_image, user_firstname, user_lastname) ";
        $query .= "VALUES ('$username', '$password', '$email', 'Subscriber', 'default.png', 'FIRST_NAME', 'LAST_NAME');";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ".mysqli_error($connection));
        }
        header("Location: index.php");
    }

?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="sr-only">Password</label>
                            <input type="password" name="confirm_password" id="key" 
                                class="form-control" placeholder="Confirm Password">
                        </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
