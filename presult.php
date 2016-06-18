<?php
/**
 * ไฟล์ที่ใช้รับค่าจาก Payme.in.th เท่านั้น !!
 * */
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
     *
     * */
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
    // 
    $sqlPro ="UPDATE member set tmStatus = 0 WHERE ID = " . $result['id'];
    if (mysqli_query($con, $sqlPro)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }


    $cPayme->log("id: {$result['id']} ,ip: {$result['ip']} , status: {$result['tmStatus']}, code: {$result['tmCode']}, amount: {$result['tmAmount']}, money: {$result['tmRealAmount']}, msg: {$result['tmMsg']} ,Ref.1: {$result['tmRef1']} ,Ref.2: {$result['tmRef2']} ,Ref.3: {$result['tmRef3']} ");
    echo "SUCCEED|{$result['tmStatus']}"; // ค่าตอบกลับให้กับ Payme เมื่อได้รับค่าจาก Payme เรียบร้อย !! หากต้องการใส่ข้อความกำกับสำหรับบริการต่างๆ สามารถใส่ | หลังค่า SUCCEED
}