
<?php


function escape($string){

	global $connection;

	return mysqli_real_escape_string($connection, trim($string));
}


function recordCount($table){

	global $connection;

	$query = "SELECT * FROM $table";

	$result = mysqli_query($connection, $query);

	$result = mysqli_num_rows($result);

	// confirmQuery($result);

	return $result;
}

function QueryStatus($table, $column, $status){

	global $connection;
	$query = "SELECT * FROM $table WHERE $column = '$status' ";
	$result = mysqli_query($connection, $query);
	$result = mysqli_num_rows($result);
	// confirmQuery($result);
	return $result;

}




function users_online(){

	if (isset($_GET['onlineusers'])) {
		
		global $connection;

		if (!$connection) {

			session_start();
		
			include("../includes/db.php");

			$session = session_id();
			$time = time();
			$time_out_in_seconds = 05;
			$time_out = $time - $time_out_in_seconds;

			$query = "SELECT * FROM users_online WHERE session = '{$session}' ";
			$send_session_query = mysqli_query($connection, $query);

			confirmQuery($send_session_query);

			$count = mysqli_num_rows($send_session_query);

			if ($count == NULL) {
				mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', '$time')");
				} else {
				mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session' ");
			}

			$users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '{$time_out}' ");
			confirmQuery($users_online_query);

			echo $count_users = mysqli_num_rows($users_online_query);


		}

	}

}
users_online();

function confirmQuery($Query){
	global $connection;
	if (!$Query) {
		die("QUERY FAILED ".mysqli_error($connection));
	}
}


// Inser categorie function
function insert_categorie(){
	global $connection;
	if(isset($_POST['submit'])){
		$cat_title = $_POST['cat_title'];

		if ($cat_title == "" || empty($cat_title)) {
			echo "This fileh can not be empty";
		} else{

			$stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES (?) ");

			mysqli_stmt_bind_param($stmt, 's', $cat_title);
			mysqli_stmt_execute($stmt);

			if (!$stmt) {
				die("Category Not Addes ".mysqli_error($connection));
			}
		}
	}    
}

// show categorie function
function showCaterorie(){
global $connection;
$query = "SELECT * FROM categories";
$slect_all_categories = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($slect_all_categories)) {
$cat_title = $row['cat_title'];
$cat_id = $row['cat_id'];
echo "<tr>";
echo "<td>{$cat_id}</td>";
echo "<td>{$cat_title}</td>";
echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
echo "</tr>";
}
}

// Delete categorie function
function deleteCategorie(){
global $connection;    
if (isset($_GET['delete'])) {
$del_cat_id = $_GET['delete'];

$query = "DELETE FROM categories WHERE cat_id = {$del_cat_id}";
$del_cat_id = mysqli_query($connection,$query);
header("Location: categories.php");

if (!$del_cat_id) {
die("QUERY FEILED ".mysqli_error($connection));
}
}
}

 

// delete post
function deletePost(){
global $connection;    
if (isset($_POST['post_id'])) {
$del_post_id = $_POST['post_id'];

$query = "DELETE FROM posts WHERE post_id = {$del_post_id}";
$del_cat_id = mysqli_query($connection,$query);
header("Location: posts.php");

if (!$del_cat_id) {
die("QUERY FEILED ".mysqli_error($connection));
}
}
}


function is_admin( $username){

	global $connection;

	$query = "SELECT user_role FROM users WHERE username = '{$username}' ";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

	$row = mysqli_fetch_array($result);

	if ($row['user_role'] == 'admin') {
		
		return true;
	} else{
		return false;
	}
}


function username_exixts($username){

	global $connection;

	$query = "SELECT username FROM users WHERE username = '{$username}' ";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

	if (mysqli_num_rows($result) > 0) {
		
		return true;
	} else{
		return false;
	}
}

function email_exixts($email){

	global $connection;

	$query = "SELECT user_email FROM users WHERE user_email = '{$email}' ";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

	if (mysqli_num_rows($result) > 0) {
		
		return true;
	} else{
		return false;
	}
}

function redirect($location){

	global $connection;

	return header("Location:".$location);
}

function register_user($username, $email, $password){

	global $connection;
	$username    = mysqli_real_escape_string($connection, $username);
	$email      = mysqli_real_escape_string($connection, $email);
	$password   = mysqli_real_escape_string($connection, $password); 
	$password   = password_hash($password, PASSWORD_BCRYPT , array('cost' => 12));
	$query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES ('{$username}', '{$email}', '{$password}', 'subscriber')";
	$register_user_query = mysqli_query($connection, $query);
	confirmQuery($register_user_query);
}

function login_user($username, $password){

		global $connection;
		$username = trim($username);
		$password = trim($password);
		$username = mysqli_real_escape_string($connection, $username);
		$password = mysqli_real_escape_string($connection, $password);
		$query = "SELECT * FROM users WHERE username = '{$username}' ";
		$select_user = mysqli_query($connection, $query);
		confirmQuery($select_user);


		while ($row = mysqli_fetch_assoc($select_user)) {
		$db_user_id 		= $row['user_id'];
        $db_username 		= $row['username'];
        $db_user_password 	= $row['user_password'];
        $db_user_firstname 	= $row['user_firstname'];
        $db_user_lastname 	= $row['user_lastname'];
        $db_user_email 		= $row['user_email'];
        $db_user_image 		= $row['user_image'];
        $db_user_email 		= $row['user_email'];
        $db_user_role 		= $row['user_role'];
		}


		if (password_verify($password, $db_user_password)) {

			$_SESSION['username'] 	= $db_username;
			$_SESSION['firstname'] 	= $db_user_firstname;
			$_SESSION['lastname'] 	= $db_user_lastname;
			$_SESSION['user_role'] 	= $db_user_role;

			redirect('/cms/admin');
			
		} else {
			redirect('/cms/index.php');
		}
}

?>