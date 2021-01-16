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

        $query = "SELECT * FROM professionals WHERE professional_category_id = $del_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ".mysqli_error($connection));
        }
        while($row = mysqli_fetch_assoc($result)){
            $professional_id = $row['professional_id'];
            $q = "UPDATE professionals SET professional_category_id = $misc_id WHERE professional_id = $professional_id;";
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
    
    function display_all_professionals(){
        global $connection;
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM professionals INNER JOIN category ON ";
        $query .= "professionals.professional_category_id = category.cat_id ";
        if($_SESSION['user_role'] !== 'Admin'){
            $query .= "WHERE (added_by = $user_id);";
        }
        $result = mysqli_query($connection, $query);
        if(!$result){
            die ("SERVICE UNAVAILABLE ".mysqli_error($connection));
        }

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
    ?>      
            <tr>
                <td><?php echo $row['professional_id']; ?></td>
                <!-- <td><?php #echo $row['post_author']; ?></td> -->
                <td><a href = "../professional.php?prof_id=<?php echo $row['professional_id'] ?>"><?php echo $row['professional_name']; ?></a></td>
                <td>
                    <?php if($row['reviews_added'] == 0){ ?>
                        Unrated
                    <?php }else{ echo number_format($row['ratings_sum']/$row['reviews_added'], 2); } ?>
                </td>
                <td><a href = "../category.php?cat_id=<?php echo $row['cat_id'] ?>"><?php echo $row['cat_title']; ?></a></td>
                <td><?php echo $row['professional_organization']; ?></td>
                <td><?php echo $row['professional_status']; ?></td>
                <td><img src="../images/<?php echo $row['professional_image']; ?>" width = "100" alt = <?php echo $row['professional_name']; ?>/></td>
                <td><?php echo $row['add_date']; ?></td>
                <td><?php echo $row['reviews_added']; ?></td>
                <td><a href = "professionals.php?delete=<?php echo $row['professional_id'] ?>">X</td>
                <td><a href = "professionals.php?source=edit&prof_id=<?php echo $row['professional_id'] ?>">Update</td>

                <?php if($_SESSION['user_role'] === 'Admin'){ ?>
                    <td><a href = "professionals.php?source=approve&prof_id=<?php echo $row['professional_id'];?>">Approve</td>
                    <td><a href = "professionals.php?source=unapprove&prof_id=<?php echo $row['professional_id'];?>">Unapprove</td>
                <?php } ?>
            </tr>
    <?php    
            }
        }else{
            echo "<h3><b>NO POSTS YET</b></h3>";
        }
    }

    function display_all_reviews(){
        global $connection;
        $user_id = $_SESSION['user_id'];

        $query = "SELECT * FROM reviews "; 
        $query .= "INNER JOIN professionals ON reviews.review_professional_id = professionals.professional_id ";
        $query .= "INNER JOIN users ON reviews.review_user_id = users.user_id ";
        if($_SESSION['user_role'] !== 'Admin'){
            $query .= "WHERE review_user_id = '$user_id';";
        }
        
        $result = mysqli_query($connection, $query);
        if(!$result){
            die ("SERVICE UNAVAILABLE ".mysqli_error($connection));
        }

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
    ?>      
            <tr>
                <td><?php echo $row['review_id']; ?></td>
                <td><?php echo $row['professional_name']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['review_rating']; ?></td>
                <td><?php echo $row['review_content']; ?></td>
                <td><?php echo $row['review_date']; ?></td>
                <td><?php echo $row['review_status']; ?></td>

                <td><a href = "reviews.php?delete=<?php echo $row['review_id']?>&prof_id=<?php echo $row['review_professional_id'];?>">X</td>
                
            <?php if($_SESSION['user_role'] === 'Admin'){ ?>
                <td><a href = "reviews.php?source=approve&review_id=<?php echo $row['review_id'];?>&prof_id=<?php echo $row['review_professional_id'];?>">Approve</td>
                <td><a href = "reviews.php?source=unapprove&review_id=<?php echo $row['review_id']?>&prof_id=<?php echo $row['review_professional_id'];?>">Unapprove</td>
            <?php } ?>
            </tr>
    <?php    
            }
        }
    }

    function approve_professional(){
        global $connection;
        if(!$_GET['prof_id'] || $_SESSION['user_role'] !== 'Admin'){
            header("Location: professionals.php");
            die;
        }
        $prof_id = $_GET['prof_id'];
        $query = "UPDATE professionals SET professional_status = 'Approved' WHERE professional_id = $prof_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }
        header("Location: professionals.php");
        die;
    }

    function unapprove_professional(){
        global $connection;
        if(!$_GET['prof_id'] || $_SESSION['user_role'] !== 'Admin'){
            header("Location: professionals.php");
            die;
        }
        $prof_id = $_GET['prof_id'];
        $query = "UPDATE professionals SET professional_status = 'Unapproved' WHERE professional_id = $prof_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }
        header("Location: professionals.php");
        die;
    }

    function approve_review(){
        global $connection;
        if(!$_GET['review_id'] || $_SESSION['user_role'] !== 'Admin'){
            header("Location: reviews.php");
            die;
        }
        $review_id = $_GET['review_id'];
        $prof_id = $_GET['prof_id'];

        $query = "SELECT * from reviews WHERE review_id = $review_id LIMIT 1;";
        $result = mysqli_query($connection, $query);
        if(!$result){die("ERROR ".mysqli_error($connection));}
        $row = mysqli_fetch_assoc($result);
        if($row['review_status'] == 'Approved'){header("Location: reviews.php");die;}

        $review_rating = $row['review_rating'];

        $query = "UPDATE reviews SET review_status = 'Approved' WHERE review_id = $review_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }

        $query = "UPDATE professionals SET reviews_added = reviews_added + 1, ratings_sum = ratings_sum + $review_rating WHERE professional_id = $prof_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }

        header("Location: reviews.php");
        die;
    }

    function unapprove_review(){
        global $connection;
        if(!$_GET['review_id'] || $_SESSION['user_role'] !== 'Admin'){
            header("Location: reviews.php");
            die;
        }
        $review_id = $_GET['review_id'];
        $prof_id = $_GET['prof_id'];

        $query = "SELECT * from reviews WHERE review_id = $review_id LIMIT 1;";
        $result = mysqli_query($connection, $query);
        if(!$result){die("ERROR ".mysqli_error($connection));}
        $row = mysqli_fetch_assoc($result);
        if($row['review_status'] == 'Unapproved'){header("Location: reviews.php");die;}

        $review_rating = $row['review_rating'];

        $query = "UPDATE reviews SET review_status = 'Unapproved' WHERE review_id = $review_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }

        $query = "UPDATE professionals SET reviews_added = reviews_added - 1, ratings_sum = ratings_sum - $review_rating WHERE professional_id = $prof_id";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("ERROR ". mysqli_error($connection));
        }

        header("Location: reviews.php");
        die;
    }

    function display_all_users(){
        global $connection;
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id != $user_id AND user_role != 'Admin';";
        #WHERE user_id != $user_id AND user_role != 'Admin';
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