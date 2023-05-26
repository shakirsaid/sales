<?php
$con=mysqli_connect('localhost','root','','barcodescanner');

//receive username and password from android

$code="";
if(isset($_POST['code']))
{
    $code=mysqli_real_escape_string($con,$_POST['code']);
}

$product_name="";
if(isset($_POST['product_name']))
{
    $product_name=mysqli_real_escape_string($con,$_POST['product_name']);
}
$purchasing_price="";
if(isset($_POST['purchasing_price']))
{
    $purchasing_price=mysqli_real_escape_string($con,$_POST['purchasing_price']);
}
$selling_price="";
if(isset($_POST['selling_price']))
{
    $selling_price=mysqli_real_escape_string($con,$_POST['selling_price']);
}
$expire_date="";
if(isset($_POST['expire_date']))
{
    $expire_date=mysqli_real_escape_string($con,$_POST['expire_date']);
}

//create query to select data from db
$sql="SELECT * from products where code='$code'";
//execute the query
$execute=mysqli_query($con,$sql);
//process results
if(mysqli_num_rows($execute)>0)
{
    //then send key to android app
    $status="ok";
    $resultCode=0;
    echo json_encode(array('status'=>$status,'resultCode'=>$resultCode));

}
else
{
    //if no duplicate heading then add message
    $insertMessage="INSERT INTO products (product_name,code,purchasing_price,selling_price,	expire_date) VALUES ('$product_name', '$code', '$purchasing_price', '$selling_price','$expire_date')";
    $execute_query=mysqli_query($con,$insertMessage);
    if($execute_query)
    {
        //then send key to android app
    $status="ok";
    $resultCode=1;
    echo json_encode(array('status'=>$status,'resultCode'=>$resultCode));

    }

}
?>



