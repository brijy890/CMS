
<?php include "includes/admin_header.php"; ?>

<?php 

if (isset($_SESSION['username'])) {
    $update_profile = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '{$update_profile}'";

    $profile_update_query = mysqli_query($connection, $query);

    confirmQuery($profile_update_query);

    while ($row = mysqli_fetch_assoc($profile_update_query)) {
    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_password = $row['user_password'];

    $user_image = $row['user_image'];



    $user_email = $row['user_email'];
    $user_role = $row['user_role'];
}
}

if (isset($_POST['update_profile'])) {

    $username = $_POST['username'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_password = $_POST['user_password'];

    // $user_image = $_FILES['user_image']['name'];
    // $post_image_temp = $_FILES['user_image']['tmp_name'];

    $user_email = $_POST['user_email'];
    $user_role = $_POST['user_role'];


    // move_uploaded_file($user_image_temp, "../images/$user_image");

    $query = "UPDATE users SET ";
    $query .= "username = '{$username}', ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_password = '{$user_password}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_role = '{$user_role}' ";
    $query .= "WHERE username = '{$update_profile}' ";



    $update_profile_query = mysqli_query($connection, $query);

    confirmQuery($update_profile_query);
    

}

?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>
        <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="page-header">
                            Wellcome Admin
                            <small><?php echo $username; ?></small>
                        </h1>
                        
                            <form action="" method="post" enctype="multipart/form-data">

    
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lasname</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
    </div>

    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>

    <div class="form-group">
        <label for="user_role">User Role</label>
        <select name="user_role" id="" class="form-control" value="<?php echo $user_role; ?>">
            <option value="subscriber"><?php echo $user_role; ?></option>
            <?php 

            if($user_role == 'admin') {
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="Password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>

<!--    <div class="form-group">
        <label for="user_email">User Image</label>
        <input type="file" name="user_image">
    </div> -->

    


    <input type="submit" name="update_profile" class="btn btn-primary" value="Update">

    
</form>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->


<?php include "includes/admin_footer.php"; ?>    
