var Permissions = (function () {
    var handleTables = function () {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#trashgridlist').DataTable({
        responsive: true,
        language: {
          'url': '//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json'
        },
        processing: true,
        serverSide: true,
        ajax: "/admin/permissions_datagrid_trash",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'description', name: 'description' },
            { data: 'deleted_at', name: 'deleted_at', render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss', 'DD/MM/YYYY HH:mm:ss')},
            { data: 'updated_at', name: 'updated_at', render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss', 'DD/MM/YYYY HH:mm:ss')},
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        initComplete: function () {
            this.api().columns([0,1,2]).every( function () {
                var column = this;
                var select = $('<br/><select><option value=""></option></select>')
                    .appendTo( $(column.header()) )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
      });
    }
    var deleteItem = function(){
        $('#trashgridlist').on('click', '.btn-delete[data-remote]', function (e) {
        e.preventDefault();
            var url = $(this).data('remote');
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            document.getElementById('tk_'+id).value = token;
            Swal.fire({
                title: 'Deseja excluir permanentemente esse registro?',
                html: "<h5>Por favor, clique sim para confirmar ou não para cancelar.</h5>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                buttonsStyling: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById(id).submit()
                }
            });
        });
    }
    return {
        // main function to initiate the module
        init: function () {
          handleTables()
          deleteItem()
        }
    }
})()
jQuery(document).ready(function () {
  Permissions.init()
})
