<!-- Comments Form -->

<?php
    // $user_id = $_SESSION['user_id'];
    // $prof_id = $_GET['prof_id'];
    // $query = "SELECT * FROM reviews WHERE review_user_id = $user_id AND prof_id = $prof_id;";
    // $result = mysqli_query($connection, $query);
    // if(!$result){
    //     die("ERROR ".mysqli_error($connection));
    // }
    // if(mysqli_num_rows($result) > 0){
    //     echo "You cannot post a review again...";
    // }
?>

<div class="well">
    <h4>Leave a Review:</h4>
    <?php
        if(!isset($_SESSION['user_id'])){
            echo "Pls sign in to post a review";
        }else{
            $user_id = $_SESSION['user_id'];
            $prof_id = $_GET['prof_id'];
            $query = "SELECT * FROM reviews WHERE review_user_id = $user_id AND review_professional_id = $prof_id;";
            $result = mysqli_query($connection, $query);
            if(!$result){
                die("ERROR ".mysqli_error($connection));
            }
            if(mysqli_num_rows($result) > 0){
                echo "You cannot post a review again ...";
            }else{
    ?>
    <form role="form" method = "post" action="">
        <br/>
        <div class="form-group">
            <label for="review_rating">Rating : </label>
            <!-- <textarea class="form-control" rows="3" name = "comment_content"></textarea> -->
            <select name = "review_rating">
            <?php
                for($i = 1; $i <= 10; $i++){
                    ?>
                    <option value=<?php echo $i; ?>><?php echo $i; ?></option>
                    <?php
                }
            ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="review_content">Review Description : </label>
            <textarea class="form-control" rows="3" name = "review_content" placeholder="(optional)..."></textarea>
        </div>
        <button type="submit" name="create_review" class="btn btn-primary">Add Review</button>
    </form>
    <?php } } ?>
</div>