
<?php 

// Add user
	if (isset($_POST['add_user'])) {

	$username 		= escape($_POST['username']);
	$user_firstname = escape($_POST['user_firstname']);
	$user_lastname 	= escape($_POST['user_lastname']);
	$user_password 	= escape($_POST['user_password']);

	// $user_image = $_FILES['user_image']['name'];
	// $post_image_temp = $_FILES['user_image']['tmp_name'];

	$user_email = $_POST['user_email'];
	$user_role = $_POST['user_role'];


    // move_uploaded_file($user_image_temp, "../images/$user_image");

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users (username, user_firstname, user_lastname, user_password, user_email, user_role)"; 
    $query .= "VALUES('{$username}', '{$user_firstname}', '{$user_lastname}', '{$user_password}', '{$user_email}', '{$user_role}')";



    $add_user_query = mysqli_query($connection, $query);

    confirmQuery($add_user_query);

    echo "<div class='alert alert-info'>User Created:" . " ". "<a href='users.php'>View Users</a></div>";
    

}

?>
<form action="" method="post" enctype="multipart/form-data">

	
	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input type="text" class="form-control" name="user_firstname">
	</div>

	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input type="text" class="form-control" name="user_lastname">
	</div>

	<div class="form-group">
		<label for="title">Username</label>
		<input type="text" class="form-control" name="username">
	</div>

	<div class="form-group">
		<label for="user_role">User Role</label>
		<select name="user_role" id="" class="form-control">
			<option value="subscriber">Select Options</option>
			<option value="admin">admin</option>
			<option value="subscriber">subscriber</option>
		</select>
	</div>

	<div class="form-group">
		<label for="user_password">Password</label>
		<input type="Password" class="form-control" name="user_password">
	</div>

	<div class="form-group">
		<label for="user_password">Email</label>
		<input type="email" class="form-control" name="user_email">
	</div>

<!-- 	<div class="form-group">
		<label for="user_email">User Image</label>
		<input type="file" name="user_image">
	</div> -->

	


	<input type="submit" name="add_user" class="btn btn-primary" value="Add User">

	
</form>