<?php
if(isset($_POST['update_professional'])){
    $professional_id = $_GET['prof_id'];

    $professional_name = $_POST['professional_name'];
    $professional_category_id = $_POST['professional_category_id'];
    $professional_organization = $_POST['professional_organization'];
    $professional_description = $_POST['professional_description'];

    $professional_image = $_FILES['professional_image']['name'];
    $professional_image_temp = $_FILES['professional_image']['tmp_name'];

    $milliseconds = round(microtime(true) * 1000);
    $new_name = $milliseconds.$professional_image;
    move_uploaded_file($professional_image_temp, "../images/$new_name");

    if(empty($professional_image)){
        $query = "SELECT * FROM professionals WHERE professional_id = $professional_id";
        $select_img = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($select_img);
        $new_name = $row['professional_image'];
    }

    $query = "UPDATE professionals ";
    $query .= "SET professional_name = '$professional_name', ";
    $query .= "professional_category_id = '$professional_category_id', ";
    $query .= "professional_organization = '$professional_organization', ";
    $query .= "professional_description = '$professional_description', ";
    $query .= "professional_image = '$new_name' ";
    $query .= "WHERE professional_id = $professional_id;";
    // echo $query;
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("ERROR OCCURED ".mysqli_error($connection));
    }
    header("Location: professionals.php");
}
?>


<?php
if(isset($_GET['prof_id'])){
    $professional_id = $_GET['prof_id'];
    $query = "SELECT * FROM professionals WHERE professional_id = $professional_id LIMIT 1";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("ERROR OCCURED ".mysqli_error($connection));
    }
    $row = mysqli_fetch_assoc($result);

    $professional_name = $row['professional_name'];
    $professional_category_id = $row['professional_category_id'];
    $professional_image = $row['professional_image'];
    $professional_organization = $row['professional_organization'];
    $professional_description = $row['professional_description'];
    
}else{
    header("Location: professionals.php");
}
?>

<form action="" method = "post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="professional_name">Name</label>
        <input type="text" class="form-control" name = "professional_name" value = "<?php echo $professional_name ?>" />
    </div>

    <div class="form-group">
        <label for="professional_category_id">Category</label>
        <select name = professional_category_id>
            <?php
                $query = "SELECT * FROM category";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($result)){ ?>
                <?php if($row['cat_id'] == $professional_category_id) {?>
                    <option value = "<?php echo $row['cat_id']; ?>" selected><?php echo $row['cat_title']; ?></option>
                <?php }else{ ?>
                    <option value = "<?php echo $row['cat_id']; ?>" ><?php echo $row['cat_title']; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="professional_organization">Organization</label>
        <input type="text" class="form-control" name = "professional_organization" value = "<?php echo $professional_organization ?>" />
    </div>

    

    <div class="form-group">
        <img src = "../images/<?php echo $professional_image; ?>" width = "300" alt = <?php echo $professional_image; ?>/><br/><br/>
        <label for="professional_image">Image</label>
        <input type="file" name = "professional_image"/>
    </div>


    <div class="form-group">
        <label for="professional_description">Description</label>
        <textarea class="form-control" name = "professional_description" id = "" cols = "30" rows = "10"><?php echo $professional_description; ?></textarea>
        <script>
            CKEDITOR.replace('professional_description');
        </script>
    </div>

    <div class = "form-group">
        <input class = 'btn btn-primary' type='submit' name = 'update_professional' value = 'Update'/>
    </div>

</form>