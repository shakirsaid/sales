<?php
//firstly, perform database connection

$conn=mysqli_connect('localhost','root','','mikopo');

$username="1";
if(isset($_POST['username']))
{
    $username=mysqli_real_escape_string($conn,$_POST['username']);
}
//then prepare query statement

$query=$conn->prepare("select fullname,resident,phone_number,FORMAT(loan_amount,2)as loan_amount,interest_percentage,direct_cost,FORMAT(taken_amount,2)as taken_amount,DATE_FORMAT(loan_date, '%M %e, %Y')as loan_date,DATE_FORMAT(limit_date, '%M %e, %Y')as limit_date,control_number,FORMAT(actual_debt,2)as actual_debt,status,FORMAT(interest_amount,2)as interest_amount,FORMAT(penalt,2)as penalt,FORMAT(actual_debt_penalt,2)as actual_debt_penalt,FORMAT(totalInstallments,2)as totalInstallments, FORMAT(remain_amount,2)as remain_amount from customers where control_number='$username'");

//then execute the query

$query->execute();

//then bind the query from above

$query->bind_result($fullname,$resident,$phone_number,$loan_amount,$interest_percentage,$direct_cost,$taken_amount,$loan_date,$limit_date,$control_number,$actual_debt,$status,$interest_amount,$penalt,$actual_debt_penalt,$totalInstallments,$remain_amount);

//after there, prepare your query results to loop within array

$contents=array();

//then, use for loop to iterate the incoming row/ assign rows to variable 'data'

while($query->fetch())
{
    $data=array();
    $data['fullname']=$fullname;
    $data['resident']=$resident;
	$data['phone_number']=$phone_number;
	$data['loan_amount']=$loan_amount;
	$data['interest_percentage']=$interest_percentage;
	$data['direct_cost']=$direct_cost;
	$data['taken_amount']=$taken_amount;
	$data['loan_date']=$loan_date;
	$data['limit_date']=$limit_date;
	$data['control_number']=$control_number;
	$data['actual_debt']=$actual_debt;
	$data['status']=$status;
	$data['interest_amount']=$interest_amount;
	$data['penalt']=$penalt;
	$data['actual_debt_penalt']=$actual_debt_penalt;
   $data['totalInstallments']=$totalInstallments;
    $data['remain_amount']=$remain_amount;



    //now push the array

    array_push($contents,$data);
}

//finally, send data as 'keys' using json object:  will be sent as string

echo json_encode($contents);

?>