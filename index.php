<?php
header('Access-Control-Allow-Origin: *');



$client_id = '0vafi6lojjznm2k';
$state = '';
$redirect_uri = '';

$token = 'sl.BnGeMrhZb9E9HdIxfvoGlq9n14M4pBTjdwFspMOuC772Bke1wDujGajrA5MKIpQEJbXRbwTPEb9LKorRss1o_G5vNVrWis6xTv_MoPhJzoQPfb-ucVxAapo_15ZMmEpZeLQJ0YA7--zzseO6o3yr';

$url = 'https://www.dropbox.com/oauth2/authorize?client_id='. $client_id .'&response_type=code&state=b3f44c1eb885409c222fdb78c125f5e7050ce4f3d15e8b15ffe51678dd3a33d3a18dd3&redirect_uri=http://localhost/dropbox/redirect.php&token_access_type=offline';

header('Location: '.$url);

?>
