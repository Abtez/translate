<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="src/style.css">
    <title>Document Translator</title>
</head>

<body>
    <?php
    // include composer autoloader
    include 'vendor/autoload.php';
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
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div id="translate">
                    <h5 class="card-title">Welcome To Document Translator</h5>
                    <p class="card-text">Select document to translate</p>
                    <br>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" id="file" class="inputfile" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                        <label class="p-2" for="file">Choose a file <i class="fas fa-download"></i></label>
                        <br>
                        <button name="submitpdf" type="submit" id="submitpdf" class="btn btn-outline-dark btn-sm mt-3">Submit</button>
                    </form>
                </div>
                <div id="details">
                    

                    <?php

                    if (isset($_POST['submitpdf'])) {
                        // parse pdf
                        $parser = new \Smalot\PdfParser\Parser();

                        $pdf = $parser->parseFile($_FILES['file']['tmp_name']);

                        // get metadata
                        $metadata = $pdf->getDetails();

                        // loop each property
                         echo '<h5 class="card-title">Document Details</h5>';
                        foreach ($metadata as $meta => $value) {
                            if (is_array($value)) {
                                $value . implode(", ", $value);
                            }
                            echo '               
                                  <p class="card-text">' . '<b>' . $meta . '</b>' . "<br> " . $value . "<br>" . '</p>
                                  ';
                        }

                        $text = $pdf->getText();
                       
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="card">
            <p class="p-4">
         <?php 
         if(!empty($text))
          echo $text;
           
         clearstatcache();
            ?>
            </p>
        </div>

    </div>






    <footer class="bg-dark text-center text-light text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022 Copyright:
            <a style="color: #1C7BB8 !important;" class="text-dark" href="https://github.com/Abzed"> <b><u>CODERS HUB
                        KE</u></b> </a>
        </div>
        <!-- Copyright -->
    </footer>



    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
    <script>
        const submitpdf = document.querySelector('#submitpdf');
        submitpdf.addEventListener('click', function() {
            const translatediv = document.querySelector('#translate');
            translatediv.style.cssText = 'display:none';

            const detailsdiv = document.querySelector('#details');
            detailsdiv.style.cssText = 'display:block;';
        });
    </script>
</body>

</html>