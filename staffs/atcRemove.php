<?php 
include('../connect.php');
session_start();

$sku=$_POST['sku'];
	
	
	RemoveProduct($sku);


function IndexOf($ProductID)
{
	if(!isset($_SESSION['Purchase_Functions'])) 
	{
		return -1;
	}

	if(isset($_SESSION['Purchase_Functions'])) 
	{
		$size=count($_SESSION['Purchase_Functions']);

		if ($size < 1) 
		{
			return -1;
		}
		else
		{
			for ($i=0; $i < $size; $i++) 
			{ 
				if($ProductID == $_SESSION['Purchase_Functions'][$i]['ProductSKU']) 
				{
					return $i;
				}
			}
			return -1;
		}
	}
}


function RemoveProduct($ProductID)
{
	$Index=IndexOf($ProductID);

	unset($_SESSION['Purchase_Functions'][$Index]);

	$_SESSION['Purchase_Functions']=array_values($_SESSION['Purchase_Functions']);

	echo "<script>window.location='addpurchase.php'</script>";
}

 ?>