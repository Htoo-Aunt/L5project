<?php  
function AddProduct($ProductID)
{
	include('../connect.php');

	$query="SELECT p.*,I.* FROM inventory I, products p  WHERE I.InvID='$ProductID' AND I.ProductID=p.ProductID";
	$result=mysqli_query($connect,$query);
	$count=mysqli_num_rows($result);
	$arr=mysqli_fetch_array($result);

	if($count < 1) 
	{
		echo "<p>No Product Found!</p>";
		exit();
	}

	/*if($PurchaseQuantity < 1) 
	{
		echo "<script>window.alert('Please enter correct Quantity.')</script>";
		exit();
	}*/

	if(isset($_SESSION['Order_Functions'])) 
	{
		$Index=IndexOf($ProductID);

		if($Index == -1) 
		{
			$size=count($_SESSION['Order_Functions']);

			$_SESSION['Order_Functions'][$size]['InventoryID']=$ProductID;
			$_SESSION['Order_Functions'][$size]['OrderQuantity']=1;
			$_SESSION['Order_Functions'][$size]['ProductName']=$arr['ProductName'];
			$_SESSION['Order_Functions'][$size]['ProductImage1']=$arr['ProductPhoto'];
			$_SESSION['Order_Functions'][$size]['ProductSize']=$arr['Size'];
			$_SESSION['Order_Functions'][$size]['ProductSKU']=$arr['SKU'];
			$_SESSION['Order_Functions'][$size]['SellPrice']=$arr['SellingPrice'];
		}

		else{

		if ($_SESSION['Order_Functions'][$Index]['OrderQuantity'] < $arr['Quantity']) 
		{
			$_SESSION['Order_Functions'][$Index]['OrderQuantity']+=1;
			
		}
		else{

			echo "<script>window.alert('Quantity exceed!!')</script>";
			echo "<script>window.location='AddOrder.php'</script>";

			
		}
}
	}
	else
	{
			$_SESSION['Order_Functions'][0]['InventoryID']=$ProductID;
			$_SESSION['Order_Functions'][0]['OrderQuantity']=1;
			$_SESSION['Order_Functions'][0]['ProductName']=$arr['ProductName'];
			$_SESSION['Order_Functions'][0]['ProductImage1']=$arr['ProductPhoto'];
			$_SESSION['Order_Functions'][0]['ProductSize']=$arr['Size'];
			$_SESSION['Order_Functions'][0]['ProductSKU']=$arr['SKU'];
			$_SESSION['Order_Functions'][0]['SellPrice']=$arr['SellingPrice'];
	}
}

function CalculateTotalQuantity()
{
	if(isset($_SESSION['Order_Functions'])) 
	{
		$TotalQuantity=0;

		$size=count($_SESSION['Order_Functions']);

		for ($i=0; $i < $size; $i++) 
		{ 
			$PurchaseQuantity=$_SESSION['Order_Functions'][$i]['OrderQuantity'];
			$TotalQuantity += ($PurchaseQuantity);
		}

		return $TotalQuantity;
	}
	else
	{
		$TotalQuantity=0;

		return $TotalQuantity;
	}
}

function CalculateTotalAmount()
{
	if(isset($_SESSION['Order_Functions'])) 
	{
		$TotalAmount=0;

		$size=count($_SESSION['Order_Functions']);

		for ($i=0; $i < $size; $i++) 
		{ 
			$PurchaseQuantity=$_SESSION['Order_Functions'][$i]['OrderQuantity'];
			$PurchasePrice=$_SESSION['Order_Functions'][$i]['SellPrice'];
			$TotalAmount += ($PurchaseQuantity * $PurchasePrice);
		}

		return $TotalAmount;
	}
	else
	{
		$TotalAmount=0;

		return $TotalAmount;
	}
}

function RemoveProduct($ProductID)
{
	$Index=IndexOf($ProductID);

	unset($_SESSION['Order_Functions'][$Index]);

	$_SESSION['Order_Functions']=array_values($_SESSION['Order_Functions']);

	echo "<script>window.location='AddOrder.php'</script>";
}



function IndexOf($ProductID)
{
	if(!isset($_SESSION['Order_Functions'])) 
	{
		return -1;
	}

	if(isset($_SESSION['Order_Functions'])) 
	{
		$size=count($_SESSION['Order_Functions']);

		if ($size < 1) 
		{
			return -1;
		}
		else
		{
			for ($i=0; $i < $size; $i++) 
			{ 
				if($ProductID == $_SESSION['Order_Functions'][$i]['InventoryID']) 
				{
					return $i;
				}
			}
			return -1;
		}
	}
}


function DecreaseCartItem($ProductID)
{
    if (isset($_SESSION['Order_Functions'])) {
        $Index = IndexDec($ProductID);

        if ($Index != -1) {
            // Decrease the quantity, and remove the item if the quantity becomes zero.
            if ($_SESSION['Order_Functions'][$Index]['OrderQuantity'] > 1) {
                $_SESSION['Order_Functions'][$Index]['OrderQuantity'] -= 1;
                echo "<script>window.location='AddOrder.php'</script>";
            } else {
                // Remove the item from the cart if the quantity becomes zero.
                unset($_SESSION['Order_Functions'][$Index]);
                $_SESSION['Order_Functions'] = array_values($_SESSION['Order_Functions']);
                echo "<script>window.location='AddOrder.php'</script>";
            }
        }
    }
}


function IncreaseCartItem($ProductID)
{
	include('../connect.php');
$query="SELECT * FROM inventory WHERE InvID='$ProductID'";

	$result1=mysqli_query($connect,$query);
	
	$arr1=mysqli_fetch_array($result1);

    if (isset($_SESSION['Order_Functions'])) {
        $Index = IndexOf($ProductID);

        if ($Index != -1 && $_SESSION['Order_Functions'][$Index]['OrderQuantity'] < $arr1['Quantity'] ) {
            // Increase the quantity.
            $_SESSION['Order_Functions'][$Index]['OrderQuantity'] += 1;
            echo "<script>window.location='AddOrder.php'</script>";
        }

        else{
        	echo "<script>window.alert('Quantity exceed!!')</script>";
        	echo "<script>window.location='AddOrder.php'</script>";
        }
    }
}



// Assuming you have a function to get the index of a product in the cart.
function IndexDec($ProductID)
{
    if (isset($_SESSION['Order_Functions'])) {
        foreach ($_SESSION['Order_Functions'] as $index => $item) {
            if ($item['InventoryID'] == $ProductID) {
                return $index;
            }
        }
    }
    return -1;
}




?>