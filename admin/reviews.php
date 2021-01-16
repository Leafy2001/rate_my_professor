
<?php include "./includes/admin_header.php"; ?>

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
                    <?php
                        if(isset($_GET['source'])){
                            $source = $_GET['source'];
                        }else{
                            $source = '';
                        }

                        switch($source){
                            case 'approve' : approve_review(); break;
                            case 'unapprove' : unapprove_review(); break;
                            default : include "./includes/view_all_reviews.php";
                        }
                    ?>


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
