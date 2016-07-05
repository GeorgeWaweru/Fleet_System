<?php
$domain=Yii::app()->params['domain'];
$user=Yii::app()->params['user'];
$password=Yii::app()->params['password'];
$database=Yii::app()->params['database'];		
$conn=mysql_connect($domain,$user,$password);
mysql_select_db($database,$conn);

$fileName="toyota.csv";
$sql="LOAD DATA LOCAL INFILE 'C:/xampp/htdocs/projects/fleet/data/csv/".$fileName."'
INTO TABLE tbl_car_details
FIELDS TERMINATED BY ','
ENCLOSED BY '\"'
LINES TERMINATED BY '\\n'
IGNORE 1 LINES
(
carYear,carMake,carModel
);";
$loadData=mysql_query($sql,$conn);	
?>

INSERT INTO tbl_car_make(title) SELECT DISTINCT  CONCAT(UPPER(LEFT(carMake,1)),LOWER(SUBSTRING(carMake,2,LENGTH(carMake)))) FROM tbl_car_details



<?php
$domain=Yii::app()->params['domain'];
$user=Yii::app()->params['user'];
$password=Yii::app()->params['password'];
$database=Yii::app()->params['database'];		
$conn=mysql_connect($domain,$user,$password);
mysql_select_db($database,$conn);

$subSystemSql="SELECT id,title FROM tbl_sub_system WHERE is_default=0";
$subSystems=mysql_query($subSystemSql,$conn);

$counter=0;
while($row = mysql_fetch_array($subSystems)){
$id=$row['id'];
$title=$row['title'];

$carPartsql="SELECT DISTINCT carPart FROM tbl_systemdetails WHERE carPartType='$title'";
$carPart=mysql_query($carPartsql,$conn);

$counter=$counter+intval(mysql_num_rows($carPart));
//echo "Rows count is ".mysql_num_rows($carPart)."<br>";
while($rows = mysql_fetch_array($carPart)){
	$carPartData=$rows['carPart'];
	$insertSql="INSERT INTO tbl_spare SET sub_system_id=$id,title='$carPartData';";
	//echo $insertSql."<br><br>";
	//$insert=mysql_query($insertSql,$conn);
}



}
echo "The counter is ".$counter;

?>