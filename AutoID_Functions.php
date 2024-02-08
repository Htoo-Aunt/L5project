<?php
function AutoID($tableName, $fieldName, $noOfLeadingZeros)
{ 
    include('connect.php');

    $newID = "";
    $sql = "";
    $value = 1;
    
    $sql = "SELECT " . $fieldName . " FROM " . $tableName . " ORDER BY " . $fieldName . " DESC";    
    
    $result = mysqli_query($connect, $sql);
    $noOfRow = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);        
    
    if ($noOfRow < 1)
    {       
        return str_pad("1", $noOfLeadingZeros, "0", STR_PAD_RIGHT); // Ensure that the returned ID has the specified number of leading zeros
    }
    else
    {
        $oldID = $row[$fieldName];    // Reading Last ID
    
        $value = intval($oldID);    // Convert to Integer
        $value++;    // Increment    
        $newID = NumberFormatter($value, $noOfLeadingZeros);         
        return $newID;      
    }
}

function NumberFormatter($number, $n) 
{   
    return str_pad($number, $n, "0", STR_PAD_RIGHT);
}
?>
