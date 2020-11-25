$(document).ready(function(){
    $('#list').DataTable(
        {
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "_START_",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
             "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },"aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todo"]],
            "iDisplayLength": 5,
    },

    );

    $('#listAdmin').DataTable();
    $('tr[data-href]').on("click", function() {
        document.location = $(this).data('href');
    });

} );
