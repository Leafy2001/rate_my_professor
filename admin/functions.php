<?php

    function add_category(){
        global $connection;
        $cat_name = $_POST['cat_title'];

        $query = "SELECT * FROM category WHERE cat_title = '$cat_name'; ";
        $result = mysqli_query($connection, $query);
        if(!$result){die("ERROR!!! SERVICE TEMPORARILY UNAVAILABLE ". mysqli_error($connection));}

        if(mysqli_num_rows($result) != 0 || $cat_name == "" || empty($cat_name) 
                        || strlen(str_replace(' ', '', $cat_name)) == 0){
            
        }else{
            $query = "INSERT INTO category (cat_title) VALUES ('$cat_name')";
            $result = mysqli_query($connection, $query);
            if(!$result){
                die("ERROR!!! SERVICE TEMPORARILY UNAVAILABLE");
            }
        }
        header("Location: categories.php");
        die;
    }

    function update_category(){
        global $cat_id;
        global $connection;
        if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin'){
            header("Location: categories.php");
            die;
        }
        $cat_title = $_POST['cat_title'];
        $query = "UPDATE category SET cat_title = '{$cat_title}' WHERE (cat_id = $cat_id AND cat_title != 'Miscellaneous');";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("SERVICE UNAVAILABLE". mysqli_error($connection));
        }
        header("Location: categories.php");
    }

    function get_update(){
        global $connection;
        $cat_id = $_GET['edit'];
        $query = "SELECT * FROM category WHERE cat_id = $cat_id LIMIT 1";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("SERVICE UNAVAILABLE");
        }
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function delete_category(){
        global $connection;
        if($_SESSION['user_role'] !== 'Admin'){
            header("Location: categories.php");
            die;
        }
        $del_id = $_GET['delete'];
        $query = "SELECT * FROM category WHERE cat_title = 'Miscellaneous'";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ".mysqli_error($connection));
        }
        $row = mysqli_fetch_assoc($result);

        $misc_id = $row['cat_id'];

        $query = "SELECT * FROM posts WHERE post_category_id = $del_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ".mysqli_error($connection));
        }
        while($row = mysqli_fetch_assoc($result)){
            $post_id = $row['post_id'];
            $q = "UPDATE posts SET post_category_id = $misc_id WHERE post_id = $post_id;";
            $r = mysqli_query($connection, $q);
            if(!$r){
                die("ERROR ".mysqli_error($connection));
            }
        }
        
        $query = "DELETE FROM category WHERE cat_id = $del_id AND cat_title != 'Miscellaneous'";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ".mysqli_error($connection));
        }

        header("Location: categories.php");
    }

    function display_all_categories(){
        global $connection;
        $query = "SELECT * FROM category";
        $result = mysqli_query($connection, $query);
        
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
    ?>      
            <tr>
                <td><?php echo $row['cat_id']; ?></td>
                <td><?php echo $row['cat_title']; ?></td>
                <?php if($_SESSION['user_role'] === 'Admin' && $row['cat_title'] !== 'Miscellaneous'){ ?>
                <td><a href = "categories.php?delete=<?php echo $row['cat_id'] ?>">X</td>
                <td><a href = "categories.php?edit=<?php echo $row['cat_id'] ?>">Update</td>
                <?php } ?>
            </tr>
    <?php    
            }
        }
    }
    
    function display_all_posts(){
        global $connection;
        $username = $_SESSION['username'];
        $query = "SELECT * FROM posts INNER JOIN category ON posts.post_category_id = category.cat_id ";
        if($_SESSION['user_role'] !== 'Admin'){
            $query .= "WHERE (post_author = '$username');";
        }
        $result = mysqli_query($connection, $query);
        if(!$result){
            die ("SERVICE UNAVAILABLE ".mysqli_error($connection));
        }

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
    ?>      
            <tr>
                <td><?php echo $row['post_id']; ?></td>
                <td><?php echo $row['post_author']; ?></td>
                <td><a href = "../post.php?post_id=<?php echo $row['post_id'] ?>"><?php echo $row['post_title']; ?></a></td>
                <td><a href = "../category.php?cat_id=<?php echo $row['cat_id'] ?>"><?php echo $row['cat_title']; ?></a></td>
                <td><?php echo $row['post_status']; ?></td>
                <td><img src="../images/<?php echo $row['post_image']; ?>" width = "100" alt = <?php echo $row['post_image']; ?>/></td>
                <td><?php echo $row['post_tags']; ?></td>
                <td><?php echo $row['post_date']; ?></td>
                <td><?php echo $row['post_comment_count']; ?></td>
                <td><a href = "posts.php?delete=<?php echo $row['post_id'] ?>">X</td>
                <td><a href = "posts.php?source=edit&post_id=<?php echo $row['post_id'] ?>">Update</td>

                <?php if($_SESSION['user_role'] === 'Admin'){ ?>
                    <td><a href = "posts.php?source=approve&post_id=<?php echo $row['post_id'];?>">Approve</td>
                    <td><a href = "posts.php?source=unapprove&post_id=<?php echo $row['post_id'];?>">Unapprove</td>
                <?php } ?>
            </tr>
    <?php    
            }
        }else{
            echo "<h3><b>NO POSTS YET</b></h3>";
        }
    }

    function display_all_comments(){
        global $connection;
        $username = $_SESSION['username'];

        $query = "SELECT * FROM comments INNER JOIN posts ON comments.comment_post_id = posts.post_id ";
        if($_SESSION['user_role'] !== 'Admin'){
            $query .= "WHERE comment_author = '$username';";
        }
        
        $result = mysqli_query($connection, $query);
        if(!$result){
            die ("SERVICE UNAVAILABLE ".mysqli_error($connection));
        }

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
    ?>      
            <tr>
                <td><?php echo $row['comment_id']; ?></td>
                <td><?php echo $row['comment_author']; ?></td>
                <td><?php echo $row['comment_content']; ?></td>
                <td><?php echo $row['comment_email']; ?></td>
                <td><a href = "../post.php?post_id=<?php echo $row['post_id'] ?>"><?php echo $row['post_title']; ?></a></td>
                <td><?php echo $row['comment_status']; ?></td>
                <td><?php echo $row['comment_date']; ?></td>
                
                <td><a href = "comments.php?delete=<?php echo $row['comment_id']?>&post_id=<?php echo $row['post_id'];?>">X</td>
                
            <?php if($_SESSION['user_role'] === 'Admin'){ ?>
                <td><a href = "comments.php?source=approve&comment_id=<?php echo $row['comment_id'];?>&post_id=<?php echo $row['post_id'];?>">Approve</td>
                <td><a href = "comments.php?source=unapprove&comment_id=<?php echo $row['comment_id']?>&post_id=<?php echo $row['post_id'];?>">Unapprove</td>
            <?php } ?>
            </tr>
    <?php    
            }
        }
    }

    function approve_post(){
        global $connection;
        if(!$_GET['post_id'] || $_SESSION['user_role'] !== 'Admin'){
            header("Location: posts.php");
            die;
        }
        $post_id = $_GET['post_id'];
        $query = "UPDATE posts SET post_status = 'Approved' WHERE post_id = $post_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }
        header("Location: posts.php");
        die;
    }

    function unapprove_post(){
        global $connection;
        if(!$_GET['post_id'] || $_SESSION['user_role'] !== 'Admin'){
            header("Location: posts.php");
            die;
        }
        $post_id = $_GET['post_id'];
        $query = "UPDATE posts SET post_status = 'Unapproved' WHERE post_id = $post_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }
        header("Location: posts.php");
        die;
    }

    function approve_comment(){
        global $connection;
        if(!$_GET['comment_id'] || $_SESSION['user_role'] !== 'Admin'){
            header("Location: comments.php");
            die;
        }
        $comment_id = $_GET['comment_id'];
        $post_id = $_GET['post_id'];
        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $comment_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }

        $query = "UPDATE posts SET post_comment_count = post_comment_count+1 WHERE post_id = $post_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }

        header("Location: comments.php");
        die;
    }

    function unapprove_comment(){
        global $connection;
        if(!$_GET['comment_id'] || $_SESSION['user_role'] !== 'Admin'){
            header("Location: comments.php");
            die;
        }
        $comment_id = $_GET['comment_id'];
        $post_id = $_GET['post_id'];
        $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = $comment_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }
        
        $query = "UPDATE posts SET post_comment_count = post_comment_count-1 WHERE post_id = $post_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }

        header("Location: comments.php");
        die;
    }

    function display_all_users(){
        global $connection;
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id != $user_id AND user_role != 'Admin';";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die ("SERVICE UNAVAILABLE ".mysqli_error($connection));
        }

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
    ?>      
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['user_firstname']; ?></td>
                <td><?php echo $row['user_lastname']; ?></td>
                <td><?php echo $row['user_email']; ?></td>
                <td><img src="../images/<?php echo $row['user_image'];?>" width = "100" alt = <?php echo $row['user_image']; ?>/></td>
                <td><?php echo $row['user_role']; ?></td>
                
                <td><a 
                onclick="return confirm('Are u sure u wanna delete user:\' <?php echo $row['username']; ?> \'?');"
                href = "users.php?delete=<?php echo $row['user_id']?>">X</td>
                <td>
                    <a href = "users.php?source=edit_user&user_id=<?php echo $row['user_id'];?>">
                        Update
                    </a>
                </td>
            </tr>
    <?php    
            }
        }
    }

?>