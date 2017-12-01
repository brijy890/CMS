<?php include("delete_model.php"); ?>
<?php deletePost(); ?>

<?php 
if (isset($_POST['checkBoxarray'])) {
    
    foreach ($_POST['checkBoxarray'] as $postValueId) {
        $bulkoptions = $_POST['bulkoptions']; 

        switch ($bulkoptions) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulkoptions}' WHERE post_id = '{$postValueId}' ";
                $publish_post_query = mysqli_query($connection, $query);

                confirmQuery($publish_post_query);
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulkoptions}' WHERE post_id = '{$postValueId}' ";
                $draft_post_query = mysqli_query($connection, $query);

                confirmQuery($draft_post_query);
                break;

            case 'delete':
                
                $query = "DELETE FROM posts WHERE post_id = '{$postValueId}' ";
                $delete_post_query = mysqli_query($connection, $query);

                confirmQuery($delete_post_query);
                break;

            case 'clone':
                
                $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
                $copy_posts_query = mysqli_query($connection, $query);

                confirmQuery($copy_posts_query);

                while ($row = mysqli_fetch_assoc($copy_posts_query)) {
                $post_id   = $row['post_id'];
                $post_title   = $row['post_title'];
                $post_categorie_id   = $row['post_categorie_id'];
                // $post_author  = $row['post_author'];
                $post_user  = $row['post_user'];
                $post_date    = $row['post_date'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_view_count = $row['post_view_count'];
                }

                $query = "INSERT INTO posts ";
                $query .= "(post_categorie_id, post_title, post_date, post_image, post_content, post_tags, post_status, post_comment_count, post_view_count, post_user)";
                $query .= "VALUES('{$post_categorie_id}', '{$post_title}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}', '{$post_comment_count}', '{$post_view_count}', '{$post_user}')";



                $copy_post_query = mysqli_query($connection, $query);

                confirmQuery($copy_post_query);

                break;
      
        }
    }
}



?>
<form action="" method="post">
<table class="table table-bordered table-hover">
    <div id="bulkoptioncontainer" class="col-xs-4">
        <select name="bulkoptions" id="" class="form-control">
            <option value="">Select a option</option>
            <option value="draft">Draft</option>
            <option value="published">Publish</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>

    <div class="col-xs-4">
        <button class="btn btn-success" type="submit" name="submit" value="Apply">Apply</button>
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
    <thead>
        <tr>
            <th><input type="checkbox" id="selectAllBoxes"></th>
            <th>Id</th>
            <th>Title</th>
            <th>Users</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Views</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
<?php
        
// show all posts
$query = "SELECT posts.post_id, posts.post_title, posts.post_categorie_id, posts.post_user, "; 
$query .= "posts.post_date, posts.post_status, posts.post_image, posts.post_tags, ";
$query .= "posts.post_comment_count, posts.post_view_count, categories.cat_id, ";
$query .= "categories.cat_title ";
$query .= "FROM posts ";
$query .= "LEFT JOIN categories ON posts.post_categorie_id = categories.cat_id ORDER BY posts.post_id DESC";

        $select_all_posts_query = mysqli_query($connection, $query);

        confirmQuery($select_all_posts_query);

        while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
        $post_id                = $row['post_id'];
        $post_title             = $row['post_title'];
        $post_categorie_id      = $row['post_categorie_id'];
        $post_user              = $row['post_user'];
        $post_date              = $row['post_date'];
        $post_status            = $row['post_status'];
        $post_image             = $row['post_image'];
        $post_tags              = $row['post_tags'];
        $post_comment_count     = $row['post_comment_count'];
        $post_view_count        = $row['post_view_count'];
        $categroy_id            = $row['cat_id'];
        $categroy_title         = $row['cat_title'];


        echo "<tr>";
        ?>

        <td><input type='checkbox' class='checkBoxes' name='checkBoxarray[]' value='<?php echo $post_id;?>'></td>

        <?php
        echo "<td>{$post_id}</td>";
        echo "<td>{$post_title}</td>";

        if (!empty($post_author)) {
            echo "<td>{$post_author}</td>";
        } else if(!empty($post_user)){
            echo "<td>{$post_user}</td>";
        }

        echo "<td>{$categroy_title}</td>";
        echo "<td>{$post_status}</td>";
        echo "<td><img width='100' src='../images/$post_image'></td>";
        echo "<td>{$post_tags}</td>";

        $query = "SELECT * FROM comments WHERE comment_post_id = '{$post_id}' ";
        $send_comment_query = mysqli_query($connection, $query);

        $row = mysqli_fetch_array($send_comment_query);
        $comment_id = $row['comment_id'];
        $comment_count = mysqli_num_rows($send_comment_query);


        echo "<td><a href='comments.php?source=view_comments&p_id=$post_id'>{$comment_count}</a></td>";

        echo "<td><a href='posts.php?reset_views=$post_id'>{$post_view_count}</a></td>";
        echo "<td>{$post_date}</td>";
        echo "<td><a class='btn btn-primary' href='../post.php?p_id=$post_id'>View Post</a></td>";

        ?>

        <form action="" method="post">
            <input type="hidden" value="<?php echo $post_id; ?>" name="post_id">
        <?php
            echo "<td><input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>"
        ?>
        </form>

        <?php


        // echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";





        echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
        echo "</tr>";
        }

        ?>
    </tbody>
</table>
</form>

<?php

if (isset($_GET['reset_views'])) {
    
    $reset_view_count = $_GET['reset_views'];

    $query = "UPDATE posts SET post_view_count = 0 WHERE post_id = '{$reset_view_count}' "; 

    $reset_view_count = mysqli_query($connection, $query);

    if (!$reset_view_count) {
        die("Query Feiled".mysqli_error($connection));
    } else{
        header("Location: posts.php");
    }  
}



?>


<script>
    
    $(document).ready(function(){

        $(".delete_link").on('click', function(){
            
            var id = $(this).attr("rel");

            var delete_url = "posts.php?delete="+ id +" ";

            $(".modal_delete_link").attr('href', delete_url);

            $("#myModal").modal('show');

        });


    });

</script>