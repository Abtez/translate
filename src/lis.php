<?php
$text =  trim(file_get_contents("test.txt"));


function getAllLis() {
    //from db
    $databaseLis = json_decode(file_get_contents("https://munenepeter.github.io/my-file-tracker/data/datas.json"));

    $allLis = [];

    foreach ($databaseLis as $databaseLi) {
        $allLis[] = $databaseLi->name;

        $abbrs = explode(',', trim($databaseLi->abbr));

        foreach ($abbrs as $abbr) {
            $allLis[] = trim($abbr);
        }
    }
    return   $allLis;
}


function getLisInText($text, $lis) {
    $foundWords = [];

    $chunkSize = 242;
    $searchWordChunks = array_chunk(array_unique($lis), $chunkSize);

    // Search for each group of words separately
    foreach ($searchWordChunks as $chunk) {
        $escapedSearchWords = array_map(function ($word) {
            return preg_quote($word, '/');
        }, $chunk);
        $pattern = '/\b(' . implode('|', $escapedSearchWords) . ')\b/i';
        preg_match_all($pattern, $text, $matches);
        //remove duplicate & empty elements
        $foundWords = array_filter(array_unique(array_merge($foundWords, $matches[0])));
    }
    return $foundWords;
}



if (!empty(getLisInText($text, getAllLis()))) {
    echo "Found the following words " . implode(", ", getLisInText($text, getAllLis()));
} else {
    echo "None of the search words were found";
}



clearstatcache();
