// Also see: https://www.quirksmode.org/dom/inputfile.html
// document.addEventListener('load', ()=>{
//   document.getElementById("translate").style.display = "none";
// });


// const checkbox = document.getElementById('checkbox');

// checkbox.addEventListener('change', () => {
//   document.body.classList.toggle('dark');
//   localStorage.setItem("KEY", "value");
//   // localStorage.getItem("KEY");
// })

// // localStorage.setItem("Max", "Keme");
// var inputs = document.querySelectorAll('.file-input')

// for (var i = 0, len = inputs.length; i < len; i++) {
//   customInput(inputs[i])
// }

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
  document.getElementById("loader").style.display = "block";

  const formData = new FormData(form);
  const url = "/src/functions.php";
  axios
    .post(url, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((res) => {
      console.log(res);
      document.getElementById("loader").style.display = "none";
      document.getElementById("submitpdf").style.display = "none";
      document.getElementById("file_input").style.display = "none";

      document.getElementById("doc-label").innerText = "The following have been found to be possible LI's within the file";
      document.getElementById("doc-label-guide").innerText = "Confirm and copy them to your clipboard";

      document.getElementById("doc-content").style.display = "block";

      document.getElementById('content').innerHTML = res.data.text;
      document.getElementById('flis').innerHTML = res.data.lis_found;

      document.getElementById("clear").style.display = "block";
      document.getElementById("lis-found").style.display = "block";
    })
    .catch((err) => {
      console.log(err);
    });

});

const clearBtn = document.getElementById('clear');
clearBtn.addEventListener('click', () => {
  document.getElementById("lis-found").style.display = "none";

  document.getElementById('content').innerHTML = '';

  document.getElementById("doc-label").innerText = "Welcome to Document Parser";
  document.getElementById("doc-label-guide").innerText = "Select document to parse";

  document.getElementById("submitpdf").style.display = "block";
  document.getElementById("file_input").style.display = "block";

  document.querySelector("form").reset();

  document.getElementById("doc-content").style.display = "none";
  document.getElementById("clear").style.display = "none";
});

const textUploadBtn = document.getElementById('submittext');
textUploadBtn.addEventListener('click', () => {
  let text = document.getElementById('textAreaExample').value;
  document.getElementById('text-content').innerHTML = text;
  document.getElementById("clear").style.display = "block";
});