
<?php 

if (isset($_GET['edit'])) {
    $update_cat_id = $_GET['edit'];

    $query = "SELECT * FROM categories WHERE cat_id = {$update_cat_id} ";
    $update_cat_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($update_cat_id)) {
    $cat_title = $row['cat_title'];
}
?>


<?php } ?>

<?php // Updete categories
if (isset($_POST['update_categorie'])) {
$update_cat_title = $_POST['cat_title'];

$query = "UPDATE categories SET cat_title = '{$update_cat_title}' WHERE cat_id = {$cat_id} ";
$update_query = mysqli_query($connection,$query);

if (!$update_query) {
die("QUERY FEILED ".mysqli_error($connection));
}
}
?>

<!-- Update Category Form -->
<form action="" method="post">
    <div class="form-group">
    <label for="cat-title">Edit Category</label>
    <div class="form-group">
       <input value="<?php if(isset($cat_title)){echo $cat_title;}; ?>" type="text" class="form-control" name="cat_title"> 
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_categorie" value="Update Category">
    </div>
    </div>
</form> 
