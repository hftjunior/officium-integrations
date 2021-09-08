var People = (function () {
    var handleTables = function () {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#gridlist').DataTable({
        responsive: true,
        language: {
          'url': '//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json'
        },
        processing: true,
        serverSide: true,
        ajax: "/person/people_datagrid",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'photo', name: 'photo', render: function(data, type, full, meta){ return '<img class="img-circle img-bordered-sm" src="'+data+'" width="40px" height="40px" />'; } },
            { data: 'name', name: 'name' },
            { data: 'cpfcnpj', name: 'cpfcnpj' },
            { data: 'type', name: 'type', render: function(data, type, full, meta){ return data == 'F' ? 'Física' : 'Jurídica'; } },
            { data: 'created_at', name: 'created_at', render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss', 'DD/MM/YYYY HH:mm:ss')},
            { data: 'updated_at', name: 'updated_at', render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss', 'DD/MM/YYYY HH:mm:ss')},
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        initComplete: function () {
            this.api().columns([0,2,3,4]).every( function () {
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
        $('#gridlist').on('click', '.btn-delete[data-remote]', function (e) {
        e.preventDefault();
            var url = $(this).data('remote');
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            document.getElementById('tk_'+id).value = token;
            Swal.fire({
                title: 'Deseja excluir esse registro?',
                html: '<h5>Por favor, clique sim para confirmar ou não para cancelar.</h5>',
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
    var selectMultiple = function(){
        $('.select2').select2();
    }
    var maskInput = function(){
        $('input[data-mask=cep]').inputmask({'mask':'99999-999'});
    }
    var avatar = function(){
        $(".profile-user-img").on('click', function() {
            $("#avatar").click();
         });
         $("#avatar").on('change', function(){
            readURL(this);
        });
    }
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.profile-user-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    var showfields = function(){
        $('input[name=type').change(
            function(e){
              e.preventDefault();
              var person = $(this).val();
              if(person == 'F'){
                $('input[name=cpfcnpj]').inputmask({'mask':'999.999.999-99'});
                return false;
              }else{
                $('input[name=cpfcnpj]').inputmask({'mask':'99.999.999/9999-99'});
                return false;
              }
            }
        );
    }
    return {
        // main function to initiate the module
        init: function () {
          handleTables()
          deleteItem()
          selectMultiple()
          avatar()
          showfields()
        }
    }
})()
jQuery(document).ready(function () {
  People.init()
})

function maskInput(e){
    var type = e.value;
    var index = e.dataset.index;
    if((type == 'C') || (type == 'R')){
      $('input[data-mask=phone'+index+']').inputmask({'mask':'(99) 9999-9999'});
      return false;
    }else{
      $('input[data-mask=phone'+index+']').inputmask({'mask':'(99) 9 9999-9999'});
      return false;
    }
}