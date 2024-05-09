const frm = document.querySelector("#formulario");
const correo = document.querySelector("#correo");
const clave = document.querySelector("#clave");

const registro_form = document.querySelector("#registro-form");
const registrabtn = document.querySelector("#registrar");
const titulo = document.querySelector("#registro-modal-title");
const modalRegistroUsuarios = document.querySelector("#modalRegistroUsuarios");


const inputReset = document.querySelector("#inputReset");
const btnProcesar = document.querySelector("#btnProcesar");
const btnreset = document.querySelector("#reset");
const modalReset = new bootstrap.Modal(document.querySelector('#modalResetPassword'));
const myModalUsuarios = new bootstrap.Modal(modalRegistroUsuarios);

document.addEventListener("DOMContentLoaded", function () {
  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    if (correo.value == "" || clave.value == "") {
      alertaPersonalizada("warning", "Todos los campos con * son requeridos");
    } else {
      const data = new FormData(frm);
      const http = new XMLHttpRequest();
      
      const url = base_url + "principal/validar";

      http.open("POST", url, true);

      http.send(data);

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            let timerInterval;
            Swal.fire({
              title: res.mensaje,
              html: "Será redireccionado en <b></b> milisegundos.",
              timer: 1500,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                  timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
              },
              willClose: () => {
                clearInterval(timerInterval);
              },
            }).then((result) => {
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                window.location = base_url + 'admin';
              }
            });
          }
        }
      };
    }
  });

  btnreset.addEventListener('click', function(){
    inputReset.value == '';
    modalReset.show();
  })

  btnProcesar.addEventListener('click', function() {
    if (inputReset.value == '') {
      alertaPersonalizada("warning", "Ingrese el correo electrónico.");
    } else {
      const http = new XMLHttpRequest();
      const url = base_url + "principal/enviarCorreo/" + inputReset.value;
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            inputReset.value = '';
            modalReset.hide();
          }
        }
      };
    }
  })

  registrabtn.addEventListener("click", function () {
    titulo.textContent = "Registro de usuarios";
    registro_form.reset();
    myModalUsuarios.show();
  });

  // Registro de usuario por AJAX
registro_form.addEventListener("submit", function (e) {
  e.preventDefault();
  if (
      registro_form.nombre.value == "" ||
      registro_form.apellido.value == "" ||
      registro_form.correo.value == "" ||
      registro_form.telefono.value == "" ||
      registro_form.direccion.value == "" ||
      registro_form.clave.value == "" ||
      registro_form.rol.value == ""
  ) {
      alertaPersonalizada("warning", "Todos los campos son requeridos");
  } else {
      const data = new FormData(registro_form);
      const http = new XMLHttpRequest();
      const url = base_url + "principal/guardar"; // Reemplaza esto con la URL correcta de tu backend

      http.open("POST", url, true);
      http.send(data);

      http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
              const res = JSON.parse(this.responseText);
              alertaPersonalizada(res.tipo, res.mensaje);
              if (res.tipo == "success") {
                  registro_form.reset();
                  myModalUsuarios.hide();
              }
          }
      };
  }
});
});
