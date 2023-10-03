<?php
//https://developers.dropbox.com/oauth-guide
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




//{".tag": "file", "name": "spe-icons.png", "path_lower": "/spe-icons.png", "path_display": "/spe-icons.png", "id": "id:pUWC09_KLtsAAAAAAAAASQ", "client_modified": "2014-07-24T09:52:22Z", "server_modified": "2014-07-24T09:52:22Z", "rev": "58122df598", "size": 8278, "is_downloadable": true, "content_hash": "e964baee1b3beec7c310751351d2a9c99690543b56b1ba788342af583119d24b"},
$token = 'sl.BnBqdBq_afF3g251LHwxpYMwWOmTw-ViAH0VV3Hw8rrkf34kqmp1iaWkZJl7O3GeJ9wWbMlSL8BkZMCyD_-SvnqyHaL9lyap8CC3GGhtwysh8wjPKOu8HuxBvB4l7lX3vaMuGEgVdBSxrdlwt1rB';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://content.dropboxapi.com/2/files/download');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$data = array(
	 "path" => "id:pUWC09_KLtsAAAAAAAAASQ"
	// "path" => "spe-icons.png"
);

$headers = array();
$headers[] = 'Authorization: Bearer ' . $token;
$headers[] = 'Dropbox-API-Arg: ' . json_encode($data);
$headers[] = 'Content-Type: application/octet-stream; charset=utf-8';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $data = array(
// 	 //"path" => "id:pUWC09_KLtsAAAAAAAAASQ"
// 	"path" => "spe-icons.png"
// );

// curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data, true));



$fp = fopen (dirname(__FILE__) . '/spe-icons.png', 'w+');
curl_setopt($ch, CURLOPT_FILE, $fp); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$result = curl_exec($ch);
curl_close($ch);

var_dump ($result);
return;
$token = 'sl.BnBqdBq_afF3g251LHwxpYMwWOmTw-ViAH0VV3Hw8rrkf34kqmp1iaWkZJl7O3GeJ9wWbMlSL8BkZMCyD_-SvnqyHaL9lyap8CC3GGhtwysh8wjPKOu8HuxBvB4l7lX3vaMuGEgVdBSxrdlwt1rB';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/2/files/list_folder');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = 'Authorization: Bearer ' . $token;
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
curl_close($ch);

var_dump ($result);
?>