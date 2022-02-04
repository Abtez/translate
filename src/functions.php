<?php

$logger = new class {
    
    public String $log = "";

    public function log(String $message){
        
        $this->log = date("D, d M Y H:i:s").' - '.$_SERVER['SERVER_NAME'].' - '. $_SERVER['REMOTE_ADDR'].' - ' ."$message".PHP_EOL;

        $logFile =  "Logs/log.txt";

        $file = fopen($logFile, 'a');
        fwrite($file, $this->log);
        fclose($file);

    }

};
