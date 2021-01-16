<?php
if(isset($_GET['delete'])){
    $p_id = $_GET['delete'];
    $query = "DELETE FROM professionals WHERE professional_id = $p_id";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("SERVICE UNAVAILABLE ". mysqli_error($connection));
    }
    header("Location: professionals.php");
}
?>

<div class = " table-responsive">
<table class = "table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Professional Name</th>
            <th>Rating</th>
            <th>Category</th>
            <th>Organization</th>
            <th>Status</th>
            <th>Image</th>
            <th>Date</th>
            <th>Reviews</th>
        </tr>
    </thead>
    <tbody>

        <?php display_all_professionals(); ?>
        
    </tbody>
</table>
</div>