
let = tblArchivosDeleted;

document.addEventListener("DOMContentLoaded", function () {
  //Cargar datos con DataTable
  tblArchivosDeleted = $("#tblArchivosDeleted").DataTable({
    ajax: {
      url: base_url + "archivos/listarHistorial/",
      dataSrc: "",
    },
    columns: [
      { data: "accion" },
      { data: "id" },
      { data: "nombre" },
      { data: "tipo" },
      { data: "fecha_create" },
      { data: "fecha_eliminacion" }
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
    },
    responsive: true,
    order: [[1, "desc"]],
  });
});

function restaurar(id) {
    const url = base_url + "archivos/delete/" + id;
    eliminarRegistro(
      "¿ESTÁS SEGURO DE RESTAURAR?",
      "Podrás encontrar el archivo en el mismo directorio.",
      "Si, restaurar",
      url,
      tblArchivosDeleted
    );
  }


