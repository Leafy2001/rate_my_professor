<?php
if(isset($_GET['delete'])){
    $comment_id = $_GET['delete'];
    $post_id = $_GET['post_id'];

    $query = "DELETE FROM comments WHERE comment_id = $comment_id";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("SERVICE UNAVAILABLE ". mysqli_error($connection));
    }

    $query = "UPDATE posts SET post_comment_count = post_comment_count-1 WHERE post_id = $post_id";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("SERVICE UNAVAILABLE ". mysqli_error($connection));
    }

    header("Location: comments.php");
}
?>

<table class = "table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Post</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>

        <?php display_all_comments(); ?>
        
    </tbody>
</table>