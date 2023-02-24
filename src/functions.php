<?php

use Smalot\PdfParser\Parser;
use LukeMadhanga\DocumentParser;


header('Content-Type: application/json; charset=utf-8');

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: PUT, GET, POST");


include '../vendor/autoload.php';

$messages = [];

$logger = new class {

    public String $log = "";

    public function log(String $message) {

        $this->log = date("D, d M Y H:i:s") . ' - ' . $_SERVER['SERVER_NAME'] . ' - ' . $_SERVER['REMOTE_ADDR'] . ' - ' . "$message" . PHP_EOL;

        $logFile =  __DIR__."/../static/logs.log";

        $file = fopen($logFile, 'a+');
        fwrite($file, $this->log);
        fclose($file);
    }
};


if ($_FILES['files']) {

  
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

$lis_found = [];

$githubLis = json_decode(file_get_contents("https://munenepeter.github.io/my-file-tracker/data/datas.json"));

$fileText = trim($text);

 
 
$found = false;

foreach ($githubLis as $githubLi) {
    if (strpos($fileText, $githubLi->name) !== false) {
        $found = true;
        $lis_found[] = $githubLi->name;
    }
    $abbrs = explode(',', trim($githubLi->abbr));

    foreach ($abbrs as $abbr) {
        if (is_array($abbr)) {
            foreach ($abbr as $sub_abbr) {
                if (strpos($fileText, $sub_abbr) !== false) {
                    $found = true;
                    $lis_found[] = $githubLi->name;
                }
            }
        }

        if (strpos($fileText, $abbr) !== false) {
            $found = true;
            $lis_found[] = $githubLi->name;
        }
    }
}

if (!$found) {
    $messages['li_error'] = "No LI's Found!";
}else{
    $messages['lis_found'] =  implode(',', array_unique($lis_found));
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
