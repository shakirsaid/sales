<?php
$con=mysqli_connect('localhost','root','','mikopo');

//receive username and password from android

$username="";
if(isset($_POST['username']))
{
    $username=mysqli_real_escape_string($con,$_POST['username']);
}

$heading="";
if(isset($_POST['heading']))
{
    $heading=mysqli_real_escape_string($con,$_POST['heading']);
}
$message="";
if(isset($_POST['message']))
{
    $message=mysqli_real_escape_string($con,$_POST['message']);
}
$opinion="";
if(isset($_POST['opinion']))
{
    $opinion=mysqli_real_escape_string($con,$_POST['opinion']);
}
//create query to select data from db
$sql="SELECT heading,message,status,DATE_FORMAT(date, '%M %e, %Y')as date from messages where heading='$heading' AND control_number_fk_customer='$username'";
//execute the query
$execute=mysqli_query($con,$sql);
//process results
if(mysqli_num_rows($execute)>0)
{
    //send data to show this message heading already exist
    $row=mysqli_fetch_assoc($execute);
    $heading=$row['heading'];
    $date=$row['date'];
    $message_status=$row['status'];

    //then send key to android app
    $status="ok";
    $resultCode=1;
    echo json_encode(array('status'=>$status,'resultCode'=>$resultCode,'heading'=>$heading,'date'=>$date,'message_status'=>$message_status));

}
else
{
    //if no duplicate heading then add message
    $insertMessage="INSERT INTO messages (heading, message, opinion, control_number_fk_customer) VALUES ('$heading', '$message', '$opinion', '$username')";
    $execute_query=mysqli_query($con,$insertMessage);
    if($execute_query)
    {
        $status="ok";
        $resultCode=0;
        echo json_encode(array('status'=>$status,'resultCode'=>$resultCode));

    }

}
?>




