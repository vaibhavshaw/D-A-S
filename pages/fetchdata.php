<?php

include "db_connect.php";

$lat=(isset($_GET['lat']))?$_GET['lat']:'';
$long=(isset($_GET['long']))?$_GET['long']:'';

//do whatever you want
function array_flatten($array) { 
  if (!is_array($array)) { 
    return false; 
  } 
  $result = array(); 
  foreach ($array as $key => $value) { 
    if (is_array($value)) { 
      $result = array_merge($result, array_flatten($value)); 
    } else { 
      $result[$key] = $value; 
    } 
  } 
  return $result; 
}

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 

$json = "https://plus.codes/api?address=".$lat.",".$long."&ekey=AIzaSyC7JK6NbNdWfyUaXa2bNyP6ci6-ExArBUA
";
$data = file_get_contents("https://plus.codes/api?address=".$lat.",".$long."&ekey=AIzaSyC7JK6NbNdWfyUaXa2bNyP6ci6-ExArBUA
", false, stream_context_create($arrContextOptions));

$someobject = json_decode($data, true);

  //var_dump(json_decode($data, true));
  $someArray = array_flatten($someobject); 
  

$alphabet = "192WER459TYUO6CXZ37M";
    $latitude = $someArray['lat'];
    $longitude = $someArray['lng'];
    $arr =  array(20.0, 1.0, 0.05, 0.0025 , 0.000125 );
    $code1= "";
    $alat= $latitude + 90;
    $alng= $longitude + 180;
    $count=0;
    while($count < 10)
    {
      $plvalue = $arr[(int)floor($count/2)];
      $dvalue = (int)floor($alat/$plvalue);
      $alat-=$plvalue*$dvalue;
      $code1=$code1.$alphabet[$dvalue];
      $count+=1;

      $dvalue = (int)floor($alng/$plvalue);
      $alng-=$plvalue*$dvalue;
      $code1=$code1.$alphabet[$dvalue];
      $count+=1;
      if($count%4==0)
      {
        $code1= $code1." ";
      }
    }
    $code = $str1." ".$code1;
    $code = str_replace('+', ' ', $code); 
    $local_code = substr($code1, 5);
    $local_code = str_replace('+', ' ', $local_code);
    $status = $someArray['status'];
$query1="SELECT * FROM `digital_addresses` WHERE `code` = '$code'";
$result1=mysqli_query($connection,$query1);
if($row=mysqli_fetch_assoc($result1))
{
  header('location: ../pages/slide/finalMain.php?msg=0');
}
else
{
$query = "INSERT INTO `digital_addresses` (`S.No`, `code`, `latitude`, `longitude`, `local_code`, `locality_place_id`, `local_address`, `best_street_address`, `status`) VALUES (NULL, '$code', '$latitude', '$longitude', '$local_code', NULL, NULL, NULL, '$status')";
  if(mysqli_query($connection, $query))
    {
      $query="SELECT * FROM `digital_addresses` WHERE `code` = '$code'";
      $result=mysqli_query($connection,$query);
      if($row=mysqli_fetch_assoc($result))
      {
        $serial = $row['S.No'];
        header('location: slide/finalMain.php?msg='.$serial);
      }
    }
  }
?>