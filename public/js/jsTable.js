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
            "serverSide": true,
            "ajax": {
                "url": "/peticion",
                "type": "GET",
                'data': function (d) {

                    // AQUI PODEMOS MANIPULAR LOS PARAMETROS QUE PASAMOS EN EL GET, EN ESTE CASO PASAMOS EL FILTER
                    return {
                        "filter[tipo]": $('#filter_tipo').val(),
                        "filter[codigo]": $('#filter_codigo').val(),
                        "filter[administrador]": $('#filter_admin').val(),
                        "filter[start]": d.start,
                        "filter[count]": d.length
                    };
                }
            },
            "info": true,
            "paging": true,
            "processing": true,
            "displayStart": 0,
            "lengthMenu": [2, 3, 4, 5], // las opciones count que quieras poner
            "pageLength": 2,
            "pagingType": "full_numbers",
            "rowId": "id",
            "columns": [
                {"data": "id"},
                {"data": "nombre"},
                {"data": "adress"},
                {"data": "phone"},
                {"data": "mail"},
                {    data: 'admin',
                    render: function ( data, type, row ) {
                        return "<small>"+data.nombre +"<scan style='color:green'> - Cat."+ data.categoria+"</scan></small>";
                    }},
                {data: 'tipo',
                    render: function ( data, type, row ) {
                        return "<small>"+data.nombre +" <scan style='color: green'>- Cod."+ data.codigo+"</scan></small>";
                    }},
                {
                    "render": function (data, type, row) {

                        console.log(type)
                        var html = '';
                        html = "<a href='/pagina3/" + row.id + "'><button class='btn btn-danger'>Borrar</button></a>" + "" +
                            "<a href='/pagina4/" + row.id + "'><button class='btn btn-warning'>Editar</button></a>";
                        return html;
                    }
                }
            ]
        },
    );
    $('#peti').click(function (){
            table.ajax.reload();
    })


    $('#listAdmin').DataTable();
    $('tr[data-href]').on("click", function () {
        document.location = $(this).data('href');
    });

});
