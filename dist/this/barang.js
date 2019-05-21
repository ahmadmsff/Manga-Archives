$(document).ready( function () {
    $('#subkategori').select2();
    $('#kategori').select2();
    $('#ukuran').select2();

    $("#foto_barang").change(function(event) {
        var reader = new FileReader();
        reader.onload = function(){
        $("#img_barang").attr("src", reader.result);
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    $("#table-barang").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "process/get_barang.php",
            "type": "POST"
        },
        "columns": [
            { "data": "barcode",
              "className": "text-center"},
            { "data": "nama"},
            { "data": "harga",
              "className": "text-right"},
            { "data": "stock",
              "className": "text-center"},
            { "data": "barcode",
              "className": "text-center",
              "render": function(data, type, row) {
                return '<button class="btn btn-xs btn-danger" id_barang="'+ data +'"><i class="fas fa-trash"/></button>';
              }
            }
        ]
    });

    $("#form_tambah").submit(function (e) {
      e.preventDefault();
      $.ajax({
          url: "process/add_barang.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
              cache: false,
          processData:false,
          success: function(response)
            {
              if(response == '"sukses"') {
                location.reload();
              }
            },
            error: function() 
          {
        } 	        
      });
    });
} );