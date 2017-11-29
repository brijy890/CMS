<?php include "includes/admin_header.php"; ?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>
        <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Wellcome Admin
                            <small>Author</small>
                        </h1>

                        <div class="col-xs-6">

                            <!-- Add categorie -->
                            <?php insert_categorie();?>

                            <!-- Add Category Form -->
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat-title">Add Category</label>
                                    <input type="text" class="form-control" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
                                </div>
                            </form> 
                            
                            <!-- UPDATE AND QUERY -->
                            <?php 

                            if (isset($_GET['edit'])) {
                                $cat_id = $_GET['edit'];

                                include "includes/update_categorie.php";
                            }


                            ?>


                        </div>

                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                <!--Show all categories -->
                                <?php showCaterorie(); ?>
                                
                                <!-- Delete categprie -->
                                <?php deleteCategorie();?>


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


<?php include "includes/admin_footer.php"; ?>    
