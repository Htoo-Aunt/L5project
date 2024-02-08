<?php 
include('../connect.php');
session_start();  


$Category = $_POST['category'];
$Size = $_POST['size'];
$price=$_POST['price'];
$quantity=$_POST['qty'];

AddProduct($Category,$Size,$price,$quantity);


	


function AddProduct($ProductID,$Size,$PurchasePrice,$PurchaseQuantity)
{
	include('../connect.php');

	$query="SELECT p.*,s.*,c.* FROM products p,sizes s, category c WHERE p.ProductID='$ProductID' AND p.CategoryID=c.CategoryID AND s.SizeID='$Size'";
	$result=mysqli_query($connect,$query);
	$count=mysqli_num_rows($result);
	$arr=mysqli_fetch_array($result);

	if($count < 1) 
	{
		echo "<p>No Product Found!</p>";
		exit();
	}

	if($PurchaseQuantity < 1) 
	{
		echo "<script>window.alert('Please enter correct Quantity.')</script>";
		exit();
	}

	if(isset($_SESSION['Purchase_Functions'])) 
	{
		$Index=IndexOf($ProductID,$arr['Size']);

		if($Index == -1) 
		{
			$size=count($_SESSION['Purchase_Functions']);

			$_SESSION['Purchase_Functions'][$size]['ProductID']=$ProductID;
			$_SESSION['Purchase_Functions'][$size]['ProductCategory']=$arr['Category'];
			$_SESSION['Purchase_Functions'][$size]['ProductSize']=$arr['Size'];
			$_SESSION['Purchase_Functions'][$size]['PurchasePrice']=$PurchasePrice;
			$_SESSION['Purchase_Functions'][$size]['PurchaseQuantity']=$PurchaseQuantity;

			$_SESSION['Purchase_Functions'][$size]['ProductName']=$arr['ProductName'];
			$_SESSION['Purchase_Functions'][$size]['ProductSKU']=$arr['SKU'];
			$_SESSION['Purchase_Functions'][$size]['ProductImage1']=$arr['ProductPhoto'];
		}
		else
		{
			$_SESSION['Purchase_Functions'][$Index]['PurchaseQuantity']+=$PurchaseQuantity;
		}
	}
	else
	{
		$_SESSION['Purchase_Functions']=array(); //Create Session Array

		$_SESSION['Purchase_Functions'][0]['ProductID']=$ProductID;
		$_SESSION['Purchase_Functions'][0]['ProductCategory']=$arr['Category'];
		$_SESSION['Purchase_Functions'][0]['ProductSize']=$arr['Size'];
		$_SESSION['Purchase_Functions'][0]['PurchasePrice']=$PurchasePrice;
		$_SESSION['Purchase_Functions'][0]['PurchaseQuantity']=$PurchaseQuantity;
		$_SESSION['Purchase_Functions'][0]['ProductSKU']=$arr['SKU'];
		$_SESSION['Purchase_Functions'][0]['ProductName']=$arr['ProductName'];
		$_SESSION['Purchase_Functions'][0]['ProductImage1']=$arr['ProductPhoto'];
	}
}


function IndexOf($ProductID,$prosize)
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
				if($ProductID == $_SESSION['Purchase_Functions'][$i]['ProductID'] AND $prosize == $_SESSION['Purchase_Functions'][$i]['ProductSize']) 
				{
					return $i;
				}
			}
			return -1;
		}
	}
}





 ?>