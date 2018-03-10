<?php
/**
 * Created by PhpStorm.
 * User: infinisil
 * Date: 31.12.16
 * Time: 16:13
 */


const JSON_URL = "videos.json";
const USER_JSON_URL = "users.json";


$name = getallheaders()['Name'];

function mylog($value) {
    file_put_contents("log.txt", $value . "\n", FILE_APPEND);
}

function userNumber($username) {
    if (!file_exists(USER_JSON_URL)) {
        return -1;
    } else {
        $json = json_decode(file_get_contents(USER_JSON_URL), true);
    }

    if (is_null($json[$username])) {
        return -1;
    }
    return (string) $json[$username];
}

    if (!file_exists(JSON_URL)) {
        $json = [];
    } else {
        $json = json_decode(file_get_contents(JSON_URL), true);
    }

    $usernumber = userNumber($name);
    if (is_null($json[$usernumber])) {
        $json[$usernumber] = [];
    }
    mylog('' . $usernumber . '   ' . $name);

    $new = ["number" => $usernumber,
            "videos" => $json[$usernumber]];

    echo json_encode($new);

?>