const btnUpload = document.querySelector("#btnUpload");
const btnNuevaCarpeta = document.querySelector("#btnNuevaCarpeta");
const myModal = new bootstrap.Modal(document.querySelector("#modalFile"));

const myModalCarpeta = new bootstrap.Modal(document.querySelector("#modalCarpeta"));
const frmCarpeta = document.querySelector("#frmCarpeta");

const btnSubirArchivo = document.querySelector("#btnSubirArchivo");
const file = document.querySelector("#file");

const myModalCompartir = new bootstrap.Modal(document.querySelector("#modalCompartir"));
const id_carpeta = document.querySelector("#id_carpeta");

const carpetas = document.querySelectorAll(".carpetas");
const btnSubir = document.querySelector("#btnSubir");

//Ver Archivos
const btnVer = document.querySelector("#btnVer");

//Compartir archivos entre usuarios
const compartir = document.querySelectorAll(".compartir");
const myModalUser = new bootstrap.Modal(document.querySelector("#modalUsuarios")); 
const frmCompartir = document.querySelector("#frmCompartir");
const usuarios = document.querySelector("#usuarios");

const btnCompartir = document.querySelector("#btnCompartir");
const container_archivos = document.querySelector("#container-archivos");

//Datable detalle archivos compartidos
const btnVerDetalle = document.querySelector('#btnVerDetalle');
const content_acordeon = document.querySelector('#accordionFlushExample');

//Elimininar archivos recientes
const eliminar = document.querySelectorAll('.eliminar');

const myModalArchivos = new bootstrap.Modal(document.querySelector("#modalArchivos")); 

document.addEventListener("DOMContentLoaded", function () {
  btnUpload.addEventListener("click", function () {
    myModal.show();
  });

  btnNuevaCarpeta.addEventListener("click", function () {
    myModal.hide();
    myModalCarpeta.show();
  });

  frmCarpeta.addEventListener("submit", function (e) {
    e.preventDefault();
    if (frmCarpeta.nombre.value == "") {
      alertaPersonalizada(
        "warning",
        "El nombre para la carpeta nueva es requerido"
      );
    } else {
      const data = new FormData(frmCarpeta);

      const http = new XMLHttpRequest();

      const url = base_url + "recursos/crearcarpeta";

      http.open("POST", url, true);

      http.send(data);

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            setTimeout(() => {
              window.location.reload();
            }, 1000);
          }
        }
      };
    }
  });

  //Subir archivos
  btnSubirArchivo.addEventListener("click", function () {
    myModal.hide();
    myModalArchivos.show();
  });

  carpetas.forEach((carpeta) => {
    carpeta.addEventListener("click", function (e) {
      id_carpeta.value = e.target.id;
      myModalCompartir.show();
    });
  });

  btnSubir.addEventListener("click", function () {
    myModalCompartir.hide();
    myModalArchivos.show();
  });

  btnVer.addEventListener("click", function () {
    window.location = base_url + "recursos/ver/" + id_carpeta.value;
  });

  $(".js-states").select2({
    theme: 'bootstrap-5',
    placeholder: "Elija el o los usuarios",
    maximumSelectionLength: 5,
    minimumInputLength: 2,
    dropdownParent: $("#modalUsuarios"),
    ajax: {
      url: base_url + "archivos/getUsuarios",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          q: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: true,
    },
  });

  //Evento click para el enlace compartir
  compartir.forEach((enlace) => {
    enlace.addEventListener("click", function (e) {
      compartirArchivo(e.target.id);
    });
  });

  frmCompartir.addEventListener("submit", function (e) {
    e.preventDefault();
    if (usuarios.value == "") {
      alertaPersonalizada("warning", "Todos los campos son requeridos");
    } else {
      const data = new FormData(frmCompartir);
      const http = new XMLHttpRequest();
      const url = base_url + "archivos/compartir";
      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {

            $(".js-states").val(null).trigger("change");
            myModalUser.hide();
          }
        }
      };
    }
  });

  //Compartir archivos por carpeta
  btnCompartir.addEventListener("click", function () {
    verArchivos();
  });

  //Ver detalle compartido
  btnVerDetalle.addEventListener('click', function(){
    window.location = base_url + 'recursos/verdetalle/' + id_carpeta.value;
  })

  //Eliminar archivos recientes
  eliminar.forEach((enlace) => {
    enlace.addEventListener("click", function (e) {
       let id_archivo = e.target.getAttribute('data-id');
       const url = base_url + "archivos/eliminar/" + id_archivo;
       eliminarRegistro("¿ESTÁS SEGURO DE ELIMINAR?", "El archivo se eliminará de forma permanente en 30 días.", "Si, eliminar", url, null)
    });
  });
});

