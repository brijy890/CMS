<?php include "includes/db.php";?>
<?php include "includes/header.php";?>
    <!-- Navigation -->
    <?php include "includes/navigation.php";?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
                <?php

                if(isset($_GET['p_id'])){
                     $the_post_id = $_GET['p_id']; 
                
                $query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = '{$the_post_id}' ";
                $posts_view_count_query = mysqli_query($connection, $query);

                if (!$posts_view_count_query) {
                        die("Query Feiled".mysqli_error($connection));
                    }

                $query = "SELECT * FROM posts WHERE post_id = '{$the_post_id}' ";
                $select_all_posts_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title   = $row['post_title'];
                    $post_user  = $row['post_user'];
                    $post_date    = $row['post_date'];
                    $post_image   = $row['post_image'];
                    $post_content = $row['post_content'];


                ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ;?></a>
                </h2>
                <p class="lead">
                    by <a href="user_post.php?user=<?php echo $post_user ;?>&p_id=<?php echo $post_id ;?>"><?php echo $post_user ;?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ;?>" alt="">
                <hr>
                <p><?php echo $post_content ;?></p>
                <!-- <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> -->

                <hr>
                <?php  }  

            } else {

                header("Location: index.php");
            }
            ?>




                <?php 

                if (isset($_POST['create_comment'])) {

                    $the_post_id = $_GET['p_id'];

                    $comment_author  = $_POST['comment_author'];
                    $comment_email   = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];

                    if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                        
                    $comment_post_id = $the_post_id;
                    $comment_date = date('d-m-y');
                    $comment_status = 'pending';

                    $query = "INSERT INTO comments";
                    $query .= "(comment_author, comment_post_id, comment_email, comment_content, comment_date, comment_status)";
                    $query .= "VALUES ('{$comment_author}', '{$comment_post_id}', '{$comment_email}', '{$comment_content}', '{$comment_date}', '{$comment_status}' )";

                    $insert_comment_query = mysqli_query($connection, $query);

                    if (!$insert_comment_query) {
                        die("Query failed".mysqli_error($connection));
                    } 

                    } else{
                        echo "<script>
                        alert('Feiled cannot be empty');
                        </script>";
                    }
                
                }

                ?>

                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post">

                        <div class="form-group">
                            <label for="comment_author">Name</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Comment</button>
                    </form>
                </div>

                <hr>



                <?php 
                

                $query = "SELECT * FROM Comments WHERE comment_post_id = '{$the_post_id}' AND comment_status = 'Apporoved' ORDER BY comment_id DESC";

                $show_comments = mysqli_query($connection, $query);

                if (!$show_comments) {
                    die("Query Feiled".mysqli_error($connection));
                }

                while ($row = mysqli_fetch_assoc($show_comments)) {
                $comment_author       = $row['comment_author'];
                $comment_content    = $row['comment_content'];
                $comment_date       = $row['comment_date'];

                ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                        <!-- Nested Comment -->

                        
                        <!-- End Nested Comment -->
                    </div>
                </div>

                <?php } ?>
        












                <!-- Comment -->


                <!-- Posted Comments -->

            </div>

            <!-- Blog Sidebar Widgets Column -->
                <?php include "includes/sidebar.php";?>

                   </div>
        <!-- /.row -->

        <hr>








       

<?php include "includes/footer.php";?>
