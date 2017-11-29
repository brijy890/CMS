<?php 

if (isset($_GET['p_id'])) {
	
	$edit_post_id = $_GET['p_id'];

	}

	$query = "SELECT * FROM posts WHERE post_id = '{$edit_post_id}' ";
	$edit_post_query = mysqli_query($connection, $query);

	if (!$edit_post_query) {
		die("QUERY FIELED ".mysqli_error($connection));
	}

	while ($row = mysqli_fetch_assoc($edit_post_query)) {
		$post_id 			= $row['post_id'];
		$post_title 		= $row['post_title'];
		$post_categroie_id 	= $row['post_categorie_id'];
		// $post_author = $row['post_author'];
		$post_user 			= $row['post_user'];
		$post_status 		= $row['post_status'];
		$post_image 		= $row['post_image'];
		$post_title 		= $row['post_title'];
		$post_tags 			= $row['post_tags'];
		$post_content 		= $row['post_content'];
		$post_view_count 	= $row['post_view_count'];

}

	if (isset($_POST['update_post'])) {

	$post_title 		= escape($_POST['post_title']);
	$post_categroie_id 	= $_POST['categroy_id'];
	// $post_post_author = $_POST['post_author'];
	$post_user 			= escape($_POST['post_user']);
	$post_status 		= escape($_POST['post_status']);
	$post_view_count 	= $_POST['post_views'];
	$post_image 		= escape($_FILES['post_image']['name']);
	$post_image_temp 	= escape($_FILES['post_image']['tmp_name']);
	$post_tags 			= escape($_POST['post_tags']);
	$post_content 		= escape($_POST['post_content']);
	$post_date 			= date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if (empty($post_image)) {
    	$query = "SELECT * FROM posts WHERE post_id = '{$edit_post_id}' ";

    	$select_post_image = mysqli_query($connection, $query);

		confirmQuery($select_post_image);

		while ($row = mysqli_fetch_assoc($select_post_image)) {
			$post_image = $row['post_image'];
		}
    }

	$query = "UPDATE posts SET ";
	$query .= "post_title = '{$post_title}', ";
	$query .= "post_categorie_id = '{$post_categroie_id}', ";
	$query .= "post_date = now(), ";
	// $query .= "post_author = '{$post_author}', ";
	$query .= "post_user = '{$post_user}', ";
	$query .= "post_status = '{$post_status}', ";
	$query .= "post_image = '{$post_image}', ";
	$query .= "post_tags = '{$post_tags}', ";
	$query .= "post_view_count = '{$post_view_count}', ";
	$query .= "post_content = '{$post_content}' ";
	$query .= "WHERE post_id = '{$edit_post_id}'";

	$update_post_query = mysqli_query($connection, $query);

	confirmQuery($update_post_query);

	echo "<div class='alert alert-info'><p>Post Updated: <a href='../post.php?p_id=$edit_post_id'>View Post</a></p></div>";
		

	}


?>




<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
	</div>


	<div class="form-group">
		<label for="categroy-id">Post Categroy</label>
		<select name="categroy_id" id="" class="form-control select-area">
			<?php 

			$query = "SELECT * FROM categories";

			$select_categorie_id_query = mysqli_query($connection, $query);

			if (!$select_categorie_id_query) {
				die("QUERY FAILED ".mysqli_error($connection));
			}

			while ($row = mysqli_fetch_assoc($select_categorie_id_query)) {
				$categroy_id = $row['cat_id'];
				$categroy_title = $row['cat_title'];

				echo "<option value='$categroy_id'>{$categroy_title}</option>";

			}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="user">Users</label>
		<select name="post_user"  class="form-control select-area">

			<?php echo "<option value='{$post_user}'>{$post_user}</option>"; ?>

			<?php 

			$query = "SELECT * FROM users";

			$select_user_query = mysqli_query($connection, $query);

			if (!$select_user_query) {
				die("QUERY FAILED ".mysqli_error($connection));
			}

			while ($row = mysqli_fetch_assoc($select_user_query)) {
				$user_id = $row['user_id'];
				$username = $row['username'];

				echo "<option value='{$username}'>{$username}</option>";

			}
			?>
		</select>
	</div>


	<!-- <div class="form-group">
		<label for="post-author">Post Author</label>
		<input type="text" class="form-control" name="post_author" value="<?php echo $post_author;?>">
	</div> -->
	<div class="form-group">
		<label for="post-status">Post Status</label>
		<select name="post_status" id="" class="form-control select-area">
			<option value="<?php echo $post_status;?>"><?php echo $post_status;?></option>

			<?php 
			if ($post_status === 'published') {
				echo "<option value='draft'>Draft</option>";
			} else{
				echo "<option value='published'>Publish</option>";
			}
			?>	
		</select>
	</div>

	<div class="form-group">
		<label for="post-vies">Post Views</label>
		<input type="text" class="form-control select-area" name="post_views" value="<?php echo $post_view_count; ?>">
	</div>

	<div class="form-group">
		<img width=100 src="../images/<?php echo $post_image;?>" alt="image">
		<input type="file" name="post_image">
	</div>
	<div class="form-group">
		<label for="post-tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
	</div>
	<div class="form-group">
		<label for="post-content">Post content</label>
		<textarea name="post_content" id="" cols="30" rows="10" class="form-control">
			<?php echo str_replace('\r\n', '</br>', $post_content); ?>
		</textarea>
	</div>
	<input type="submit" name="update_post" class="btn btn-primary" value="Publish Post">

	
</form>