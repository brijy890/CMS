
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

	confirmQuery($result);

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

function confirmQuery($Query_result){
	global $connection;
	if (!$Query_result) {
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
$query = "INSERT INTO categories(cat_title) VALUES ('$cat_title')";

$cat_title = mysqli_query($connection, $query);

if (!$cat_title) {
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
if (isset($_GET['delete'])) {
$del_post_id = $_GET['delete'];

$query = "DELETE FROM posts WHERE post_id = {$del_post_id}";
$del_cat_id = mysqli_query($connection,$query);
header("Location: posts.php");

if (!$del_cat_id) {
die("QUERY FEILED ".mysqli_error($connection));
}
}
}


?>