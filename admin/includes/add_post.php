
<?php 

// Add posts
	if (isset($_POST['add_post'])) {

	$post_title = $_POST['post_title'];
	$post_categroie_id = $_POST['categroy_id'];
	// $post_post_author = $_POST['post_author'];
	$post_status = $_POST['post_status'];
	$post_user = $_POST['post_user'];

	$post_image = $_FILES['post_image']['name'];
	$post_image_temp = $_FILES['post_image']['tmp_name'];

	$post_tags = $_POST['post_tags'];
	$post_content = $_POST['post_content'];

	$post_date = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts"; 
    $query .= "(post_categorie_id,";
    $query .= "post_title,";
    $query .= "post_user,";
    $query .= "post_date,";
    $query .= "post_image,";
    $query .= "post_content,";
    $query .= "post_tags,";
    $query .= "post_status)";
    $query .= " VALUES";
    $query .= "('{$post_categroie_id}',";
    $query .= " '{$post_title}', ";
    $query .= " '{$post_user}', ";
    $query .= " '{$post_date}', ";
    $query .= " '{$post_image}', ";
    $query .= " '{$post_content}', ";
    $query .= " '{$post_tags}', ";
    $query .= " '{$post_status}')";



    $add_post_query = mysqli_query($connection, $query);

    confirmQuery($add_post_query);

    $query = "SELECT * FROM posts";

    $select_post_query = mysqli_query($connection, $query);

    confirmQuery($select_post_query);

    while ($row = mysqli_fetch_assoc($select_post_query)) {
    	$select_post_id = $row['post_id'];
    }

    echo "<div class='alert alert-info'><p>Post Added: <a href='../post.php?p_id=$select_post_id'>View Post</a></p></div>";
    

}

?>
<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="post_title">
	</div>



	<div class="form-group">
		<label for="categroy-id">Post Categroy Id</label>
		<select name="categroy_id"  class="form-control select-area">

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
		<input type="text" class="form-control" name="post_author">
	</div> -->
	<div class="form-group">
		<label for="post-status">Post Status</label>
		<select name="post_status" class="form-control select-area">
			<option value="draft">Slect Option</option>
			<option value="draft">Draft</option>
			<option value="published">Publish</option>
		</select>
	</div>
	<div class="form-group">
		<label for="post-image">Post Image</label>
		<input type="file" name="post_image">
	</div>
	<div class="form-group">
		<label for="post-tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>

	<div class="form-group">
		<label for="post-content">Post content</label>
		<textarea name="post_content" id="" cols="30" rows="10" class="form-control"></textarea>
	</div>
	<input type="submit" name="add_post" class="btn btn-primary" value="Publish Post">

	
</form>