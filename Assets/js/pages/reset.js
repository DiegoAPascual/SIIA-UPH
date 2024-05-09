const formRestablecer = document.querySelector("#formRestablecer");
const clave_nueva = document.querySelector("#clave_nueva");
const clave_confirmar = document.querySelector("#clave_confirmar");

document.addEventListener("DOMContentLoaded", function () {
  formRestablecer.addEventListener("submit", function (e) {
    e.preventDefault();
    if (clave_nueva.value == "" || clave_confirmar.value == "") {
      alertaPersonalizada("warning", "Todos los campos son requeridos.");
    } else {
      if (clave_nueva.value != clave_confirmar.value) {
        alertaPersonalizada("warning", "Las contraseñas no coindiden.");
      } else {
        const data = new FormData(formRestablecer);
        const http = new XMLHttpRequest();
        const url = base_url + "principal/changePassword";
        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            alertaPersonalizada(res.tipo, res.mensaje);
            if (res.tipo == "success") {
              setTimeout(() => {
                window.location = base_url;
              }, 1500);
            }
          }
        };
      }
    }
  });
});
