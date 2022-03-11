// Also see: https://www.quirksmode.org/dom/inputfile.html
// document.addEventListener('load', ()=>{
//   document.getElementById("translate").style.display = "none";
// });


const checkbox = document.getElementById('checkbox');

checkbox.addEventListener('change', () => {
  document.body.classList.toggle('dark');
  localStorage.setItem("KEY", "value");
  // localStorage.getItem("KEY");
})

// localStorage.setItem("Max", "Keme");
var inputs = document.querySelectorAll('.file-input')

for (var i = 0, len = inputs.length; i < len; i++) {
  customInput(inputs[i])
}

function customInput(el) {
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

const form = document.querySelector("form");
form.addEventListener("submit", (e) => {
  e.preventDefault();
  document.getElementById("loading").style.display = "block";
  
  const formData = new FormData(form);
  const url = window.location.href + "/src/functions.php";
  axios
    .post(url, formData, {
      headers: {
        "Content-Type": "multipart/form-data",        
      },
    })
    .then((res) => {    
      document.getElementById('content').innerHTML = res.data;
      document.getElementById("loading").style.display = "none";
      document.getElementById("clear").style.display = "block";      
    })
    .catch((err) => {
      console.log(err);
    });
});

const clearBtn = document.getElementById('clear');
clearBtn.addEventListener('click', () => {
  document.getElementById('content').innerHTML = '';
  document.getElementById("clear").style.display = "none";
});