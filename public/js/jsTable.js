$(document).ready(function () {
    var table = $('#list').DataTable(
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
            },
            "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todo"]],
            "iDisplayLength": 5,
            "serverSide": true,
            "ajax": {
                "url": "/peticion",
                "type": "GET",
                'data': function (d) {
                    var tipo = $('#filter_tipo').val();
                    var codigo = $('#filter_codigo').val();
                    var admin = $('#filter_admin').val();
                    var datos = {
                        "filter[tipo]": tipo,
                        "filter[codigo]": codigo,
                        "filter[administrador]": admin,
                        "filter[start]": d.start,
                        "filter[count]": d.length
                    };
                    console.log(datos);
                    return datos;
                }
            },
            "info": true,
            "paging": true,
            "processing": true,
            "displayStart": 0,
            "lengthMenu": [10, 25, 50, 100], // las opciones count que quieras poner
            "pageLength": 2,
            "pagingType": "full_numbers",
            "rowId": "id",
            "columns":[
                {"data": "id"},
                {"data": "nombre"},
                {"data": "adress"},
                {"data": "phone"},
                {"data": "mail"},
                {"data": "admin.nombre"},
                {"data": "tipo.nombre"},
                {
                    "render": function (data, type, row) {
                        var html = '';
                        html = "<a href='/pagina3/"+row.id+"'><button class='btn btn-danger'>Borrar</button></a>"+"" +
                        "<a href='/pagina4/"+row.id+"'><button class='btn btn-warning'>Editar</button></a>";
                        return html;
                    }
                }
            ]
        },
    );


    $('#listAdmin').DataTable();
    $('tr[data-href]').on("click", function () {
        document.location = $(this).data('href');
    });

});
