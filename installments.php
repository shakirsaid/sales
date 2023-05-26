<?php
//firstly, perform database connection

$conn=mysqli_connect('localhost','root','','mikopo');


$username="";
if(isset($_POST['username']))
{
    $username=mysqli_real_escape_string($conn,$_POST['username']);
}
//then prepare query statement

$query=$conn->prepare("select FORMAT(installed_amount, 2)as installed_amount,control_number_fk,DATE_FORMAT(date, '%M %e, %Y')as date from installment where control_number_fk='$username'");

//then execute the query

$query->execute();

//then bind the query from above

$query->bind_result($installed_amount,$control_number_fk,$date);

//after there, prepare your query results to loop within array

$contents=array();

//then, use for loop to iterate the incoming row/ assign rows to variable 'data'

while($query->fetch())
{
    $data=array();
    $data['installed_amount']=$installed_amount;
    $data['control_number_fk']=$control_number_fk;
    $data['date']=$date;


    //now push the array

    array_push($contents,$data);
}

//finally, send data as 'keys' using json object:  will be sent as string

echo json_encode($contents);

//--------------End-----you can contact me via whatsap +255675839840
?>