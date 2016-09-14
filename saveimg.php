<?php
define('UPLOAD_DIR', 'temp/');
$img = $_POST['img'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.png';
$success = file_put_contents($file, $data);
print $success ? $file : 'Unable to save the file.';


$tim ="http://www.hubnest.com/images/team/tim.jpg";
$group = "http://www.businessstudynotes.com/wp-content/uploads/2015/09/Group-and-Team.jpg";

echo "url" => "http://timzhong.com/e/faceRecog/" . $file;

$fields = array(
  //"url" => $file
    "url" => "http://timzhong.com/e/faceRecog/" . $file
);
$fields_string = json_encode($fields);

//url-ify the data for the POST
// foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
// rtrim($fields_string, '&');

$key = "28b0d9fcd79b47339e0fd0599a73d699";
$service_url = "https://api.projectoxford.ai/face/v1.0/detect?returnFaceId=true&returnFaceLandmarks=false&returnFaceAttributes=age,gender,headPose,smile,facialHair,glasses";


$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Ocp-Apim-Subscription-Key: $key"
));
curl_setopt($curl,CURLOPT_POST, count($fields));
curl_setopt($curl,CURLOPT_POSTFIELDS, $fields_string);

$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);

echo "<pre>";
print_r($decoded);
echo "</pre>";