<?php

header('Content-Type: application/json; charset=utf-8');

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: PUT, GET, POST");

include 'functions.php';

$messages = [];

if ($_FILES['files']) {
    $start_time = microtime(true);
    logger('INFO: Succesfully uploaded ' . json_encode($_FILES));
    try {
        $text = readUploadedFile($_FILES['files']['tmp_name']);
        $end_time = microtime(true);
        $execution_time = round(($end_time - $start_time), 4);
    } catch (\Exception $e) {
        logger('ERROR: '. $e->getMessage());
        $messages['text'] = '<p class="p-4 text-red-500 text-sm font-semibold text-center">You have no idea what happened huh? Well so do I. Code:E214</p>';
    }

    if (!empty($text)) {
        logger("INFO: Successfully parsed " . $_FILES['files']['name'] . " in  $execution_time seconds!");
        $messages['text'] = $text;
    } else {
        logger('ERROR: Couldn\'t get the text!');
        $messages['lis_found'] = "No LI's Found!";
        echo json_encode($messages);
        return;
    }
}

//search for LIS
if (!empty(getLisInText($text, getAllLis()))) {
    $messages['lis_found'] =  implode(", ", getLisInText($text, getAllLis()));
} else {
    $messages['lis_found'] = "No LI's Found!";
}

echo json_encode($messages);

clearstatcache();
exit;

if (isset($_GET['url'])) {
    $url = urldecode($_GET['url']); // Decode URL-encoded string


    // Use basename() function to return the base name of file
    $file_name = basename($url);

    // Use file_get_contents() function to get the file
    // from url and use file_put_contents() function to
    // save the file by using base name
    if (file_put_contents($file_name, file_get_contents($url))) {
        echo "File downloaded successfully";
    } else {
        echo "File downloading failed.";
    }
}
