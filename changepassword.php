<?php
$con=mysqli_connect('localhost','root','','mikopo');

//receive username and password from android

$username="";
if(isset($_POST['username']))
{
    $username=mysqli_real_escape_string($con,$_POST['username']);
}
$newPassword="";
if(isset($_POST['newpassword']))
{
    $newPassword=mysqli_real_escape_string($con,MD5($_POST['newpassword']));
}
//create query to select data from dba_close
$sql="SELECT password from customers where password='$newPassword' AND control_number='$username'";
//execute the query
$execute=mysqli_query($con,$sql);
//process results
if(mysqli_num_rows($execute)>0)
{
    //error ! old password matches with existing one
    $status="ok";
    $resultCode=1;
    echo json_encode(array('status'=>$status,'resultCode'=>$resultCode));
}
else
{
    //change password
    $changePassword="UPDATE customers set password='$newPassword' where control_number='$username'";
    $execute_query=mysqli_query($con,$changePassword);
    if($execute_query)
    {
        $status="ok";
        $resultCode=0;
        echo json_encode(array('status'=>$status,'resultCode'=>$resultCode));

    }

}

?>