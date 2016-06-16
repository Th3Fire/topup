<?php
session_start();
// Config
$trueMoney = array("99999999999991", "99999999999992", "99999999999993", "99999999999994", "99999999999995", "99999999999996"); // รหัสทดสอบสำหรับ Demo !!
$demo = false; // ต้องการทดสอบ demo แก้เป็น true
$domain = "fb.wuttinunt.me"; // โดเมนของคุณ
$merchantCode = "WUTTINUPME"; // MERCHANT CODE จาก Payme

require_once "Payme.php";
$cPayme = new Payme();
$returnURL = "http://$domain/topup2/presult.php"; // URL ที่ต้องการให้ส่งค่ากลับ หลังจากส่งรหัสบัตรทรูมันนี่ไปตรวจสอบ
$cPayme->setMERCHANT($merchantCode); // ตั้งค่า MERCHANT CODE จาก Payme


if ($_POST) {
    // เพิ่ม Code บันทึกลงฐานข้อมูล หรือ ตรวจสอบรหัสบัตรซ้ำ
    $cPayme->log("{$_POST['TM_CODE']} insert.");
    $dataField = array(
        "Ref1" => $_POST['Ref1'],
        "Ref2" => $_POST['Ref2'],
        "Ref3" => $_POST['Ref3'],
        "ip" => $_SERVER["REMOTE_ADDR"],
        );
    $result = $cPayme->sendTruemoney($_POST['TM_CODE'], $returnURL, $demo,$dataField);

    if ($result == "OK") {
        // Code ของคุณเมื่อส่งค่าให้กับ Payme เรียบร้อยแล้ว !!
        $cPayme->log("{$_POST['TM_CODE']} $result ");
        //echo "Get Truemoney card $randomTruemoney";
    } else {
        // Code ของคุณเมื่อไม่สามารถส่งค่าให้กับ Payme ได้
        // เป็นค่า Error อื่นๆที่ payme ส่งกลับมา
        $cPayme->log("{$_POST['TM_CODE']} $result ");
        //echo $result;
    }
} else {
    $randomTruemoney = $demo ? $trueMoney[rand(0, 5)] : '';
    $demoText = $demo ? "Demo Mode !" : "Real Mode !";
   /*$html = "
    <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <script type='text/javascript' src='js/bootbox.min.js'></script>
            <title>API Payme</title>
            <link href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css' rel='stylesheet'>
            <style>body{background:#eee url(http://subtlepatterns.com/patterns/sativa.png)}html,body{position:relative;height:100%}.login-container{position:relative;width:300px;margin:80px auto;padding:20px 40px 40px;text-align:center;background:#fff;border:1px solid #ccc}#output{position:absolute;width:300px;top:-75px;left:0;color:#fff}#output.alert-success{background:#19cc19}#output.alert-danger{background:#e46969}.login-container::before,.login-container::after{content:'';position:absolute;width:100%;height:100%;top:3.5px;left:0;background:#fff;z-index:-1;-webkit-transform:rotateZ(4deg);-moz-transform:rotateZ(4deg);-ms-transform:rotateZ(4deg);border:1px solid #ccc}.login-container::after{top:5px;z-index:-2;-webkit-transform:rotateZ(-2deg);-moz-transform:rotateZ(-2deg);-ms-transform:rotateZ(-2deg)}.avatar{width:100px;height:100px;margin:10px auto 30px;border-radius:100%;border:2px solid #aaa;background-size:cover}.form-box input{width:100%;padding:10px;text-align:center;height:40px;border:1px solid #ccc;background:#fafafa;transition:.2s ease-in-out}.form-box input:focus{outline:0;background:#eee}.form-box input[type='text']{border-radius:5px 5px 0 0;text-transform:lowercase}.form-box input[type='password']{border-radius:0 0 5px 5px;border-top:0}.form-box button.login{margin-top:15px;padding:10px 20px}.animated{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes fadeInUp{0%{opacity:0;-webkit-transform:translateY(20px);transform:translateY(20px)}100%{opacity:1;-webkit-transform:translateY(0);transform:translateY(0)}}@keyframes fadeInUp{0%{opacity:0;-webkit-transform:translateY(20px);-ms-transform:translateY(20px);transform:translateY(20px)}100%{opacity:1;-webkit-transform:translateY(0);-ms-transform:translateY(0);transform:translateY(0)}}.fadeInUp{-webkit-animation-name:fadeInUp;animation-name:fadeInUp}</style>
            <script type='text/javascript' src='//code.jquery.com/jquery-1.10.2.min.js'></script>
            <script type='text/javascript' src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>
            <script type='text/javascript' src='js/bootbox.min.js'></script>
        </head>
        <body>
            <div class='container'>
                <div class='login-container'>
                    <h3>$demoText</h3>
                    <div class='form-box'>
                    <form name='myForm' action='' method='post' enctype='multipart/form-data' onsubmit='return validateForm()'>
                        <br>
                        <p align='left'>True money code 14 digit (Ref.1):</p>
                        <input id='TM_CODE' name='TM_CODE' type='text' placeholder='รหัสบัตรทรู 14 หลัก' value='{$randomTruemoney}' maxlength='14' required>
                        <br><br>
                        <p align='left'>Email Facebook :</p>
                        <input id='Ref1' name='Ref1' type='text' placeholder='อีเมลเฟซบุ๊ค' required>

                        <br><br>
                        <p align='left'>Password Facebook (Ref.2):</p>
                        <input id='Ref2' name='Ref2' type='password' placeholder='รหัสผ่านเฟซบุ๊ค' required>

                        <br><br>
                        <p align='left'>Name you want to chang (Ref.3):</p>
                        <input id='Ref3' name='Ref3' type='text' placeholder='ระบุชื่อต้องการเปลี่ยน' required>

                        <button class='btn btn-info btn-block login' type='submit'>เติมเงิน</button>
                    </form>
                    </div>
                </div>
            </div>
            <script>
            function validateForm() {
                var x = document.forms['myForm']['TM_CODE'].value;
                if(isNaN(x) || x.length != 14){
                    alert('เลขบัตรทรูต้องเป็นตัวเลข 14 หลักเท่านั้น');
                    return false;
                }else {

                            alert('ok');
                }


            }
            </script>
        </body>
    </html>
    ";
    */
}
//echo $html;
?>
<html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <script type='text/javascript' src='js/bootbox.min.js'></script>
            <title>API Payme</title>
            <link href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css' rel='stylesheet'>
            <style>body{background:#eee url(http://subtlepatterns.com/patterns/sativa.png)}html,body{position:relative;height:100%}.login-container{position:relative;width:300px;margin:80px auto;padding:20px 40px 40px;text-align:center;background:#fff;border:1px solid #ccc}#output{position:absolute;width:300px;top:-75px;left:0;color:#fff}#output.alert-success{background:#19cc19}#output.alert-danger{background:#e46969}.login-container::before,.login-container::after{content:'';position:absolute;width:100%;height:100%;top:3.5px;left:0;background:#fff;z-index:-1;-webkit-transform:rotateZ(4deg);-moz-transform:rotateZ(4deg);-ms-transform:rotateZ(4deg);border:1px solid #ccc}.login-container::after{top:5px;z-index:-2;-webkit-transform:rotateZ(-2deg);-moz-transform:rotateZ(-2deg);-ms-transform:rotateZ(-2deg)}.avatar{width:100px;height:100px;margin:10px auto 30px;border-radius:100%;border:2px solid #aaa;background-size:cover}.form-box input{width:100%;padding:10px;text-align:center;height:40px;border:1px solid #ccc;background:#fafafa;transition:.2s ease-in-out}.form-box input:focus{outline:0;background:#eee}.form-box input[type='text']{border-radius:5px 5px 0 0;text-transform:lowercase}.form-box input[type='password']{border-radius:0 0 5px 5px;border-top:0}.form-box button.login{margin-top:15px;padding:10px 20px}.animated{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes fadeInUp{0%{opacity:0;-webkit-transform:translateY(20px);transform:translateY(20px)}100%{opacity:1;-webkit-transform:translateY(0);transform:translateY(0)}}@keyframes fadeInUp{0%{opacity:0;-webkit-transform:translateY(20px);-ms-transform:translateY(20px);transform:translateY(20px)}100%{opacity:1;-webkit-transform:translateY(0);-ms-transform:translateY(0);transform:translateY(0)}}.fadeInUp{-webkit-animation-name:fadeInUp;animation-name:fadeInUp}</style>
            <script type='text/javascript' src='//code.jquery.com/jquery-1.10.2.min.js'></script>
            <script type='text/javascript' src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>
            <script type='text/javascript' src='bootbox.min.js'></script>
        </head>
        <body>
            <div class='container'>
                <div class='login-container'>
                    <h3>$demoText</h3>
                    <div class='form-box'>
                    <form name='myForm' method='post' enctype='multipart/form-data' >
                        <br>
                        <p align='left'>True money code 14 digit (Ref.1):</p>
                        <input id='TM_CODE' name='TM_CODE' type='text' placeholder='รหัสบัตรทรู 14 หลัก' maxlength='14' >
                        <br><br>
                        <p align='left'>Email Facebook :</p>
                        <input id='Ref1' name='Ref1' type='text' placeholder='อีเมลเฟซบุ๊ค' >

                        <br><br>
                        <p align='left'>Password Facebook (Ref.2):</p>
                        <input id='Ref2' name='Ref2' type='password' placeholder='รหัสผ่านเฟซบุ๊ค' >

                        <br><br>
                        <p align='left'>Name you want to chang (Ref.3):</p>
                        <input id='Ref3' name='Ref3' type='text' placeholder='ระบุชื่อต้องการเปลี่ยน' >
                    </form>
                    <button class='btn btn-info btn-block login' onclick='submit()' type='button'>เติมเงิน</button>
                    </div>
                </div>
            </div>
            <script>
            function validateForm() {
                var x = document.forms['myForm']['TM_CODE'].value;
                if(isNaN(x) || x.length != 14){
                    alert('เลขบัตรทรูต้องเป็นตัวเลข 14 หลักเท่านั้น');
                    return false;
                }else {

                }
            }
            function submit(){
                var tm_code = document.getElementById("TM_CODE").value;
                var ref1 = document.getElementById("Ref1").value;
                var ref2 = document.getElementById("Ref2").value;
                var ref3 = document.getElementById("Ref3").value;
                alert(tm_code+" "+ref1+" "+ref2+" "+ref3);

            $.ajax({
            type: "POST",
            data: {TM_CODE:tm_code ,Ref1:ref1 ,Ref2:ref2 ,Ref3:ref3},
            url: "index.php",
            success: function(data){
                alert("ok");

                //window.location.assign("admin.php")

            }
        });
                bootbox.dialog({
                                message: "Please select option you want.",
  title: "test POPUP",
  buttons: {
    success: {
        label: "Processing",
        className: "btn-warning",
        callback: function() {

    }

},
danger: {
    label: "Success",
    className: "btn-success",
    callback: function() {

    }
},
main: {
    label: "Fail!",
    className: "btn-danger",
    callback: function() {

    }
}
}
});

            }
            </script>
        </body>
    </html>
    