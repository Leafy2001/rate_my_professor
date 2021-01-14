<?php
if(isset($_GET['delete'])){
    $p_id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE post_id = $p_id";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("SERVICE UNAVAILABLE ". mysqli_error($connection));
    }
    header("Location: posts.php");
}
?>

<div class = " table-responsive">
<table class = "table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Date</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>

        <?php display_all_posts(); ?>
        
    </tbody>
</table>
</div>