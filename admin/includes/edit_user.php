
<?php 

// Edit user
	if (isset($_GET['p_id'])) {
		
		$edit_user_id = $_GET['p_id'];

		
		$query = "SELECT * FROM users";

		$show_users = mysqli_query($connection, $query);

		confirmQuery($show_users);

		while ($row = mysqli_fetch_assoc($show_users)) {
			$user_id 		= $row['user_id'];
			$username 		= $row['username'];
			$user_firstname = $row['user_firstname'];
			$user_lastname 	= $row['user_lastname'];
			$user_email 	= $row['user_email'];
			$user_password 	= $row['user_password'];

			$user_image 	= $row['user_image'];

			$user_email 	= $row['user_email'];
			$user_role 		= $row['user_role'];

		}



		if (isset($_POST['edit_user'])) {

			$username 		= $_POST['username'];
			$user_firstname = $_POST['user_firstname'];
			$user_lastname 	= $_POST['user_lastname'];
			$user_password 	= $_POST['user_password'];

			// $user_image = $_FILES['user_image']['name'];
			// $post_image_temp = $_FILES['user_image']['tmp_name'];

			$user_email 	= $_POST['user_email'];
			$user_role 		= $_POST['user_role'];

			if (!empty($user_password)) {
				$query_password = "SELECT user_password FROM users WHERE user_id = '{$edit_user_id}' ";

				$query_password = mysqli_query($connection, $query_password);

				confirmQuery($query_password);

				$row = mysqli_fetch_array($query_password);

				$db_user_password = $row['user_password'];

				if ($db_user_password != $user_password) {
					$hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
				}

				$query = "UPDATE users SET ";
			    $query .= "username = '{$username}', ";
			    $query .= "user_firstname = '{$user_firstname}', ";
			    $query .= "user_lastname = '{$user_lastname}', ";
			    $query .= "user_password = '{$hashed_password}', ";
			    $query .= "user_email = '{$user_email}', ";
			    $query .= "user_role = '{$user_role}' ";
			    $query .= "WHERE user_id = '{$edit_user_id}' ";



			    $edit_user_query = mysqli_query($connection, $query);

			    confirmQuery($edit_user_query);

			    echo "<div class='alert alert-info'><p>User Updated: <a href='../users.php'>View Users?</a></p></div>";

			
			}  

		} 

	} else {
		header("Location: index.php");
}

?>

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
			<option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
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


	<input type="submit" name="edit_user" class="btn btn-primary" value="Update User">

	
</form>