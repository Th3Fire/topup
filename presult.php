<?php
/**
 * ไฟล์ที่ใช้รับค่าจาก Payme.in.th เท่านั้น !!
 * */
ini_set('date.timezone', 'Asia/Bangkok');
ini_set("display_errors", 1);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
session_start();
require_once "Payme.php";
require_once("connect_db.php");

$log = true;

$cPayme = new Payme();
$cPayme->addAllowIP("27.254.144.22"); // เพิ่ม IP ที่อนุญาติให้ผ่าน
$result = $cPayme->statusTruemoney($log);

if ($result['tmStatus'] == 1) {
    /*
     * ค่าที่ได้จาก Payme จะอยู่ในรูปแบบ Array
     * ['tmCode'] = รหัสบัตรเงินสด 14 หลัก
     * ['tmMsg'] = ข้อความจาก payme
     * ['tmAmount'] = code รหัสบัตรเงินสด 1-6 เรียงตามลำดับมูลค่าบัตรที่ขาย (50,90,150,300,500,1000)
     * ['tmRealAmount'] = มูลค่าตามหน้าบัตร
     * ['tmStatus'] = สถานะบัตร 0 ไม่ผ่าน, 1 ผ่าน
     * ,tmRealAmount = ".$result['tmRealAmount']." ,tmMsg = ".$result['tmMsg']."
     * */
     $sql = "UPDATE `member` SET `tmStatus` = '".$result['tmStatus']."', `tmMsg` = '".$result['tmMsg']."', `tmRealAmount` = '".$result['tmRealAmount']."' WHERE `member`.`tmCode` = '".$result['tmCode']."'";
     if (mysqli_query($con, $sql)) {
         echo "Record updated successfully";
         console.log("Record updated successfully");
     } else {
         echo "Error updating record: " . mysqli_error($con);
         console.log("Error updating record: " . mysqli_error($con));
     }
    // Code ที่คุณต้องการ หากบัตรที่ต้องการตรวจสอบมียอดเงิน
    $cPayme->log("status: {$result['tmStatus']}, code: {$result['tmCode']}, amount: {$result['tmAmount']}, money: {$result['tmRealAmount']}, msg: {$result['tmMsg']} ");
    echo "SUCCEED"; // ค่าตอบกลับให้กับ Payme เมื่อได้รับค่าจาก Payme เรียบร้อย !! หากต้องการใส่ข้อความกำกับสำหรับบริการต่างๆ สามารถใส่ | หลังค่า SUCCEED
} else {
    /*
     * ตัวอย่างค่าตอบกลับ
     *
     * SUCCEED|<username>|<ค่าที่ได้>|<ค่าอื่นๆ>
     * */
    // Code ที่คุณต้องการ หากบัตรที่ต้องการตรวจสอบไม่มียอดเงิน
    // ,tmRealAmount = ".$result['tmRealAmount']." ,tmMsg = ".$result['tmMsg']."

    $sql = "UPDATE `member` SET `tmStatus` = '".$result['tmStatus']."', `tmMsg` = '".$result['tmMsg']."', `tmRealAmount` = '".$result['tmRealAmount']."' WHERE `member`.`tmCode` = '".$result['tmCode']."'";


    //$sqlPro ="UPDATE member set tmStatus = 1 , tmRealAmount =".$result['tmRealAmount'].",tmMsg = ".$result['tmMsg']."  WHERE tmCode = " . $result['tmCode'];
    if (mysqli_query($con, $sql)) {
        echo "Record updated successfully";
        console.log("Record updated successfully");
    } else {
        echo "Error updating record: " . mysqli_error($con);
        console.log("Error updating record: " . mysqli_error($con));
    }


    $cPayme->log("id: {$result['id']} ,ip: {$result['ip']} , status: {$result['tmStatus']}, code: {$result['tmCode']}, amount: {$result['tmAmount']}, money: {$result['tmRealAmount']}, msg: {$result['tmMsg']} ,Ref.1: {$result['tmRef1']} ,Ref.2: {$result['tmRef2']} ,Ref.3: {$result['tmRef3']} ");
    echo "SUCCEED|{$result['tmStatus']}"; // ค่าตอบกลับให้กับ Payme เมื่อได้รับค่าจาก Payme เรียบร้อย !! หากต้องการใส่ข้อความกำกับสำหรับบริการต่างๆ สามารถใส่ | หลังค่า SUCCEED
}
