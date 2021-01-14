
<?php include "./includes/admin_header.php"; ?>

<?php
    if(isset($_GET['delete'])){
        delete_category();
    }
    if(isset($_POST['submit'])){
        add_category();
    }
?>


    <div id="wrapper">
        <?php include "./includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $_SESSION['username'] ?>
                            <small><?php echo $_SESSION['user_firstname']." ".$_SESSION['user_lastname'] ?></small>
                        </h1>
                        
                        <div class="col-xs-6">
                            
                            <form action = "categories.php" method = "post">
                                <div class = "form-group">
                                    <label for = "cat_title">Add Category</label>
                                    <input class = "form-control" type="text" name = "cat_title" />
                                </div>
                                <div class = "form-group">
                                    <input class = "btn btn-primary" type="submit" name = "submit" value = "Add Category" />
                                </div>
                            </form><br/>
                            <?php
                            if(isset($_GET['edit'])){
                                $cat_id = $_GET['edit'];
                                include "./includes/update_categories.php"; 
                            }?>
                        </div>

                        <div class="col-xs-6">
                            <table class = "table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php display_all_categories(); ?>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
 <!-- /#wrapper -->
   
<?php include "./includes/admin_footer.php"; ?>
