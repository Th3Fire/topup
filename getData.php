<?php
require_once ("connect_db.php");
require_once "Payme.php";
$demo = false; // ต้องการทดสอบ demo แก้เป็น true
$domain = "fb.wuttinunt.me"; // โดเมนของคุณ
$merchantCode = "WUTTINUPME"; // MERCHANT CODE จาก Payme

$cPayme = new Payme();
$returnURL = "http://$domain/topup/presult.php"; // URL ที่ต้องการให้ส่งค่ากลับ หลังจากส่งรหัสบัตรทรูมันนี่ไปตรวจสอบ
$cPayme->setMERCHANT($merchantCode); // ตั้งค่า MERCHANT CODE จาก Payme

$cmd = $_POST['cmd'];
$code = $_POST['paymeCode'];


$myArray = array();
//$msg = "cmd = ".$cmd;

//file_put_contents("c.txt", date("Y-m-d H:i:s") . " - $msg\n", FILE_APPEND);


if($cmd == "topup"){

// เพิ่ม Code บันทึกลงฐานข้อมูล หรือ ตรวจสอบรหัสบัตรซ้ำ
  $cPayme->log("{$_POST['cmd']} << cmd.");
  $cPayme->log("ip: {$_SERVER["REMOTE_ADDR"]}, {$_POST['paymeCode']} insert.");

  if(strlen($_POST['paymeCode']) != 14){
    $myArray[0] = 10;
  }
        // check if e-mail address is well-formed
  else if (!filter_var($_POST['ref1'], FILTER_VALIDATE_EMAIL)) {
          //$emailErr = "Invalid email format";
    $myArray[0] = 20;
  }else {

    $sqlCode = "SELECT * From member WHERE tmCode =".$_POST['paymeCode'];
    $coderesult = mysqli_query($con,$sqlCode);
    if($coderesult->num_rows > 0){
     while ($rows = $coderesult->fetch_array(MYSQL_BOTH)) {
      if($rows['tmStatus'] == 0){
        $myArray[0] = 99;
      }else if($rows['tmStatus'] == 7){
        $myArray[0] = 88;
      }else if($rows['tmStatus'] == 1){
        $myArray[0] = 28;
      }
    }

  }else {


    $msg = "cmd = {$_POST['cmd']} , code = {$_POST['paymeCode']} , ref1 = {$_POST['ref1']} , ref2 = {$_POST['ref2']} , ref3 = {$_POST['ref3']}";
    //file_put_contents("c.txt", date("Y-m-d H:i:s") . " - $msg\n", FILE_APPEND);

    $sql = "SELECT max(ID) as id FROM member";
    $sqlresult = mysqli_query($con,$sql);
    if($sqlresult->num_rows > 0){
      while ($rows = $sqlresult->fetch_array(MYSQL_BOTH)) {
        $id = $rows['id']+1;
        $msgId = "id : ".$id;
            //file_put_contents("id.txt", date("Y-m-d H:i:s") . " - $msgId\n", FILE_APPEND);
      }
    }

    $dataField = array(
      "Ref1" => $_POST['ref1'],
      "Ref2" => $_POST['ref2'],
      "Ref3" => $_POST['ref3'],
      "ip" => $_SERVER["REMOTE_ADDR"],
      "id" => $id,
      );

    $result = $cPayme->sendTruemoney($_POST['paymeCode'], $returnURL, $demo,$dataField);

    if ($result == "OK") {

    // Code ของคุณเมื่อส่งค่าให้กับ Payme เรียบร้อยแล้ว !!
      $cPayme->log("{$_POST['paymeCode']} $result ");
      $mysql = "INSERT INTO member (tmCode,Name,Email,tmStatus,Status,Detail,Password) VALUES('".$_POST['paymeCode']."','".$dataField['Ref3']."','".$dataField['Ref1']."',7,'NULL','','".$dataField['Ref2']."')";
      if (mysqli_query($con, $mysql)) {
        $myArray[0] = 44;
        echo json_encode($myArray);
        exit();

        echo "Record Add User successfully";


        exit();
      } else {
        echo "Error Adding user record: " . mysqli_error($con);

      }
      
    //echo "Get Truemoney card $randomTruemoney";
    } else {
    // Code ของคุณเมื่อไม่สามารถส่งค่าให้กับ Payme ได้
    // เป็นค่า Error อื่นๆที่ payme ส่งกลับมา

      $cPayme->log("{$_POST['paymeCode']} $result ");
      $myArray[0] = 99;


        //$msg = "array = ";
        //file_put_contents("id.txt", date("Y-m-d H:i:s") . " - $msg\n", FILE_APPEND);


    //echo $result;
    }

  }
}
}
else if($cmd == "check"){

  $sql = "SELECT tmStatus,tmRealAmount,tmCode FROM member WHERE tmCode=".$_POST['paymeCode'];
  $sqlresult = mysqli_query($con,$sql);
  if($sqlresult->num_rows > 0){
    while ($rows = $sqlresult->fetch_array(MYSQL_BOTH)) {
      if($rows['tmStatus'] == 1){
        $myArray[0] = 1;
        $myArray[1] = $rows['tmRealAmount'];
        $myArray[2] = $rows['tmCode'];
      }else if($rows['tmStatus'] == 0){
        $myArray[0] = 9;
      }else if($rows['tmStatus'] == 7){
        $myArray[0] = 5;
      }
    }
  }

}
/*
if($cmd == "banip"){
  echo "add ip for ban";
  $_date = date("Y-m-d h:i:s");


  $sqlIP = "SELECT * From banip WHERE ip =".$_POST['ip'];
  $ipresult = mysqli_query($con,$sqlIP);
  if($ipresult->num_rows > 0){
   while ($rows = $ipresult->fetch_array(MYSQL_BOTH)) {
      $count = $rows['count'];
      updateCountIP($_POST['ip'],$_date,$count);
   }
 }else {
  
  $addIPsql = "INSERT INTO banip (ip,date,count) VALUES('".$_POST['ip']."','".$_date."',1)";
  if (mysqli_query($con, $addIPsql)) {
        $myArray[0] = 31;
        echo json_encode($myArray);
        exit();
        echo "Record Add User successfully";
      } else {
        $myArray[0] = 35;
        echo json_encode($myArray);
        exit();
        echo "Error Adding user record: " . mysqli_error($con);

      }
    }


}

public static function updateCountIP($ip,$date,$count){
  $countT = $count++;
  $sqlUpdate = "UPDATE banip set count = '".$countT."' WHERE ip = '".$ip."'";
  if (mysqli_query($con, $addIPsql)) {
    $myArray[0] = 41;
        echo json_encode($myArray);
        exit();
        echo "Record Add User successfully";
      } else {
        $myArray[0] = 45;
        echo json_encode($myArray);
        exit();
        echo "Error Adding user record: " . mysqli_error($con);

      }
    return 0;

}
*/

echo json_encode($myArray);
exit();

?>
