
 <div class="col-md-4">

                <!-- Blog Search Well -->


                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="POST">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                </form><!-- search form -->
                    <!-- /.input-group -->
                </div>

                
                <!-- Blog Categories Well -->


                <?php 

                if (isset($_SESSION['user_role'])) {

                ?>

                <div class="well">

                <div class="row">
                <div class="col-lg-12">
                <ul class="list-unstyled">

                <h2>Logined as <?php echo $_SESSION['username']; ?></h2>

                <a class="btn btn-primary" href="includes/logout.php">Logout</a>

                </ul>
                </div>
                <!-- /.col-lg-6 -->

                <!-- /.col-lg-6 -->
                </div>
                <!-- /.row -->
                </div>



                <?php 
            
            } else {

                ?>
                
                <!-- Login Form -->
                <div class="well">
                    <h4>Login</h4>
                    <form action="includes/login.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Enter Username">
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">

                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit" name="login">Submit</button>
                        </span>
                    </div>
                </form><!-- search form -->
                    <!-- /.input-group -->
                </div>

                <?php

            }

            ?>

                <div class="well">

                <?php 

                $query = "SELECT * FROM categories";
                $slect_all_categories_sidebar = mysqli_query($connection, $query);

                ?>




                <h4>Blog Categories</h4>
                <div class="row">
                <div class="col-lg-12">
                <ul class="list-unstyled">

                <?php

                while ($row = mysqli_fetch_assoc($slect_all_categories_sidebar)) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                echo "<li><a href='categories.php?categroy=$cat_id'>{$cat_title}</a></li>";
                }

                ?>

                </ul>
                </div>
                <!-- /.col-lg-6 -->

                <!-- /.col-lg-6 -->
                </div>
                <!-- /.row -->
                </div>



                <!-- Side Widget Well -->
                <?php include "widget.php";?>

            </div>