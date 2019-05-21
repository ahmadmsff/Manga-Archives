$(document).ready( function () {
    $('#customer').select2();
    $( "#barcode" ).autocomplete({
        source: function (request, response) {
            $.ajax({
                dataType: "JSON",
                type : 'GET',
                url: 'process/list_barang.php',
                data: {key:$("#barcode").val()},
                success: function(data) {
                    response(data);
                },
                error: function(data) {

                }
            });
        },
        minLength : 3,
        focus: function(event, ui) {
            $("#barcode").val(ui.item.value);
            $("#barang").val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
            $("#barcode").val(ui.item.value);
            $("#barang").val(ui.item.label);
            $("#barcode").attr("harga", ui.item.harga);
            return false;
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $( "<li>" )
        .append( "<div>" + item.label + " - " + item.value + "</div>" )
        .appendTo( ul );
    };

    $("#customer").on('change', function() {
        if ($("#customer").val() == 0) {
            $("#member").attr("disabled", "disabled");
            $("#member").val("");
        } else {
            $("#member").prop("disabled", true);
            $("#member").removeAttr("disabled");
        }
    });

    $("#btn-cart").click(function (){
        var id_penjualan = $("#inv").html();
        var id_barang = $("#barcode").val();
        var id_karyawan = $("#kasir").attr("id_karyawan");
        var id_pelanggan = $("#member").val();
        var qty = $("#qty").val();
        var total = $("#qty").val() * $("#barcode").attr("harga");
        if (id_barang == "") {
            alert("id barang kosong");
        } else {
            $.ajax({
                dataType: "JSON",
                type : 'POST',
                url: 'process/add_cart.php',
                data: {
                    id_penjualan: id_penjualan,
                    id_barang: id_barang,
                    id_karyawan: id_karyawan,
                    id_pelanggan: id_pelanggan,
                    qty: qty,
                    total: total,
                    },
                success: function(response) {
                    if ($(".table-content").length) {
                        $(".table-content").remove();
                        if (!$(".table-content").length) {
                        load_table();
                        $("#barcode").val("");
                        $("#barang").val("");
                        $("#barcode").prop("harga", true);
                        $("#barcode").removeAttr("harga");
                        }
                    } else {
                        load_table();
                        $("#barcode").val("");
                        $("#barang").val("");
                        $("#barcode").prop("harga", true);
                        $("#barcode").removeAttr("harga");
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
    });

    $("#btn-batal").click(function () {
        var id_penjualan = $("#inv").html();
        $.ajax({
                dataType: "JSON",
                type : 'POST',
                url: 'process/delete_cart.php',
                data: {
                    id_penjualan: id_penjualan
                    },
                success: function(response) {
                    if(response == "sukses") {
                    if ($(".table-content").length) {
                        $(".table-content").remove();
                        if (!$(".table-content").length) {
                        $("#barcode").val("");
                        $("#barang").val("");
                        $("#barcode").prop("harga", true);
                        $("#barcode").removeAttr("harga");
                        $("#display-harga").val("Rp0");
                        }
                    } else {
                        load_table();
                        $("#barcode").val("");
                        $("#barang").val("");
                        $("#barcode").prop("harga", true);
                        $("#barcode").removeAttr("harga");
                        $("#display-harga").val("Rp0");
                    }
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
    })

    function load_table() {
        $.ajax({
                dataType: "JSON",
                type : 'GET',
                url: 'process/get_cart.php',
                data: {
                    id_penjualan: $("#inv").html(),
                    },
                success: function(response) {
                    $("#table-cart tbody").html("");
                    $("#table-cart tbody").html(response);
                    var sum = 0;
                    $(".subtotal").each(function() {
                        var first = $(this).text().replace("Rp", "");
                        var value = first.replace(/\./g,'');
                        if(value.length != 0) {
                            sum += parseFloat(value);
                        }
                    });
                    $("#display-harga").val("Rp"+formatRupiah(sum));
                },
                error: function(response) {
                    console.log(response);
                }
            });
    }
    function formatRupiah(nilai){
        var	number_string = nilai.toString(),
            sisa 	= number_string.length % 3,
            rupiah 	= number_string.substr(0, sisa),
            ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    }
});