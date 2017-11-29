
<?php 
if (isset($_GET['p_id'])) {
    $post_id = $_GET['p_id'];
}


?>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Email</th>
            <th>Content</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>

        </tr>
    </thead>
    <tbody>


        <?php 

        $query = "SELECT * FROM Comments WHERE comment_post_id = '{$post_id}'";

        $show_comments = mysqli_query($connection, $query);

        confirmQuery($show_comments);

        while ($row = mysqli_fetch_assoc($show_comments)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            echo "<tr>";
            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_content}</td>";
            echo "<td>{$comment_status}</td>";

            $query = "SELECT * FROM posts WHERE post_id = '{$comment_post_id}'";

            $select_post_query = mysqli_query($connection, $query);

            if (!$select_post_query) {
                die("Query Failed ".mysqli_erro($connection));
            }

            while ($row = mysqli_fetch_assoc($select_post_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];

                echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";

            }



            echo "<td>{$comment_date}</td>";
            echo "<td><a href='comments.php?approve={$comment_id}'>Approved</a></td>";
            echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapporoved</a></td>";
            echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
            echo "</tr>";
        }

        ?>
    </tbody>
</table>

<?php 


    if (isset($_GET['unapprove'])) {
    $unapprove_comment = $_GET['unapprove'];

    $query = "UPDATE comments SET comment_status = 'Unapporoved' WHERE comment_id = '{$unapprove_comment}' ";

    $unapprove_comment = mysqli_query($connection, $query);
    header("Location: comments.php");

    if(!$unapprove_comment){
        die("query failed".mysqli_error($connection));
    }


    }

    if (isset($_GET['approve'])) {
    $approve_comment = $_GET['approve'];

    $query = "UPDATE comments SET comment_status = 'Apporoved' WHERE comment_id = '{$approve_comment}' ";

    $approve_comment = mysqli_query($connection, $query);
    header("Location: comments.php");

    if(!$approve_comment){
        die("query failed".mysqli_error($connection));
    }


    }



    if (isset($_GET['delete'])) {
    $delete_comment = $_GET['delete'];

    $query = "DELETE FROM comments WHERE comment_id = '{$delete_comment}' ";

    $delete_comment = mysqli_query($connection, $query);
    
    if(!$delete_comment){
        die("query failed".mysqli_error($connection));
    }else {
        header("Location: comments.php");
    }


    }




?>