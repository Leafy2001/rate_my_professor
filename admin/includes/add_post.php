<?php
if(isset($_POST['add_post'])){
    $title = $_POST['title'];
    $post_category_id = $_POST['post_category_id'];
    $author = $_SESSION['username'];
    $post_status = 'Approved';
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_date = date("Y-m-d");
    $post_comment_count = 0;

    $milliseconds = round(microtime(true) * 1000);
    $new_name = $milliseconds.$post_image;
    
    move_uploaded_file($post_image_temp, "../images/$new_name");
    $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, ";
    $query .= "post_tags, post_comment_count, post_status) VALUES ( ";
    $query .= "$post_category_id, '$title', '$author', now(), '$new_name', '$post_content', '$post_tags', $post_comment_count, '$post_status');";
    $result = mysqli_query($connection, $query);

    if(!$result){
        die("SERVICE UNAVAILABLE ".mysqli_error($connection));
    }
    header("Location: posts.php");
}
?>


<form action="" method = "post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name = "title"/>
    </div>

    <div class="form-group">
        <label for="post_category_id">Post Category</label>
        <select name = post_category_id>
            <?php
                $query = "SELECT * FROM category";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($result)){ ?>
                    <option value = <?php echo $row['cat_id'] ?>><?php echo $row['cat_title'] ?></option>
            <?php } ?>
        </select>
        <!-- <input type="text" class="form-control" name = "post_category_id"/> -->
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name = "post_image"/>
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name = "post_tags"/>
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name = "post_content" id = "" cols = "30" rows = "10"></textarea>
    </div>

    <div class = "form-group">
        <input class = 'btn btn-primary' type='submit' name = 'add_post' value = 'Add Post'/>
    </div>

</form>