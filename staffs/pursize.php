<?php
include('../connect.php');

$category_id = $_POST["category_id"];
$result = mysqli_query($connect, "SELECT *
FROM sizes
JOIN products ON sizes.CategoryID = products.CategoryID
JOIN category ON products.CategoryID= category.CategoryID
WHERE products.ProductID = $category_id ORDER BY Size ASC;");
?>
<option value="0">Select Size</option>
<?php
while ($row = mysqli_fetch_array($result)) {
    ?>
    <option value="<?php echo $row["SizeID"]; ?>"><?php echo $row["Size"]; ?></option>
    <?php
}
?>