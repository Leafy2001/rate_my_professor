<?php
if(isset($_GET['delete'])){
    $user_id = $_GET['delete'];
    $query = "DELETE FROM users WHERE user_id = $user_id";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("SERVICE UNAVAILABLE ". mysqli_error($connection));
    }
    header("Location: users.php");
    die;
}
?>

<table class = "table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>

        <?php display_all_users(); ?>
        
    </tbody>
</table>