<?php

  $client_id = '0vafi6lojjznm2k';
  $client_secret = '475cikhnd0e24ty';

  
  $code = $_GET['code'];

  $res_token = getAccessToken($code,$client_id,$client_secret);

  //  ["access_token"]=> string(154) "sl.BnMJg5m496X_n9gf6q4H4iOgCLo28yKkDzcfgpW0mm8fd-ppUThOoYVb6yPEHePGvpdRjl1mLf1HC3kktAnJMZ8dxu1vbUDov_TP94DsbHk2T54DRPhwhTtVWhVVWG_gzkcrwqwFNzHMui1UnjCkBvM" ["refresh_token"]=> string(64) "SgozyOk6MN4AAAAAAAAAAc9YtYMhs6HGHfTEd6dffzFcJMpgTyr_6kfBKkts5SzL" 
  $res_token = ["access_token" =>  "sl.BnMJg5m496X_n9gf6q4H4iOgCLo28yKkDzcfgpW0mm8fd-ppUThOoYVb6yPEHePGvpdRjl1mLf1HC3kktAnJMZ8dxu1vbUDov_TP94DsbHk2T54DRPhwhTtVWhVVWG_gzkcrwqwFNzHMui1UnjCkBvM"
   , "refresh_token" => "SgozyOk6MN4AAAAAAAAAAc9YtYMhs6HGHfTEd6dffzFcJMpgTyr_6kfBKkts5SzL"  ] ;
  $listFiles = getFileList($res_token['access_token']);

  $fileDownLoads = [] ;
  foreach ($listFiles as $file) {

    if($file['.tag'] == "file" ){
      $fileDownLoads [] = $file;
    }
  }

  foreach ( $fileDownLoads as $file){
    $result = downLoadFile($res_token['access_token'],$file['id'],$file['name']);
    if ( isset($result['error'])){
      $access_token = getAccessTokenbyRefreshToken($res_token['refresh_token'],$client_id,$client_secret);
      $res_token['access_token'] = $access_token ;
      downLoadFile($res_token['access_token'],$file['id'],$file['name']);
    }
  }
// list folder
function getAccessTokenbyRefreshToken($refresh_token , $client_id , $client_secret){
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/oauth2/token');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  
  
  
  
  curl_setopt($ch, CURLOPT_POSTFIELDS,"refesh_token=".$refresh_token."&grant_type=refresh_token&client_id=".$client_id."&client_secret=".$client_secret);
  
  
  $result = curl_exec($ch);
  $result = json_decode($result,true);

  curl_close($ch);

  return $result['access_token'];
}

function getAccessToken($code , $client_id , $client_secret){
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/oauth2/token');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  
  
  
  $data = array(
    "code"=> $code,
    "grant_type"=> 'authorization_code',
    "redirect_uri"=> 'http://localhost/dropbox/redirect.php',
    "client_id"=> $client_id,
    "client_secret"=> $client_secret,
   
  );
  curl_setopt($ch, CURLOPT_POSTFIELDS,"code=".$code."&grant_type=authorization_code&redirect_uri=http://localhost/dropbox/redirect.php&client_id=".$client_id."&client_secret=".$client_secret);
  
  
  $result = curl_exec($ch);
  $result = json_decode($result,true);

  curl_close($ch);

  return ["access_token" =>  $result['access_token'] , "refresh_token" =>  $result['refresh_token']  ];
}

function getFileList($access_token){
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/2/files/list_folder');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  
  $headers = array();
  $headers[] = 'Authorization: Bearer ' . $access_token;
  $headers[] = 'Content-Type: application/json';
  
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
  $data = array(
    "include_deleted"=> false,
      "include_has_explicit_shared_members"=> false,
      "include_media_info"=> false,
      "include_mounted_folders"=> true,
      "include_non_downloadable_files"=> true,
      "path"=> "",
      "recursive"=> false
  );
  
  curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
  
  
  $result = curl_exec($ch);
  $result = json_decode($result,true);
  curl_close($ch);
  return $result['entries'];
}












//{".tag": "file", "name": "spe-icons.png", "path_lower": "/spe-icons.png", "path_display": "/spe-icons.png", "id": "id:pUWC09_KLtsAAAAAAAAASQ", "client_modified": "2014-07-24T09:52:22Z", "server_modified": "2014-07-24T09:52:22Z", "rev": "58122df598", "size": 8278, "is_downloadable": true, "content_hash": "e964baee1b3beec7c310751351d2a9c99690543b56b1ba788342af583119d24b"},
function downLoadFile($access_token , $file_id , $file_name){

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, 'https://content.dropboxapi.com/2/files/download');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  
  $data = array(
     "path" => $file_id 
    // "path" => "spe-icons.png"
  );
  
  $headers = array();
  $headers[] = 'Authorization: Bearer ' . $access_token ;
  $headers[] = 'Dropbox-API-Arg: ' . json_encode($data);
  $headers[] = 'Content-Type: application/octet-stream; charset=utf-8';
  
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
  // $data = array(
  // 	 //"path" => "id:pUWC09_KLtsAAAAAAAAASQ"
  // 	"path" => "spe-icons.png"
  // );
  
  // curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data, true));
  

  
  
  // curl_setopt($ch, CURLOPT_FILE, $fp); 
  // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  
  $result = curl_exec($ch);
  $result_json = json_decode($result,true);
  curl_close($ch);

  if(isset($result_json['error_summary']) ){
    return ['error' => $result_json['error_summary']];
  }else{
    $fp = fopen (dirname(__FILE__) . '/' . $file_name, 'w+');
    if (fwrite($fp, $result) === FALSE) {
      return ['error' =>  "Cannot write to file ($file_name)"];
    }
    return ['success' => 'file download Success'];
  }
}