Dropzone.options.uploadForm = { 
  dictDefaultMessage: 'Seleccione para arrastrar y soltar archivos.',
  dictRemoveFile: 'Quitar',
  autoProcessQueue: false,
  uploadMultiple: true,
  parallelUploads: 15,
  maxFiles: 15,
  addRemoveLinks: true,

  // The setting up of the dropzone
  init: function() {
    var myDropzone = this;

    // Botón para procesar
    document.querySelector("#btnProcesar").addEventListener("click", function(e) {
      e.preventDefault();
      e.stopPropagation();
      myDropzone.processQueue();
    });

    // Botón para cancelar y limpiar
    document.querySelector("#btnCancelarLimpiar").addEventListener("click", function(e) {
      myDropzone.removeAllFiles(true); // Limpiar los archivos seleccionados
      myModalArchivos.hide();
    });

    // Cerrar modal
    window.addEventListener('click', function(event) {
        var modal = document.getElementById('modalArchivos');
        if (event.target == modal) {
            // Limpiar los archivos seleccionados
            myDropzone.removeAllFiles(true);
            myModalArchivos.hide();
        }
    });

    // Escuchar clic en el botón de cerrar del modal
    document.querySelector(".btn-close").addEventListener("click", function(e) {
        // Limpiar los archivos seleccionados
        myDropzone.removeAllFiles(true);
        myModalArchivos.hide();
    });

    this.on("successmultiple", function(files, response) {
      setTimeout(() => {
        window.location.reload(); // Recargar la página después de la carga exitosa
      }, 1500);
    });
  }
}
//Fin dropzone

function compartirArchivo(id) {
  const http = new XMLHttpRequest();
  const url = base_url + "archivos/buscarCarpeta/" + id;
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      //console.log(this.responseText);  
      id_carpeta.value = res.id_carpeta;
      content_acordeon.classList.add('d-none');
      container_archivos.innerHTML = `<input type="hidden" value="${res.id}" name="archivos[]">`
      myModalUser.show();
    }
  };
  //container_archivos.innerHTML = "";
}

function verArchivos() {
  const http = new XMLHttpRequest();
  const url = base_url + "archivos/verArchivos/" + id_carpeta.value;
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      
      if (res.length > 0) {
        content_acordeon.classList.remove('d-none');
        
        // Casilla de verificación "Seleccionar todos"
        html += `<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="seleccionarTodosCheckbox">
                    <label class="form-check-label" for="seleccionarTodosCheckbox">
                        SELECCIONAR TODOS 
                    </label>
                </div>`;
        
        res.forEach((archivo) => {
          html += `<div class="form-check">
              <input class="form-check-input" type="checkbox" value="${archivo.id}" name="archivos[]" id="flexCheckDefault_${archivo.id}">
              <label class="form-check-label" for="flexCheckDefault_${archivo.id}">
                  ${archivo.nombre}
              </label>
          </div>`;
        });
        //cargarDetalle(id_carpeta.value);
      } else {
        html += `<div class="alert alert-custom alert-indicator-right indicator-warning" role="alert">
            <div class="alert-content">
                <span class="alert-title">Alerta</span>
                <span class="alert-text">¡Esta carpeta se encuentra vacía!</span>
            </div>
        </div>`;
      }
      container_archivos.innerHTML = html;
      myModalCompartir.hide();
      myModalUser.show();

      // Evento para seleccionar todos los archivos
      document.getElementById('seleccionarTodosCheckbox').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.form-check-input');
        checkboxes.forEach((checkbox) => {
          checkbox.checked = this.checked;
        });
      });
    }
  };
}


