
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
<!--             <th>Image</th> -->
            <th>Role</th>
        </tr>
    </thead>
    <tbody>


        <?php 

        $query = "SELECT * FROM users";

        $show_users = mysqli_query($connection, $query);

        confirmQuery($show_users);

        while ($row = mysqli_fetch_assoc($show_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];

            $user_image = $row['user_image'];



            $user_email = $row['user_email'];
            $user_role = $row['user_role'];

            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            // echo "<td><img src='../images/$user_image' width=100></td>";
            echo "<td>{$user_role}</td>";

            // $query = "SELECT * FROM posts WHERE post_id = '{$comment_post_id}'";

            // $select_post_query = mysqli_query($connection, $query);

            // if (!$select_post_query) {
            //     die("Query Failed ".mysqli_erro($connection));
            // }

            // while ($row = mysqli_fetch_assoc($select_post_query)) {
            //     $post_id = $row['post_id'];
            //     $post_title = $row['post_title'];

            //     echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";

            // }



            echo "<td><a href='users.php?change_to_admin={$user_id}'>admin</a></td>";
            echo "<td><a href='users.php?change_to_sub={$user_id}'>subscriber</a></td>";
            echo "<td><a href='users.php?source=edit_user&p_id={$user_id}'>Edit</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "</tr>";
        }

        ?>
    </tbody>
</table>

<?php 


    if (isset($_GET['change_to_sub'])) {
    $change_to_sub_id = $_GET['change_to_sub'];

    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = '{$change_to_sub_id}' ";

    $change_to_sub_id_query = mysqli_query($connection, $query);
    header("Location: users.php");

    if(!$change_to_sub_id_query){
        die("query failed".mysqli_error($connection));
    }


    }

    if (isset($_GET['change_to_admin'])) {
    $change_to_admin_id = $_GET['change_to_admin'];

    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = '{$change_to_admin_id}' ";

    $change_to_admin_query = mysqli_query($connection, $query);
    header("Location: users.php");

    if(!$change_to_admin_query){
        die("query failed".mysqli_error($connection));
    }


    }



    if (isset($_GET['delete'])) {

    if ($_SESSION['user_role']) {

        if ($_SESSION['user_role'] == 'admin') {

        
       
    $delete_user = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM users WHERE user_id = '{$delete_user}' ";

    $delete_user = mysqli_query($connection, $query);
    header("Location: users.php");

    if(!$delete_user){
        die("query failed".mysqli_error($connection));
    }


    }

}

}


?>