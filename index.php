<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="title" content="P-translate">
    <meta name="description" content="A Simple way of parsing pdf, docx, text or rtf files so as to identify certain keywords using pearl">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="author" content="Peter Munene, Abzed Mohamed Maxwell Kanuro">
    <link rel="shortcut icon" href="static/imgs/translate.svg" type="image/svg">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js" rel="stylesheet" />

    <link rel="stylesheet" href="src/style.css" media="(prefers-color-scheme: dark)">
    <title>P-translate</title>
</head>

<body>
    <?php

    // include composer autoloader
    include 'vendor/autoload.php'; 
    include 'src/functions.php';

    // $logger->log('Successfully included'. json_encode(get_included_files()));
    ?>
    <div class="container">

        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="true" href="#!">Convert PDF</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link disabled" href="#!">Text Translate</a>
                    </li>
                </ul>
                <div class="mode">
                    <input type="checkbox" class="checkbox" id="checkbox">
                    <label for="checkbox" class="label">
                        <i class="fas fa-moon"></i>
                        <i class='fas fa-sun'></i>
                        <div class='ball'>
                    </label>
                </div>
            </div>

            <div class="card-body">
                <div id="translate">
                    <h5 class="card-title">Welcome to Document Translator</h5>
                    <i class="fab fa-cloud-upload"></i>
                    <br>
                    <form action="" method="post" enctype="multipart/form-data">

                        <p style="text-align: center;">Select document to translate <br />
                            <input type='file' name="file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                            <!-- <span class='button'>Choose</span> File </p> -->
                        </p>


                        <!-- <div class='file-input'>
                            
                             <span class='label' data-js-label>No file selected</label>
                        </div> -->

                        <br>
                        <button name="submitpdf" type="submit" id="submitpdf" class="btn btn-primary">Upload</button>
                    </form>
                </div>
                <div id="details">

                    <?php

                    if (isset($_POST['submitpdf'])) {
                        $start_time = microtime(true);
                        // $logger->log('Submit was pressed and posted'. json_encode($_POST));
                        $logger->log('Succesfully uploaded ' . json_encode($_FILES));

                        // parse pdf

                        if ($_FILES['file']['type'] === "application/pdf") {

                            $parser = new \Smalot\PdfParser\Parser();
                            try {
                                $logger->log('Succesfully instantiated the Parser' . get_class($parser));

                                $pdf = $parser->parseFile($_FILES['file']['tmp_name']);
                                $text = $pdf->getText();

                                $logger->log('Trying to parse ' . implode(', ', $pdf->getDetails()));

                                $end_time = microtime(true);
                                $execution_time = ($end_time - $start_time);
                            } catch (\Exception $e) {

                                echo '<div class="card" style="color:red;bg-color:red;"> <p class="p-4">' . $e->getMessage() .  '</p> </div> </div>';
                                $logger->log('Error: An exception was called ' . $e->getMessage());

                                return;
                            }
                        } else {
                            try {
                                $text = \LukeMadhanga\DocumentParser::parseFromFile($_FILES['file']['tmp_name']);
                            } catch (\Exception $e) {

                                echo '<div class="card" style="color:red;bg-color:red;"> <p class="p-4">' . $e->getMessage() .  '</p> </div> </div>';
                                $logger->log('Error: An exception was called ' . $e->getMessage());

                                return;
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="p-4 card">
            <p class="
                <?php
                if ($_FILES['file']['type'] === 'application/pdf') {
                    echo 'p-4';
                } else {
                    echo '';
                }
                ?>
                ">
                <?php

                if (!empty($text)) {
                    //$logger->log('Successfully parsed  '. reset($pdf->getDetails()) .' with  '. end($pdf->getDetails()).' pages in '. round($execution_time, 2). 'secs');
                    echo $text;
                } else {
                    // $logger->log('Error: Something has happened cause the file with  '. end($pdf->getDetails()).' pages has not been parsed ');
                }


                clearstatcache();
                ?>
            </p>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="card">
            <h5 class="card-header">Possible LI's</h5>
            <div class="card-body">
                <h5 class="card-title">The following have been found to be possible LI's within the file</h5>
                <p class="card-text">Confirm and copy them to your clipboard</p>

                 <script>
                    var Lis = document.getElementsByClassName("pearl-hilighted-word");
                    Lis = document.querySelectorAll('#p-4 card .pearl-highlighted-word');
                </script>
                <script>
                    var closebtns = document.getElementsByClassName("close");
                    var i;

                    /* Loop through the elements, and hide the parent, when clicked on */
                    for (i = 0; i < closebtns.length; i++) {
                        closebtns[i].addEventListener("click", function() {
                            this.parentElement.style.display = 'none';
                        });
                    }
                </script>
                <a href="#" onclick="copyText()" class="btn btn-primary">Copy LI's</a>
            </div>
        </div>
    </div>

    <footer style="margin-top: 220px;">
        <div class="container">
            <div class="row">
               
                <div class="row text-center">
                    <div class="col-md-4 box">
                        <span class="copyright quick-links">Copyright &copy; P-translate
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                        </span>
                    </div>
                    <div class="col-md-4 box">
                        <ul class="list-inline social-buttons">
                            <li class="list-inline-item">
                                <a href="https://github.com/Abzed/translate">
                                    <i class="fab fa-github"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 box">
                        <ul class="list-inline quick-links">
                            <li class="list-inline-item">
                                <a href="https://github.com/Abzed">Abzed</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://github.com/munenepeter">Peter</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
    <script src="static/js/index.js"></script>
    <script>
        var myVar;

        function myFunction() {
            myVar = setTimeout(showPage, 3000);
        }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("myDiv").style.display = "block";
        }
    </script>

</body>

</html>
