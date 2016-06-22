<?php
session_start();
require_once "connect_db.php";
// Config
?>
<html>
<head>
	<meta http-equiv='Pragma' content='no-cache'>
	<meta http-equiv="CACHE-CONTROL" content="NO-CACHE" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<META NAME="keywords" CONTENT="เติมเงิน , ตัดบัตรเงินสด ,เปลี่ยนชื่อ fcebook">
	<META NAME="description" CONTENT="ระบบตัดบัตรเงินสดทรูมันนี่">
	<META NAME="author" CONTENT="Wuttinunt">
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<?php
    $bg = array('bg_01.jpg','bg_02.jpg','bg_03.jpg','bg_04.jpg'); //
    $i = rand(0, count($bg)-1); // generate random number size of the array
    $selectedBg = "$bg[$i]";
    ?>
    <title>เติมเงิน - TOPUP</title>
    <link href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css' rel='stylesheet'>
    <style type="text/css">
    	<!--
    	body{
    		background: url(img/<?php echo $selectedBg; ?>) center,no-repeat;
    	}
    -->
</style>
<style type="text/css">
	html,body{position:relative;height:100%}.login-container{position:relative;width:350px;margin:80px auto;padding:20px 40px 40px;text-align:center;background:#fff;border:1px solid #ccc}#output{position:absolute;width:300px;top:-75px;left:0;color:#fff}#output.alert-success{background:#19cc19}#output.alert-danger{background:#e46969}.login-container::before,.login-container::after{content:'';position:absolute;width:100%;height:100%;top:3.5px;left:0;background:#fff;z-index:-1;-webkit-transform:rotateZ(4deg);-moz-transform:rotateZ(4deg);-ms-transform:rotateZ(4deg);border:1px solid #ccc}.login-container::after{top:5px;z-index:-2;-webkit-transform:rotateZ(-2deg);-moz-transform:rotateZ(-2deg);-ms-transform:rotateZ(-2deg)}.avatar{width:100px;height:100px;margin:10px auto 30px;border-radius:100%;border:2px solid #aaa;background-size:cover}.form-box input{width:100%;padding:10px;text-align:center;height:40px;border:1px solid #ccc;background:#fafafa;transition:.2s ease-in-out}.form-box input:focus{outline:0;background:#eee}.form-box input[type='text']{border-radius:5px 5px 0 0;}.form-box input[type='password']{border-radius:5px 5px 0 0;}.form-box button.login{margin-top:15px;padding:10px 20px}.animated{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes fadeInUp{0%{opacity:0;-webkit-transform:translateY(20px);transform:translateY(20px)}100%{opacity:1;-webkit-transform:translateY(0);transform:translateY(0)}}@keyframes fadeInUp{0%{opacity:0;-webkit-transform:translateY(20px);-ms-transform:translateY(20px);transform:translateY(20px)}100%{opacity:1;-webkit-transform:translateY(0);-ms-transform:translateY(0);transform:translateY(0)}}.fadeInUp{-webkit-animation-name:fadeInUp;animation-name:fadeInUp}
	.text3 {
		background: #333;
		color: #ccc;
		width: 200px;
		padding: 6px 15px 6px 35px;
		border-radius: 20px;
		box-shadow: 0 1px 0 #ccc inset;
		transition: 500ms all ease;
		outline: 0;
	}
	.text3:hover {
		width: 270px;
	}

	.inputs {
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		background-color: #EAEAEA;
		background: -moz-linear-gradient(top, #FFF, #EAEAEA);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0.0, #FFF), color-stop(1.0, #EAEAEA));
		border: 1px solid #CACACA;
		color: #444;
		font-size: 15px;
		margin: 0 0 25px;
		padding: 5px 9px;
		width: 260px;
	}

	.inputs:focus {
		background: #FFF;
		-webkit-box-shadow: 0 0 25px #CCC;
		-moz-box-shadow: 0 0 25px #ccc;
		box-shadow: 0 0 25px #CCC;
		-webkit-transform: scale(1.05);
		-moz-transform: scale(1.05);
		transform: scale(1.05);
	}

	input:required:invalid, input:focus:invalid {
		background-image: url(img/invalid.png);
		background-position: right center;
		background-repeat: no-repeat;
	}
	input:required:valid {
		background-image: url(img/valid.png);
		background-position: right center;
		background-repeat: no-repeat;
	}

	input:required:invalid, input:focus:invalid {
		background-image: url(img/invalid_1.png);
		background-position: right center;
		background-repeat: no-repeat;
	}
	input:required:valid {
		background-image: url(img/valid_1.png);
		background-position: right center;
		background-repeat: no-repeat;
	}


</style>

<script type='text/javascript' src='//code.jquery.com/jquery-1.10.2.min.js'></script>
<script type='text/javascript' src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>
<script type='text/javascript' src='js/bootbox.min.js'></script>

</head>
<body>
	<?php
	$sqlShow = "SELECT * FROM banip WHERE ip = ".$_SERVER["REMOTE_ADDR"];
	$res = mysqli_query($con,$sqlShow);
	if($res->num_rows > 0){
		while($rows = $res->fetch_array(MYSQL_BOTH)){
			if($rows['count'] == 3){
				if(strpos($_SERVER['REMOTE_ADDR'],$rows['ip'])){
					die();
				}
			}
		}
	}
	?>
	<div class='container'>
		<div class='login-container'>
			<div class='avatar'><img src='img/logo.png' border='0' width='100' height='100' ></div>
			<h3>เติมเงินให้ Wuttinunt</h3>
			<div class='form-box'>
				<form name='myForm' method='post' enctype='multipart/form-data' >
					<br>
					<p align='left'>True money code 14 digit :</p>

					<input class="inputs" id='paymeCode' name='paymeCode' type='text' placeholder='รหัสบัตรทรู 14 หลัก' maxlength='14' required  pattern="[0-9]{14}">
					<br>
					<p align='left'>Email Facebook (Ref.1):</p>
					<input class="inputs" id='ref1' name='ref1' type='text' placeholder='อีเมลเฟซบุ๊ค' required pattern='^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$'>

					<br>
					<p align='left'>Password Facebook (Ref.2):</p>
					<input class="inputs" id='ref2' name='ref2' type='password' placeholder='รหัสผ่านเฟซบุ๊ค' required>

					<br>
					<p align='left'>Name you want to chang (Ref.3):</p>
					<input class="inputs" id='ref3' name='ref3' type='text' placeholder='ระบุชื่อต้องการเปลี่ยน' required pattern='[^0-9!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]*$'>
					<button class='btn btn-primary btn-block login' onclick='confirmAlert()' type='button' id="submit_data">เติมเงิน</button>
				</form>
					<button class="btn btn-success btn-block login" onclick="home()"  >หน้าหลัก</button>

			</div>
		</div>
	</div>
	<FOOTER><?php include 'footer.php'; ?></FOOTER>


	<script>
    var attempt = 3; //

    function validateForm() {
    	var x = document.forms['myForm']['TM_CODE'].value;
    	if(isNaN(x) || x.length != 14){
    		alert('เลขบัตรทรูต้องเป็นตัวเลข 14 หลักเท่านั้น');
    		return false;
    	}else {

    	}
    }
    function topup() {

    		//if($('#ref1').val() != '' && $('#ref2').val() != '' && $('#ref3').val() != '' && $('#paymeCode').val() != '' ) {
    			//if(confirm('รหัสบัตรเงินสดนี้จะถูกเติมทันที ไม่สามารถยกเลิกได้ กรุณาระมัดระวังในการเติมเงิน ทางเราจะไม่รับผิดชอบทุกกรณี! หากมีความผิดพลาดเกิดขึ้น คุณต้องการดำเนินการต่อหรือไม่')==true) {
    			
    				$('#status').modal('show');
    				$('#respondH').html('<span id="txt-header"><b>กำลังดำเนินการเติมเงินห้ามปิดหน้าต่างนี้...</b></span>');
    				$('#respond').html('<div style="text-align: center"><img src="img/loading9.gif"><br> <span id="txt-status"><font size="4">กรุณารอสักครู่ระบบจะใช้เวลาไม่นานในการตรวจสอบรหัสบัตรของคุณ...</font></span></div>');
    				$.ajax({
    					url: '../topup/getData.php',
    					type: 'POST',
    					data: { cmd : 'topup', paymeCode : $('#paymeCode').val(), ref1 : $('#ref1').val(), ref2 : $('#ref2').val(), ref3 : $('#ref3').val()  },

    					success: function(data){

    						console.log('topup respon > ' + data);
    						var str = data.slice(1,-1);
    						var myArray = str.split(',');

    						if($.trim(myArray[0]) == 88) {
    							$('#respond').html('<div style="text-align: center"><font size="4">บัตรนี้มีในระบบแล้วกรุณารอตรวจสอบซ้ำ</font></div>'); $('#respondH').html('<span id="txt-header"><b>แจ้งเตือน !!!</b></span>');
    						}
    						//if($.trim(myArray[0]) == 10) $('#respond').html('<div style="text-align: center"><font size="4">เลขบัตรไม่ถูกต้อง !</font></div>');  $('#respondH').html('<span id="txt-header"><b>แจ้งเตือน !!!</b></span>');
    						//if($.trim(myArray[0]) == 20) $('#respond').html('<div style="text-align: center"><font size="4">รูปแบบ Email ไม่ถูกต้อง !</font></div>') ; $('#respondH').html('<span id="txt-header"><b>แจ้งเตือน !!!</b></span>');
    						if($.trim(myArray[0]) == 99) {
    							$('#respond').html('<div style="text-align: center"><font size="4">บัตรนี้มีในระบบแล้ว และสถานะการเติมเงินของบัตรนี้ <b><font color="red">ไม่สำเร็จ! </font></b></font></div>'); $('#respondH').html('<span id="txt-header"><b>แจ้งเตือน !!!</b></span>');}
    							if($.trim(myArray[0]) == 28) {
    								$('#respond').html('<div style="text-align: center"><font size="4">บัตรนี้มีในระบบแล้ว และสถานะการเติมเงินของบัตรนี้ <b><font color="green">สำเร็จ! </font></b></font></div>');$('#respondH').html('<span id="txt-header"><b>แจ้งเตือน !!!</b></span>');}
    								if($.trim(myArray[0]) == 44) {
    									$('#respondH').html('<span id="txt-header"><b>กำลังดำเนินการเติมเงินห้ามปิดหน้าต่างนี้...</b></span>'); window.setTimeout('reload()',10000);}


    								}
    							});

    			//} else {
    			//	return false;
    			//}
    		//} else {

    		//	alert('คุณกรอกข้อมูลไม่ครบตามที่ระบุ..');
    		//	return false;
    		//}

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
    				if($.trim(myArray[0]) == 1 ) {
    					$('#respondH').html('<span id="txt-header">ดำเนินการเติมเงินเสร็จสิ้น...</span>');
    					html = '<div style="text-align: center"><img src="img/success_icon.png" width="50px" height="50px"><br><font size="4">สถานะรายการ  </font><b><font color="green" size="4">[สำเร็จ]</font></b><br><font size="4"> รหัสบัตรของคุณมูลค่า <b><font color="blue">' + myArray[1] + '</font></b> บาท [Truemoney Code <b>' + myArray[2] + '</b>] <br>กรุณาตรวจสอบ email ของคุณเพื่อดูข้อมูลการเติมเงิน ! <br>Redirecting Home page in <span id="countdown"><b>5</b></span>. or click <a href="http://fb.wuttinunt.me">here</a></font></div>';
    					redirect();
    					$('#respond').html(html);
    					clearTimeout(updatetimer);

    				} else if($.trim(myArray[0]) == 9) {
    					attempt--;

            			console.log("attempt : "+attempt);
            //console.log("ip : "+ $('#ip').val());
			            $('#respondH').html('<span id="txt-header"><b>ดำเนินการเติมเงินล้มเหลว...</b></span>');

			            html = '<div style="text-align: center"><img src="img/fail_icon.png" width="50px" height="50px"><br><font size="4">สถานะรายการ  </font><b><font color="red" size="4">[ไม่สำเร็จ]</font></b><br><font size="3">รหัสบัตรเงินสดไม่สามารถใช้งานได้ <b>ตรวจเช็ครหัสบัตรอีกครั้งหรือลองบัตรอื่น</b></font></div>';

                        /*
    					$.ajax({
    						url: '../topup/getData.php',
    						type: 'POST',
    						data: {cmd : 'banip', ip: $('#ip').val(),count : 1},
                            success: function(data){
                                console.log("added "+$('#ip'));
                            }
    					});
    					*/

    					$('#respond').html(html);
    					clearTimeout(updatetimer);

    				} else {
    					updatetimer();
    				}
    			}
    		});
    	}
    	$('#status').on('hidden.bs.modal', function () { location.href = '../topup'; });
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
    				<h4 class='modal-title' id='myModalLabel'><div id='respondH'><span id='txt-header'>กำลังดำเนินการเติมเงินห้ามปิดหน้าต่างนี้...</span></div></h4>
    			</div>
    			<div class='modal-body'>
    				<div id='respond'>
    					<img src='img/loading9.gif'>
    					<span id='txt-status'>กรุณารอสักครู่ระบบจะใช้เวลาไม่นานในการตรวจสอบรหัสบัตรของคุณ...</span>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <div class='modal fade' id='alert' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' data-keyboard='false' data-backdrop='static' aria-hidden='true' style='margin: 85px 0px; overflow-y: hidden;'>
    	<div class='modal-dialog'>
    		<div class='modal-content'>
    			<div class='modal-header'>
    				<!--<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>-->
    				<h4 class='modal-title' id='myModalLabel'>ข้อควรทราบเกี่ยวกับ การเติมเงินเพื่อเปลี่ยนชื่อ Facebook !!!</h4>
    			</div>
    			<div class='modal-body' style='text-align: center'>
    				<h4>เงื่อนไขข้อตกลงในการเปลี่ยนชื่อ Facebook</h4>
    				ผู้ใช้บริการยอมรับที่จะเปิดเผยรหัสส่วนตัวให้กับเรา เพื่อดำเนินการเปลี่ยนชื่อ Facebook <br>กรณีการเปลี่ยนชื่อ Facebook ครบกำหนดซึ่งทำให้ไม่สามารถเปลี่ยนได้ <br>ทางเราขอสงวนสิทธิ์ในการคืนเงิน<b> กรุณาตรวจสอบและเติมเงินด้วยความระมัดระวัง</b> <br><h5 style='color: red;'><b>หากเกิดข้อผิดพลาดทางเราจะไม่รับผิดชอบทุกกรณี !!!</b></h5>
    				<br>
    				<button class='btn btn-danger btn-block login' type='button' onclick='javascript:accept();'>ฉันเข้าใจและยอมรับ</button>
    			</div>
    		</div>
    	</div>
    </div>


    <div class='modal fade' id='confirm' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' data-keyboard='false' data-backdrop='static' aria-hidden='true' style='margin: 85px 0px; overflow-y: hidden;'>
    	<div class='modal-dialog'>
    		<div class='modal-content'>
    			<div class='modal-header'>
    				<!--<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>-->
    				<h4 class='modal-title' id='myModalLabel'><b>แจ้งเตือน ยืนยันการทำรายการ !!!</b></h4>
    			</div>
    			<div class='modal-body' style='text-align: center'>
    				<h4><b><font color="red">รหัสบัตรเงินสดนี้จะถูกเติมทันที ไม่สามารถยกเลิกได้</b></font></h4>
    				<h4><b>คุณแน่ใจหรือไม่ที่จะเติมเงิน?</b></h4>
    				<br>
    				<button class='btn btn-primary' type='button' onclick='javascript:confirm();'>ยืนยันการทำรายการ</button>
					<button class='btn btn-danger' type='button' data-dismiss="modal">ยกเลิก</button>
    			</div>
    		</div>
    	</div>
    </div>




    <script>
    	$('#alert').modal('show');
    	function home(){
    		window.location.assign("http://fb.wuttinunt.me");
    	};

    	function accept(){ $('#alert').modal('hide'); };

    	function redirect(){
    		var timeLeft = 5,
    		cinterval;

    		var timeDec = function (){
    			timeLeft--;
    			document.getElementById('countdown').innerHTML = timeLeft;
    			if(timeLeft === 0){
    				window.location="http://fb.wuttinunt.me";
    				clearInterval(cinterval);
    			}
    		}
    		cinterval = setInterval(timeDec, 1000);
    	};


    	function confirmAlert(){

    		if($('#paymeCode').val() == '' ){
    			document.getElementById("paymeCode").focus();
    		}else if($('#paymeCode').val().length != 14){
    			alert("รหัสบัตรไม่ถูกต้อง !!!");
    			document.getElementById("paymeCode").focus();
    		}else if($('#ref1').val() == ''){
    			document.getElementById("ref1").focus();
    		}else if(!(validateEmail($('#ref1').val())) ){
    			alert("รูปแบบ อีเมล ไม่ถูกต้อง");
    			document.getElementById("ref1").focus();
    		}else if($('#ref2').val() == ''){
    			document.getElementById("ref2").focus();
    		}else if($('#ref3').val() == ''){
    			document.getElementById("ref3").focus();
    		}else if(!(validateName($('#ref3').val())) ){
    			alert("รูปแบบชื่อไม่ถูกต้อง (ต้องไม่มีตัวเลขและตัวอักขระพิเศษผสมอยู่)");
    			document.getElementById("ref3").focus();
    		}

    		else {
    			$('#confirm').modal('show');
    		}


/*

        if($('#ref1').val() != '' && $('#ref2').val() != '' && $('#ref3').val() != '' && $('#paymeCode').val() != '' ) {
            if($('#paymeCode').val().length != 14)
                {alert("รหัสบัตรไม่ถูกต้อง !!!");}
            else if(!(validateEmail($('#ref1').val())))
                {alert("รูปแบบ อีเมล ไม่ถูกต้อง");}
            else{$('#confirm').modal('show');}
        }else alert("คุณกรอกข้อมูลไม่ครบตามที่ระบุ..."); return false; */
    };

    function confirm(){
    	$('#confirm').modal('hide');
    	topup();

    };
    function validateEmail(email) {
    	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(email);
    };
    function validateName(name) {
    	var pattern = new RegExp(/[0-9~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/);
    	if (pattern.test(name)) {
        //alert("Please only use standard alphanumerics");
        return false;
    	}
    	return true;

    };

    function supports_input_placeholder()
    {
    	var i = document.createElement('input');
    	return 'placeholder' in i;
    }

    if(!supports_input_placeholder()) {
    	var fields = document.getElementsByTagName('INPUT');
    	for(var i=0; i < fields.length; i++) {
    		if(fields[i].hasAttribute('placeholder')) {
    			fields[i].defaultValue = fields[i].getAttribute('placeholder');
    			fields[i].onfocus = function() { if(this.value == this.defaultValue) this.value = ''; }
    			fields[i].onblur = function() { if(this.value == '') this.value = this.defaultValue; }
    		}
    	}
    }



</script>

</body>
</html>
