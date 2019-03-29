<?php

//connect to the db
include "db_connect.php";

//fetch user data
$address=$_POST['user_address'];
//$pincode=$_POST['user_pincode'];
$address = str_replace(' ', '%20', $address);

//echo $address."<br>";

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

$json = 'https://plus.codes/api?address='.$address.'&language=en&key=AIzaSyC7JK6NbNdWfyUaXa2bNyP6ci6-ExArBUA';
$data = file_get_contents('https://plus.codes/api?address='.$address.'&language=en&key=AIzaSyC7JK6NbNdWfyUaXa2bNyP6ci6-ExArBUA', false, stream_context_create($arrContextOptions));

$someobject = json_decode($data, true);

  //var_dump(json_decode($data, true));
  $someArray = array_flatten($someobject); 
  
//print_r($someArray)."<br>";

   $last_six = substr($someArray['best_street_address'],-13,6);
    //echo $last_six;

    $first_two = substr($last_six,0,2);
    //echo $first_two."<br>";
      if((int)$first_two == 11)
      {
        $str1 = "DL";
      }
      else if((int)$first_two >11 and (int)$first_two<=13)
      {
        $str1 = "HR";
      }
      else if((int)$first_two >13 and (int)$first_two<=16)
      {
        $str1 = "PN";
      }
      else if((int)$first_two == 17)
      {
        $str1 = "HP";
      }
      else if((int)$first_two >17 and (int)$first_two<=19)
      {
        $str1 = "JK";
      }
      else if((int)$first_two >20 and (int)$first_two<=28)
      {
        $str1 = "UU";
      }
      else if((int)$first_two >29 and (int)$first_two<=34)
      {
        $str1 = "RJ";
      }
      else if((int)$first_two >36 and (int)$first_two<=39)
      {
        $str1 = "GJ";
      }
      else if((int)$first_two >39 and (int)$first_two<=44)
      {
        $str1 = "MH";
      }
      else if((int)$first_two >44 and (int)$first_two<=49)
      {
        $str1 = "CN";
      }
      else if((int)$first_two >49 and (int)$first_two<=53)
      {
        $str1 = "AT";
      }
      else if((int)$first_two >55 and (int)$first_two<=59)
      {
        $str1 = "HR";
      }
      else if((int)$first_two >59 and (int)$first_two<=64)
      {
        $str1 = "TN";
      }
      else if((int)$first_two >66 and (int)$first_two<=69)
      {
        $str1 = "KL";
      }
      else if((int)$first_two >69 and (int)$first_two<=74)
      {
        $str1 = "WB";
      }
      else if((int)$first_two >74 and (int)$first_two<=77)
      {
        $str1 = "OR";
      }
      else if((int)$first_two == 78)
      {
        $str1 = "AS";
      }
      else if((int)$first_two == 78)
      {
        $str1 = "NE";
      }
//echo $first_two;


    /*$str = substr($someArray['global_code'],0,4)." ".$someArray['local_code'];
    $str = str_replace('+', ' ', $str);
    $strarr = explode(" ",$str);*/
   // print_r($strarr);
    //$global_code = $pin_code." ".$str;*/
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
    $local_address = $someArray['local_address'];
    $locality_place_id = $someArray['locality_place_id'];
    $best_street_address = $someArray['best_street_address'];
    $status = $someArray['status'];
$query1="SELECT * FROM `digital_addresses` WHERE `best_street_address` = '$best_street_address' OR `code` = '$code'";
$result1=mysqli_query($connection,$query1);
if($row=mysqli_fetch_assoc($result1))
{
  header('location: slide/finalMain.php?msg=0');
}
else
{
$query = "INSERT INTO `digital_addresses` (`S.No`, `code`, `latitude`, `longitude`, `local_code`, `locality_place_id`, `local_address`, `best_street_address`, `status`) VALUES (NULL, '$code', '$latitude', '$longitude', '$local_code', '$locality_place_id', '$local_address', '$best_street_address', '$status')";
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