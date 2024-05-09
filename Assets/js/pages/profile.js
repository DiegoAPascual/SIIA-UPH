const frmProfile = document.querySelector("#frmProfile");
const correo = document.querySelector("#correo");
const telefono = document.querySelector("#telefono");
const nombre = document.querySelector("#nombre");
const apellido = document.querySelector("#apellido");
const direccion = document.querySelector("#direccion");

const frmChangePassword = document.querySelector("#frmChangePassword");
const clave_actual = document.querySelector("#clave_actual");
const clave_nueva = document.querySelector("#clave_nueva");
const clave_confirmar = document.querySelector("#clave_confirmar");

document.addEventListener("DOMContentLoaded", function () {
  frmChangePassword.addEventListener("submit", function (e) {
    e.preventDefault();
    if (
      clave_actual.value == "" ||
      clave_nueva.value == "" ||
      clave_confirmar.value == ""
    ) {
      alertaPersonalizada("warning", "Todos los campos son requeridos.");
    } else {
      if (clave_nueva.value != clave_confirmar.value) {
        alertaPersonalizada("warning", "Las contraseñas no coindiden.");
      } else {
        const data = new FormData(frmChangePassword);
        const http = new XMLHttpRequest();
        const url = base_url + "usuarios/changePassword";
        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            alertaPersonalizada(res.tipo, res.mensaje);
            if (res.tipo == "success") {
              setTimeout(() => {
                window.location = base_url + "usuarios/cerrar_sesion";
              }, 1500);
            }
          }
        };
      }
    }
  });

  frmProfile.addEventListener("submit", function (e) {
    e.preventDefault();
    if( correo.value == "" || telefono.value == "" || nombre.value == "" || apellido.value == "" || direccion.value == "" || perfil.value == "") {
      alertaPersonalizada("warning", "Todos los campos con * son requeridos");
    } else {
      const data = new FormData(frmProfile);
      const http = new XMLHttpRequest();
      const url = base_url + "usuarios/changeProfile";
      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
        }
      };
    }
  });
});
