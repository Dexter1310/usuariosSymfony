$(document).ready( function () {
    $('#list').DataTable();
    $('#listAdmin').DataTable();
    $('tr[data-href]').on("click", function() {
        document.location = $(this).data('href');
    });

} );
