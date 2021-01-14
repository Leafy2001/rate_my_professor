<?php
if(isset($_POST['add_user'])){
    $username = $_POST['username'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);
    
    if(empty($user_image)){
        $new_name = 'default.png';
    }else{
        $milliseconds = round(microtime(true) * 1000);
        $new_name = $milliseconds.$user_image;
        move_uploaded_file($user_image_temp, "../images/$new_name");
    }
    
    $query = "INSERT INTO users (username, user_firstname, user_lastname, user_password, user_email, user_image, user_role) VALUES ( ";
    $query .= "'$username', '$user_firstname', '$user_lastname', '$user_password', '$user_email', '$new_name', '$user_role');";
    $result = mysqli_query($connection, $query);

    if(!$result){
        die("SERVICE UNAVAILABLE ".mysqli_error($connection));
    }
    header("Location: users.php");
}
?>


<form action="" method = "post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name = "username"/>
    </div>

    <div class="form-group">
        <label for="author">Password</label>
        <input type="text" class="form-control" name = "user_password"/>
    </div>

    <div class="form-group">
        <label for="post_status">Firstname</label>
        <input type="text" class="form-control" name = "user_firstname"/>
    </div>
    
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name = "user_lastname"/>
    </div>

    <div class="form-group">
        <label for="user_image">User Image</label>
        <input type="file" name = "user_image"/>
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name = "user_email"/>
    </div>

    <div class="form-group">
        <label for="user_role">User Role</label>
        <select name = "user_role">
            <option value = "Admin">Admin</option>
            <option value = "Subscriber" selected>Subscriber</option>
        </select>
        <!-- <input type="text" class="form-control" name = "user_role"/> -->
    </div>

    <div class = "form-group">
        <input class = 'btn btn-primary' type='submit' name = 'add_user' value = 'Add User'/>
    </div>

</form>