<?php
const JSON_URL = "videos.json";
const USER_JSON_URL = "users.json";

function mylog($value) {
    file_put_contents("log.txt", $value . "\n", FILE_APPEND);
}

function userNumber($username) {
    if (!file_exists(USER_JSON_URL)) {
        $json = [];
    } else {
        $json = json_decode(file_get_contents(USER_JSON_URL), true);
    }

    if (is_null($json[$username])) {
        $json[$username] = count($json);
        mkdir('files/' . $json[$username]);
    }
    file_put_contents(USER_JSON_URL, json_encode($json));
    return (string) $json[$username];
}

function addVideoToJSON($username, $url) {
    if (!file_exists(JSON_URL)) {
        $json = [];
    } else {
        $json = json_decode(file_get_contents(JSON_URL), true);
    }

    $usernumber = userNumber($username);
    if (is_null($json[$usernumber])) {
        $json[$usernumber] = [];
    }
    array_push($json[$usernumber], $url);
    file_put_contents(JSON_URL, json_encode($json));
}

$file = $_FILES["file"];
$name = $_POST["name"];

if (is_null($name)) {
    http_response_code(903);
    echo "No name";
    exit;
}

if (is_null($file)) {
    http_response_code(903);
    echo "No file";
    exit;
}

if (substr($file['type'], 0, 5) !== 'video') {
    http_response_code(902);
    echo "Kein video";
    exit;
}

if (filesize($file) > 128000000) {
    http_response_code(904);
    echo "Video zu gross";
    exit;
}

$filename = basename($file['name']);

$uploadfile = 'files/' . userNumber($name) . "/" . $filename;

if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
    addVideoToJSON($_POST["name"], $filename);

    echo $uploadfile;
    mylog("name = ".$_POST["name"]."; filename = ".$uploadfile);
} else {
    http_response_code(901);
    echo 'File move failed';
}
?>