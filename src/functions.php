<?php

use Smalot\PdfParser\Parser;
use LukeMadhanga\DocumentParser;


header('Content-Type: application/json; charset=utf-8');

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: PUT, GET, POST");


include '../vendor/autoload.php';

include 'funcs.php';

$messages = [];




if ($_FILES['files']) {
   echo mime_content_type($_FILES['files']['tmp_name']);


   exit;
  
    $start_time = microtime(true);
    $logger->log('INFO: Succesfully uploaded ' . json_encode($_FILES));

    if ($_FILES['files']['type'] === "application/pdf") {

        $parser = new Parser();
        try {

            $pdf = $parser->parseFile($_FILES['files']['tmp_name']);

            $text = $pdf->getText();

            $logger->log('INFO: Trying to parse ' . implode(', ', $pdf->getDetails()));

            $end_time = microtime(true);
            $execution_time = round(($end_time - $start_time), 4);
        } catch (\Exception $e) {

            $messages['error'] = '<div class="card" style="color:red;bg-color:red;"> <p class="p-4">' . $e->getMessage() .  '</p> </div> </div>';
            $logger->log('ERROR: An exception was called ' . $e->getMessage());

            return;
        }
    } else {
        try {
            $text = DocumentParser::parseFromFile($_FILES['files']['tmp_name']);
        } catch (\Exception $e) {

            $messages['error'] =  '<div class="card" style="color:red;bg-color:red;"> <p class="p-4">' . $e->getMessage() .  '</p> </div> </div>';
            $logger->log('ERROR: An exception was called ' . $e->getMessage());

            return;
        }
    }
    if (!empty($text)) {
        $logger->log("INFO: Successfully parsed " . $_FILES['files']['name'] . " in  $execution_time seconds!");
        $messages['text'] = $text;
    } else {
        $logger->log('ERROR: Couldn\'t get the text!');
        $messages['error'] = "ERROR: Something has happened";
    }


  
}

//search for LIS
if (!empty(getLisInText($text, getAllLis()))) {
    $messages['lis_found'] =  implode(", ", getLisInText($text, getAllLis()));
} else {
    $messages['li_error'] = "No LI's Found!";
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
