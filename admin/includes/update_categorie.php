
<?php 

if (isset($_GET['edit'])) {
    $update_cat_id = $_GET['edit'];

    $stmt = mysqli_prepare($connection, "SELECT cat_id, cat_title FROM categories WHERE cat_id = ? ");
    mysqli_stmt_bind_param($stmt, 'i', $update_cat_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);

    while(mysqli_stmt_fetch($stmt)){
         $cat_title;
    }
   
?>


<?php } ?>

<?php // Updete categories
    if (isset($_POST['update_categorie'])) {
        $update_cat_title = $_POST['cat_title'];

        $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
        mysqli_stmt_bind_param($stmt, 'si', $update_cat_title, $cat_id);
        mysqli_stmt_execute($stmt);

        if (!$stmt) {
        die("QUERY FEILED ".mysqli_error($connection));
        }

        redirect("categories.php");
        mysqli_stmt_close($stmt);
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
