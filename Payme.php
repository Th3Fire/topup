<?php
ini_set('date.timezone', 'Asia/Bangkok');
ini_set("display_errors", 1);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

/**
 * API Payme.in.th Version 1.2
 * @code : Witawat Piyarattanavong
 * @contact : witawat57@gmail.com
 */
class Payme
{
    private static $_PAYME = "https://www.payme.in.th/tmapi.php?";
    private static $_MERCHANT = "";
    private static $_ALLOWIP = array("27.254.144.22"); // หากมี IP อื่นๆสามารถเพิ่มได้


    private static function getMERCHANT()
    {
        return self::$_MERCHANT;
    }

    public static function setMERCHANT($MERCHANT)
    {
        self::$_MERCHANT = $MERCHANT;
    }

    public static function addAllowIP($ip)
    {
        array_push(self::$_ALLOWIP, $ip);
    }

    public static function sendTruemoney($tmCode, $returnURL, $demo = false, $data='')
    {
        if (self::getMERCHANT() == '') return "Error merchant is null or empty !!";
        if (empty($tmCode)) return "Error truemoney code is null or empty !!";
        if (empty($returnURL)) return "Error return url is null or empty !!";

        if (!self::validate_custom("/^[0-9]{14}+$/", $tmCode)) return "Error is not truemoney code !!";
        if (!self::validate_custom("/^[0-9A-Z]+$/", self::getMERCHANT())) return "Error is not merchant code !!";

        if(is_array($data)) {
            foreach ($data as $key => $item) {
                $dataVal[] = "$key=$item";
            }
            $send = "&".implode("&",$dataVal);

        }
        $test = $demo == true ? "&mode=TEST" : "";
        $sendURL = self::$_PAYME . "merchant=" . self::getMERCHANT() . "&password=$tmCode&resp_url={$returnURL}$test$send";

        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_URL, $sendURL);
        @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        @curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds
        $curl_content = @curl_exec($ch);
        @curl_close($ch);
        if (@curl_errno() == 28 || !$curl_content) return "Error can't connect to payme server !!";
        return strpos($curl_content, 'SUCCEED') !== FALSE ? "OK" : "$curl_content";
    }

    public static function statusTruemoney($log = true)
    {
        $_tmAmount = array(
            "1" => "50",
            "2" => "90",
            "3" => "150",
            "4" => "300",
            "5" => "500",
            "6" => "1000",
        );
        foreach ($_GET as $key => $item) {
            if ($key != "password" && $key != "msg" && $key != "amount" && $key != "status") {
                $status[$key] = $item;
                //$msg2 = $status['Ref1']." ".$status['Ref2'];
                //file_put_contents("mylog.txt", date("Y-m-d H:i:s") . " - $msg2\n", FILE_APPEND);
            }
        }

        if (in_array($_SERVER['REMOTE_ADDR'], self::$_ALLOWIP)) {
            if ($log) file_put_contents("payme-log.txt", date("Y-m-d H:i:s") . " - [ $_SERVER[REMOTE_ADDR] ] staus : {$_GET['status']}, tmCode : {$_GET['password']}, amountCode : {$_GET['amount']}, amountReal : {$_tmAmount[$_GET['amount']]}, msg : " . urldecode($_GET['msg']) . " access..\n", FILE_APPEND);
            $status = array(
                "tmCode" => $_GET['password'],
                "tmMsg" => urldecode($_GET['msg']),
                "tmAmount" => $_GET['amount'],
                "tmRealAmount" => $_tmAmount[$_GET['amount']],
                "tmStatus" => $_GET['status'],
                "tmRef1" => $_GET['Ref1'],
                "tmRef2" => $_GET['Ref2'],
                "tmRef3" => $_GET['Ref3'],
                "ip" => $_GET['ip'],
                "id" => $_GET['id'],
            );
        } else {
            if ($log) file_put_contents("payme-log.txt", date("Y-m-d H:i:s") . " - [ $_SERVER[REMOTE_ADDR] ] not allow ipaddress error access..\n", FILE_APPEND);
            $status['tmStatus'] = "Error ip is not payme server !";
        }
        $msg2 = $status['tmRef1']." ".$status['tmRef2']." ".$status['tmRef3'];
        //file_put_contents("mylog.txt", date("Y-m-d H:i:s") . " - $msg2\n", FILE_APPEND);
        return $status;
    }

    public static function log($msg)
    {
        file_put_contents("logsTU/log-topup-pm.txt", date("Y-m-d H:i:s") . " - $msg\n", FILE_APPEND);
    }

    private static function validate_custom($pattern, $string)
    {
        return !preg_match($pattern, $string) ? false : true;
    }

}
