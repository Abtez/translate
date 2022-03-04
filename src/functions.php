<?php



header('Content-Type: application/json; charset=utf-8');

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: PUT, GET, POST");


include '../vendor/autoload.php';

$logger = new class {

    public String $log = "";

    public function log(String $message) {

        $this->log = date("D, d M Y H:i:s") . ' - ' . $_SERVER['SERVER_NAME'] . ' - ' . $_SERVER['REMOTE_ADDR'] . ' - ' . "$message" . PHP_EOL;

        $logFile =  "../Logs/log.log";

        $file = fopen($logFile, 'a');
        fwrite($file, $this->log);
        fclose($file);
    }
};

 
if ($_FILES['files']) {
 
    $start_time = microtime(true);
    $logger->log('INFO: Succesfully uploaded ' . json_encode($_FILES));

    if ($_FILES['files']['type'] === "application/pdf") {

        $parser = new \Smalot\PdfParser\Parser();
        try {

            $pdf = $parser->parseFile($_FILES['files']['tmp_name']);

            $text = $pdf->getText();

            $logger->log('INFO: Trying to parse ' . implode(', ', $pdf->getDetails()));

            $end_time = microtime(true);            
            $execution_time = round(($end_time - $start_time), 4);

        } catch (\Exception $e) {

            echo '<div class="card" style="color:red;bg-color:red;"> <p class="p-4">' . $e->getMessage() .  '</p> </div> </div>';
            $logger->log('ERROR: An exception was called ' . $e->getMessage());

            return;
        }
    } else {
        try {
            $text = \LukeMadhanga\DocumentParser::parseFromFile($_FILES['files']['tmp_name']);
        } catch (\Exception $e) {

            echo '<div class="card" style="color:red;bg-color:red;"> <p class="p-4">' . $e->getMessage() .  '</p> </div> </div>';
            $logger->log('ERROR: An exception was called ' . $e->getMessage());

            return;
        }
    }
    if (!empty($text)) {
        $logger->log("INFO: Successfully parsed ". $_FILES['files']['name']. " in  $execution_time seconds!");
        echo nl2br($text);
    } else {
        $logger->log('ERROR: Something has happened!');
        echo "ERROR: Something has happened";
    }


    clearstatcache();
}




