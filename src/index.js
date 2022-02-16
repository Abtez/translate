// Also see: https://www.quirksmode.org/dom/inputfile.html

var inputs = document.querySelectorAll('.file-input')

for (var i = 0, len = inputs.length; i < len; i++) {
  customInput(inputs[i])
}

function customInput (el) {
  const fileInput = el.querySelector('[type="file"]')
  const label = el.querySelector('[data-js-label]')
  
  fileInput.onchange =
  fileInput.onmouseout = function () {
    if (!fileInput.value) return
    
    var value = fileInput.value.replace(/^.*[\\\/]/, '')
    el.className += ' -chosen'
    label.innerText = value
  }
}


function getQoute() {

            fetch("https://type.fit/api/quotes")
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {

                    let currentQoute = Math.floor(Math.random() * data.length);

                    let qoute = data[currentQoute].text;
                    let author = data[currentQoute].author;



                    document.getElementById('qoute').innerHTML = qoute;
                    document.getElementById('author').innerHTML = author;

                    setTimeout(() => {

                        document.getElementById('qoute').innerHTML = '';
                        document.getElementById('author').innerHTML = '';

                    }, 50000);

                });
        }


        setInterval(getQoute, 7200);