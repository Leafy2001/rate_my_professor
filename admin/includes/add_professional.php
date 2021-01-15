<?php
if(isset($_POST['add_professional'])){
    $professional_name = $_POST['professional_name'];
    $professional_category_id = $_POST['professional_category_id'];
    $author = $_SESSION['user_id'];
    $professional_image = $_FILES['professional_image']['name'];
    $professional_image_temp = $_FILES['professional_image']['tmp_name'];
    $professional_organization = mysqli_real_escape_string($connection, $_POST['professional_organization']);
    $professional_description = mysqli_real_escape_string($connection, $_POST['professional_description']);

    $milliseconds = round(microtime(true) * 1000);
    $new_name = $milliseconds.$professional_image;
    
    move_uploaded_file($professional_image_temp, "../images/$new_name");

    $query = "INSERT INTO professionals ";
    $query .= "(professional_category_id, professional_name, added_by, add_date, professional_image, professional_description, ";
    $query .= "professional_organization) VALUES ($professional_category_id, '$professional_name', $author, now(), '$new_name', ";
    $query .= "'$professional_description', '$professional_organization');";
    
    $result = mysqli_query($connection, $query);

    if(!$result){
        echo $query;
        die("SERVICE UNAVAILABLE ".mysqli_error($connection));
    }
    header("Location: professionals.php");
}
?>


<form action="" method = "post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Professional Name</label>
        <input type="text" class="form-control" name = "professional_name"/>
    </div>

    <div class="form-group">
        <label for="professional_category_id">Professional Category</label>
        <select name = "professional_category_id">
            <?php
                $query = "SELECT * FROM category";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($result)){ ?>
                    <option value = <?php echo $row['cat_id'] ?>><?php echo $row['cat_title'] ?></option>
            <?php } ?>
        </select>

    </div>

    <div class="form-group">
        <label for="professional_image">Professional Image</label>
        <input type="file" name = "professional_image"/>
    </div>
    
    <div class="form-group">
        <label for="professional_organization">Professional Organization</label>
        <input type="text" class="form-control" name = "professional_organization"/>
    </div>

    <div class="form-group">
        <label for="professional_description">Professional Description</label>
        <textarea class="form-control" name = "professional_description" id = "" cols = "30" rows = "10"></textarea>
        <script>
            CKEDITOR.replace('professional_description');
        </script>
    </div>

    <div class = "form-group">
        <input class = 'btn btn-primary' type='submit' name = 'add_professional' value = 'Add Professional'/>
    </div>

</form>