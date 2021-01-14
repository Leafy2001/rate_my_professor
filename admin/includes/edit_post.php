<?php
if(isset($_POST['update_post'])){
    $post_id = $_GET['post_id'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_author = $_POST['post_author'];
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    $post_status = $_POST['post_status'];

    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];

    $milliseconds = round(microtime(true) * 1000);
    $new_name = $milliseconds.$post_image;
    move_uploaded_file($post_image_temp, "../images/$new_name");

    if(empty($post_image)){
        $query = "SELECT * FROM posts WHERE post_id = $post_id";
        $select_img = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($select_img);
        $new_name = $row['post_image'];
    }

    $query = "UPDATE posts ";
    $query .= "SET post_title = '$post_title', ";
    $query .= "post_category_id = '$post_category_id', ";
    $query .= "post_author = '$post_author', ";
    $query .= "post_content = '$post_content', ";
    $query .= "post_status = '$post_status', ";
    $query .= "post_image = '$new_name', ";
    $query .= "post_date = now(), ";
    $query .= "post_tags = '$post_tags' WHERE post_id = $post_id;";
    // echo $query;
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("ERROR OCCURED ".mysqli_error($connection));
    }
    header("Location: posts.php");
}
?>


<?php
if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $query = "SELECT * FROM posts WHERE post_id = $post_id LIMIT 1";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("ERROR OCCURED ".mysqli_error($connection));
    }
    $row = mysqli_fetch_assoc($result);

    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_author = $row['post_author'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_status = $row['post_status'];
}else{
    header("Location: posts.php");
}
?>

<form action="" method = "post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name = "post_title" value = "<?php echo $post_title ?>" />
    </div>

    <div class="form-group">
        <label for="post_category_id">Post Category</label>
        <select name = post_category_id>
            <?php
                $query = "SELECT * FROM category";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($result)){ ?>
                <?php if($row['cat_id'] == $post_category_id) {?>
                    <option value = "<?php echo $row['cat_id']; ?>" selected><?php echo $row['cat_title']; ?></option>
                <?php }else{ ?>
                    <option value = "<?php echo $row['cat_id']; ?>" ><?php echo $row['cat_title']; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name = "post_author" value = "<?php echo $post_author ?>" />
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name = "post_status" value = "<?php echo $post_status ?>" />
    </div>

    <div class="form-group">
        <img src = "../images/<?php echo $post_image; ?>" width = "300" alt = <?php echo $post_image; ?>/><br/>
        <label for="post_image">Post Image</label>
        <input type="file" name = "post_image"/>
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name = "post_tags" value = "<?php echo $post_tags ?>" />
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name = "post_content" id = "" cols = "30" rows = "10">
        <?php echo $post_content ?>
        </textarea>
    </div>

    <div class = "form-group">
        <input class = 'btn btn-primary' type='submit' name = 'update_post' value = 'Update Post'/>
    </div>

</form>