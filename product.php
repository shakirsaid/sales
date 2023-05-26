
<?php
//firstly, perform database connection

$conn=mysqli_connect('localhost','root','','barcodescanner');

$key="5";
if(isset($_POST["key"]))
{
	$key=mysqli_real_escape_string($conn,$_POST['key']);
}
//then prepare query statement

$query=$conn->prepare("select product_name,code,status,purchasing_price,selling_price,DATE_FORMAT(expire_date, '%M %e, %Y')as expire_date,expected_profit,DATE_FORMAT(date, '%M %e, %Y')as date,tax_collected from products where code='$key'");

//then execute the query

$query->execute();

//then bind the query from above

$query->bind_result($product_name,$code,$status,$purchasing_price,$selling_price,$expire_date,$expected_profit,$date,$tax_collected);

//after there, prepare your query results to loop within array

$contents=array();

//then, use for loop to iterate the incoming row/ assign rows to variable 'data'

while($query->fetch())
{
    $data=array();
    $data['product_name']=$product_name;
    $data['code']=$code;
    $data['status']=$status;
    $data['purchasing_price']=$purchasing_price;
    $data['selling_price']=$selling_price;
    $data['expire_date']=$expire_date;
    $data['expected_profit']=$expected_profit;
    $data['date']=$date;
    $data['tax_collected']=$tax_collected;
    

    //now push the array

    array_push($contents,$data);
}

//finally, send data as 'keys' using json object:  will be sent as string

echo json_encode($contents);

//--------------End-----you can contact me via whatsap +255675839840
?>
