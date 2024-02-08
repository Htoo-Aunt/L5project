<?php
include('../connect.php');

if (isset($_POST['supplierID'])) {
    $supplierID = $_POST['supplierID'];

    // Perform the delete operation based on the received supplierID
    $deleteQuery = "DELETE FROM suppliers WHERE SupplierID = $supplierID";
    $result = mysqli_query($connect, $deleteQuery);

    if ($result) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($connect);
    }
} else {
    echo "Invalid request";
}

mysqli_close($connect);
?>
