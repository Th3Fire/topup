<?php
require_once ("connect_db.php");
require_once "Payme.php";
$demo = false; // ต้องการทดสอบ demo แก้เป็น true
$domain = "fb.wuttinunt.me"; // โดเมนของคุณ
$merchantCode = "WUTTINUPME"; // MERCHANT CODE จาก Payme

$cPayme = new Payme();
$returnURL = "http://$domain/topup2/presult.php"; // URL ที่ต้องการให้ส่งค่ากลับ หลังจากส่งรหัสบัตรทรูมันนี่ไปตรวจสอบ
$cPayme->setMERCHANT($merchantCode); // ตั้งค่า MERCHANT CODE จาก Payme

$cmd = $_POST['cmd'];
$code = $_POST['paymeCode'];


$myArray = array();
//$msg = "cmd = ".$cmd;

//file_put_contents("c.txt", date("Y-m-d H:i:s") . " - $msg\n", FILE_APPEND);

if($cmd == "topup"){
  $msg = "cmd = {$_POST['cmd']} , code = {$_POST['paymeCode']} , ref1 = {$_POST['ref1']} , ref2 = {$_POST['ref2']} , ref3 = {$_POST['ref3']}";
  file_put_contents("c.txt", date("Y-m-d H:i:s") . " - $msg\n", FILE_APPEND);
// เพิ่ม Code บันทึกลงฐานข้อมูล หรือ ตรวจสอบรหัสบัตรซ้ำ
    $cPayme->log("{$_POST['cmd']} << cmd.");
    $cPayme->log("{$_POST['paymeCode']} insert.");
    $sql = "SELECT max(ID) as id FROM member";
    $sqlresult = mysqli_query($con,$sql);
    if($sqlresult->num_rows > 0){
        while ($rows = $sqlresult->fetch_array(MYSQL_BOTH)) {
            $id = $rows['id']+1;
            $msgId = "id : ".$id;
            file_put_contents("id.txt", date("Y-m-d H:i:s") . " - $msgId\n", FILE_APPEND);
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
          echo "Record Add User successfully";
          echo json_encode($myArray);
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
        return $myArray[0];
        //echo json_encode($myArray);
        //exit();
    //echo $result;
    }

}
else if($cmd == "check"){

    }






?>
