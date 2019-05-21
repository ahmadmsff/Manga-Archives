$(document).ready( function () {

    $("#table-kategori").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "process/get_kategori.php",
            "type": "POST"
        },
        "columns": [
            { "data": "id",
              "className": "text-center"},
            { "data": "name"},
            { "data": "id",
              "className": "text-center",
              "render": function(data, type, row) {
                return '<button class="btn btn-xs btn-danger" id_kategori="'+ data +'"><i class="fas fa-trash"/></button>';
              }
            }
        ]
    });

    $("#btn_simpan").click(function () {
      Swal.fire({
        title: 'Anda ingin menambah data?',
        text: "Anda yakin data yang diinputkan sudah benar?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.value) {
          var name = $("#nama_kategori").val();
          $.ajax({
              url: "process/add_kategori.php",
              type: "POST",
              data:  {'nama_kategori':name},
              dataType: "JSON",
              success: function(response)
                {
                  if(response == 'sukses') {
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    ).then((result) => {
                      if (result.value) {
                        location.reload();
                      } else {
                        location.reload();
                      }
                    })
                  }
                  console.log(response);
                },
                error: function() 
              {
            } 	        
          });
        }
      })
    });
} );