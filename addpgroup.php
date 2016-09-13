<?
$pgroupname = "Test Group";
$pgroupid = "test";
$pgroupdesc = "Group for testing";

$fields = array(
    "name" => $pgroupname,
    "userData" => $pgroupdesc
);
$fields_string = json_encode($fields);

//url-ify the data for the POST
// foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
// rtrim($fields_string, '&');

$key = "a5ad432714d54b8dafaf011b5f8982fa";
$service_url = "https://api.projectoxford.ai/face/v1.0/persongroups/$pgroupid";


$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
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

echo $curl_response;