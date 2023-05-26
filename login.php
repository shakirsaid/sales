<?php
$con=mysqli_connect('localhost','root','','mikopo');

//receive username and password from android
$username="";
if(isset($_POST['username']))
{
	$username=mysqli_real_escape_string($con,$_POST['username']);
}

$password="";
if(isset($_POST['password']))
{
	$password=mysqli_real_escape_string($con,MD5($_POST['password']));
}

//create query to select data from dba_close
$sql="SELECT * from customers where phone_number='$username' AND password='$password'";
//execute the query
$execute=mysqli_query($con,$sql);
//process results
if(mysqli_num_rows($execute)>0)
{
	//username and password are correct
	$captureData=mysqli_fetch_assoc($execute);
	$fullname=$captureData['fullname'];
	$phone_number=$captureData['phone_number'];
    $control_number=$captureData['control_number'];
	
	//send keys to android app
	$status="ok";
	$resultCode=1;
	echo json_encode(array('fullname'=>$fullname,'phone_number'=>$phone_number,'status'=>$status,'resultCode'=>$resultCode,'control_number'=>$control_number));

}
else
{
	//username and password are not correct
	//send keys to android app
	$status="ok";
	$resultCode=0;
	echo json_encode(array('status'=>$status,'result_code'=>$resultCode));

}



?>