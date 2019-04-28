<?php 
/*自定义方法*/

/*发送短信*/
function sendTel($tel,$rand){

	$host = "http://dingxin.market.alicloudapi.com";
    $path = "/dx/sendSms";
    $method = "POST";
    $appcode = "f52b34208026489d9638151b95b96212";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $querys = "mobile=".$tel."&param=code%3A".$rand."&tpl_id=TP1711063";
    $bodys = "";
    $url = $host . $path . "?" . $querys;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    var_dump(curl_exec($curl));	
    	                    
     if(curl_exec($curl)) {
         return true;
     } else {
         return false;
     }

}

/*正确提示*/
function successly($font=''){
    $message=[
        'font'=>$font,
        'code'=>1
      ];
    echo json_encode($message);
}
/*错误提示*/
function fail($font=''){
    $message=[
        'font'=>$font,
        'code'=>2
      ];
    echo json_encode($message);exit;
}


?>