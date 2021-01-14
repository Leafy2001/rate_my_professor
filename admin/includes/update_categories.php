<?php
    $row = get_update();
?>   

<?php
    if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin'){
        header("Location: categories.php");
        die;
    }
    if(isset($_POST['update'])){
        update_category();
    }
?>

<form action = "categories.php?edit=<?php echo $_GET['edit'] ?>" method = "post">
    <div class = "form-group">
        
        <label for = "cat_title">Update Category</label>
        <input class = "form-control" type="text" name = "cat_title" value = <?php echo $row['cat_title']; ?> />
        
    </div>
    <div class = "form-group">
        <input class = 'btn btn-primary' type='submit' name = 'update' value = 'Update Category'/>
    </div>
</form>

    