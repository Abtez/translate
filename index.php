
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
    <meta name="author" content="Peter Munene, Abzed Mohamed Maxwell Kanoru">
    <link rel="shortcut icon" href="static/imgs/translate.svg" type="image/svg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="static/css/style.css">
    <title>P-translate</title>
</head>

<body>

    <div class="container pt-8">
        <div class="card">

            <!-- Tabs navs -->

            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="ex1-tab-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">Convert Document</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex1-tab-2" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Text Translate</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex1-tab-3" data-mdb-toggle="tab" href="#ex1-tabs-3" role="tab" aria-controls="ex1-tabs-3" aria-selected="false">URL Translate</a>
                </li>
                <li class="nav-item" role="presentation">
                    <div class="mode">
                        <input type="checkbox" class="checkbox" id="checkbox">
                        <label for="checkbox" class="label">
                            <i class="fas fa-moon"></i>
                            <i class='fas fa-sun'></i>                            
                            <div class='ball'>
                        </label>
                    </div>
                </li>
            </ul>
            <hr>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex1-content">
                <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                    <div class="card-body">

                        <div id="translate">
                            <center>
                                <h5 class="card-title">Welcome to Document Translator</h5>
                                <i class="fab fa-cloud-upload"></i>
                                <br>
                                <form method="post" enctype="multipart/form-data">
                                    <p>Select document to translate</p>
                                    <div class='file-input'>
                                        <input type='file' name="files" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                        <span class='button'>Choose</span>
                                        <span class='clabel' data-js-label>No file selected</label>
                                    </div>
                                    <br>
                                    <button name="submitpdf" type="submit" id="submitpdf" class="btn btn-primary">Upload</button>
                                </form>
                            </center>
                            <div class="p-4 card text-left">
                                <p id="content" style="text-align: left;">
                                <center>
                                <img style="display:none;" id="loader" src="static/imgs/loader.gif" alt="" width="150" height="150" srcset=""></p>
                                </center>
                                <button id="clear" class="btn btn-primary" style="display:none;">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                    <div class="card-body">
                        <div id="translate">
                            <h5 class="card-title">Welcome to Text Translator</h5>
                            <br>
                                <div class="form-outline">
                                    <textarea class="form-control" id="textAreaExample" rows="4"></textarea>
                                    <label class="form-label" for="textAreaExample">Paste your content here</label>
                                </div>
                                <br>
                                <button id="textUpload" class="btn btn-primary">Upload</button>                       
                            <div class="p-4 card text-left">
                                <p id="text-content" style="text-align: left;"></p>
                                <button id="clear" class="btn btn-primary" style="display:none;">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex1-tabs-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                    <div class="card-body">
                        <div id="translate">
                            <h5 class="card-title">Welcome to URL Document</h5>
                            <br>
                                <div class="form-outline">
                                    <input type="url" id="typeURL" class="form-control" />
                                    <label class="form-label" for="typeURL">URL input</label>
                                </div>
                                <div id="textExample1" class="form-text">
                                    Here please paste the url to the document...
                                </div>
                                <br>
                                <button  type="submit" id="submiurl" class="btn btn-primary">Upload</button>
                          
                            <div class="p-4 card text-left">
                               
                                <p id="content" style="text-align: left;">
                                
                                 </p>
                                <button id="clear" class="btn btn-primary" style="display:none;">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <br>
    <div class="container">
        <div class="card">
            <h5 class="card-header">Possible LI's</h5>
            <div class="card-body">
                <h5 class="card-title">The following have been found to be possible LI's within the file</h5>
                <p class="card-text">Confirm and copy them to your clipboard</p>
 <p id="flis"></p>
              
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
                <br>
                <a href="#" onclick="copyText()" class="btn btn-primary">Copy LI's</a>
            </div>
        </div>
    </div>

    <footer style="margin-top: 15px;">
        <div class="container">
            <div class="row">
                <div class="row text-center">
                    <div class="col-md-4 box">
                        <span class="copyright quick-links">Copyright &copy; P-translate
                            <script>
                                document.writeln(new Date().getFullYear())
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
    </script>                            <li class="list-inline-item">
                                <a href="https://github.com/munenepeter">Peter</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://github.com/kejereme">Max</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
    

</body>

</html>