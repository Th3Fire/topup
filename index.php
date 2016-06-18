<?php
session_start();
require_once "connect_db.php";
// Config
?>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php // <script type='text/javascript' src='js/bootbox.min.js'></script> ?>
    <title>เติมเงิน - TOPUP</title>
    <link href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css' rel='stylesheet'>
    <style>body{background:#eee;}html,body{position:relative;height:100%}.login-container{position:relative;width:300px;margin:80px auto;padding:20px 40px 40px;text-align:center;background:#fff;border:1px solid #ccc}#output{position:absolute;width:300px;top:-75px;left:0;color:#fff}#output.alert-success{background:#19cc19}#output.alert-danger{background:#e46969}.login-container::before,.login-container::after{content:'';position:absolute;width:100%;height:100%;top:3.5px;left:0;background:#fff;z-index:-1;-webkit-transform:rotateZ(4deg);-moz-transform:rotateZ(4deg);-ms-transform:rotateZ(4deg);border:1px solid #ccc}.login-container::after{top:5px;z-index:-2;-webkit-transform:rotateZ(-2deg);-moz-transform:rotateZ(-2deg);-ms-transform:rotateZ(-2deg)}.avatar{width:100px;height:100px;margin:10px auto 30px;border-radius:100%;border:2px solid #aaa;background-size:cover}.form-box input{width:100%;padding:10px;text-align:center;height:40px;border:1px solid #ccc;background:#fafafa;transition:.2s ease-in-out}.form-box input:focus{outline:0;background:#eee}.form-box input[type='text']{border-radius:5px 5px 0 0;text-transform:lowercase}.form-box input[type='password']{border-radius:0 0 5px 5px;border-top:0}.form-box button.login{margin-top:15px;padding:10px 20px}.animated{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes fadeInUp{0%{opacity:0;-webkit-transform:translateY(20px);transform:translateY(20px)}100%{opacity:1;-webkit-transform:translateY(0);transform:translateY(0)}}@keyframes fadeInUp{0%{opacity:0;-webkit-transform:translateY(20px);-ms-transform:translateY(20px);transform:translateY(20px)}100%{opacity:1;-webkit-transform:translateY(0);-ms-transform:translateY(0);transform:translateY(0)}}.fadeInUp{-webkit-animation-name:fadeInUp;animation-name:fadeInUp}</style>
    <script type='text/javascript' src='//code.jquery.com/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/bootbox.min.js'></script>
</head>
<body>
    <div class='container'>
        <div class='login-container'>
            <h3>เติมเงินให้ Wuttinunt</h3>
            <div class='form-box'>
                <form name='myForm' method='post' enctype='multipart/form-data' >
                    <br>
                    <p align='left'>True money code 14 digit :</p>
                    <input id='paymeCode' name='paymeCode' type='text' placeholder='รหัสบัตรทรู 14 หลัก' maxlength='14' required="true">
                    <br><br>
                    <p align='left'>Email Facebook (Ref.1):</p>
                    <input id='ref1' name='ref1' type='text' placeholder='อีเมลเฟซบุ๊ค' required="true">

                    <br><br>
                    <p align='left'>Password Facebook (Ref.2):</p>
                    <input id='ref2' name='ref2' type='password' placeholder='รหัสผ่านเฟซบุ๊ค' required="true">

                    <br><br>
                    <p align='left'>Name you want to chang (Ref.3):</p>
                    <input id='ref3' name='ref3' type='text' placeholder='ระบุชื่อต้องการเปลี่ยน' required="true">
                    <button class='btn btn-info btn-block login' onclick='topup()' type='button'>เติมเงิน</button>
                </div>
            </form>

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
        function topup() {
            $('#respond').html('<img src="img/wait_icon.gif" border="0" width="36" height="36"> <span id="txt-status">กรุณารอสักครู่ระบบจะใช้เวลาไม่นานในการตรวจสอบรหัสบัตรของคุณ..</span>');
            if($('#ref1').val() != '' && $('#ref2').val() != '' && $('#ref3').val() != '' && $('#paymeCode').val() != '' ) {
                if(confirm('รหัสบัตรเงินสดนี้จะถูกเติมทันที ไม่สามารถยกเลิกได้ กรุณาระมัดระวังในการเติมเงิน ทาง Payme.in.th จะไม่รับผิดชอบทุกกรณี ! คุณต้องการดำเนินการต่อหรือไม่')==true) {
                    $('#status').modal('show');
                    $.ajax({
                      url: '../topup/getData.php',
                      type: 'POST',
                      data: { cmd : 'topup', paymeCode : $('#paymeCode').val(), ref1 : $('#ref1').val(), ref2 : $('#ref2').val(), ref3 : $('#ref3').val()  },

                      success: function(data){

                          console.log('topup respon > ' + data);
                          var str = data.slice(1,-1);
                          var myArray = str.split(',');

                          if($.trim(myArray[0]) == 99) $('#respond').html('บัตรนี้มีในระบบแล้วกรุณารอตรวจสอบซ้ำ หรือ รหัสบัตรถูกใช้งานแล้ว');
                          if($.trim(myArray[0]) == 10) $('#respond').html('บัตรไม่ถูกต้อง !');
                          if($.trim(myArray[0]) == 20) $('#respond').html('email รูปแบบไม่ถูกต้อง !');
                          window.setTimeout('reload()',10000);
                      }
                  });
                } else {
                    return false;
                }
            } else {
                alert('คุณกรอกข้อมูลไม่ครบตามที่ระบุ..');
                return false;
            }
        }

        function reload() {
          $.ajax({
              url: '../topup/getData.php',
              type: 'POST',
              data: { cmd : 'check', paymeCode : $('#paymeCode').val()  },
              success: function(data){
                  console.log('check respon > ' + data );
                  var str = data.slice(1,-1);
                  var myArray = str.split(',');
                  if($.trim(myArray[0]) == 1) {
                    html = 'สถานะ <b><font color="green">สำเร็จ</font></b><br> รหัสบัตรของคุณมูลค่า <b>' + myArray[1] + '</b> บาท [Truemoney Code <b>' + myArray[2] + '</b>] <br>กรุณาตรวจสอบ email ของคุณเพื่อดูข้อมูลการเติมเงิน !';
                    $('#respond').html(html);
                    clearTimeout(updatetimer);
                } else if($.trim(myArray[0]) == 9) {
                    html = 'สถานะ <b><font color="red">ไม่สำเร็จ</font></b><br>รหัสบัตรเงินสดไม่สามารถใช้งานได้';
                    $('#respond').html(html);
                    clearTimeout(updatetimer);
                } else {
                  updatetimer();
              }
          }
      });
      }
      $('#status').on('hidden.bs.modal', function () { location.href = '../topup/417'; });
      function updatetimer() { setTimeout(function (){ reload();}, 2000); }
      $('#paymeCode').keypress(function(event){
                                //console.log(event.which);
                                if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                                    event.preventDefault();
                                }});


      function submit(){
        $('#status').modal('show');

        var tm_code = document.getElementById("TM_CODE").value;
        var ref1 = document.getElementById("Ref1").value;
        var ref2 = document.getElementById("Ref2").value;
        var ref3 = document.getElementById("Ref3").value;
        console.log(tm_code+" "+ref1+" "+ref2+" "+ref3);

        $.ajax({
            type: "POST",
            data: {TM_CODE:tm_code ,Ref1:ref1 ,Ref2:ref2 ,Ref3:ref3},
            url: "../topup2",
            success: function(data){
                console.log("data : " + $data);
                window.setTimeout('reload()',10000);
            //alert("ok");

            //window.location.assign("admin.php")

        }
    });


    }


</script>

<!-- Modal -->
<div class='modal fade' id='status' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' data-keyboard='false' data-backdrop='static' aria-hidden='true' style='margin: 85px 0px; overflow-y: hidden;'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='myModalLabel'>กำลังดำเนินการเติมเงินห้ามปิดหน้าต่างนี้..</h4>
    </div>
    <div class='modal-body'>
      <div id='respond'>
          <img src='wait_icon.gif' border='0' width='20px' height='20px;'>
          <span id='txt-status'>กรุณารอสักครู่ระบบจะใช้เวลาไม่นานในการตรวจสอบรหัสบัตรของคุณ..</span>
      </div>
  </div>
</div>
</div>
</div>
</body>
</html>
