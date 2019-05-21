
function showmanga(id) {
    $.ajax({
        type : 'GET',
        url: 'process/get_manga.php',
        data: {id_manga:id, id_user:$("#id_user").attr("id_user")},
        success: function(data) {
            $("#loading-modal").addClass("hidden");
            $("#modal-detail").html(data);
        },
        error: function(data) {
            console.log(data);
        }
    });
};

function downloadManga(data) {
    var chapter = data;
    var id_manga = $("#down-" + data).attr("id_manga");
    var source = $("#down-" + data).attr("source");
    var id_user = $("#id_user").attr("id_user");
    $("#btnLoad-" + data ).removeClass("hidden");
    $("#down-" + data).addClass("hidden");
    $.ajax({
        dataType: "JSON",
        type : 'GET',
        url: 'process/download.php',
        data: {url:source, id_manga:id_manga, chapter:chapter, id_user:id_user},
        success: function(response) {
            if(response.status == "sukses") {
                $("#btnLoad-" + data ).addClass("hidden");
                $("#view-" + data ).removeClass("hidden");
                toastr["success"]("Chapter " + data, "Download successfully");
            } else {
                toastr["error"]("Chapter " + data, response.msg);
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
};

$(document).ready(function() {

    load_data();

    function load_data() {
        $("#btn-load-more").html("<i class=\"fas fa-spinner fa-pulse\"><\/i>");
        $.ajax({
            dataType: "JSON",
            type : 'GET',
            url: 'process/list_manga.php',
            data: {id_user:$("#id_user").attr('id_user'), page:$("#btn-load-more").attr('page')},
            success: function(data) {
                $("#btn-load-more").html("LOAD MORE");
                if (data.result.length > 0) {
                    var i;
                    for (i = 0; i< data.result.length; i++) {
                        var manga = data.result[i];
                        var id = manga.id_manga;
                        var type = manga.type;
                        var chapter = Math.trunc(parseFloat(manga.chapter));
                        var not_read = manga.not_read;
                        var new_chapter = not_read;
                        var title = manga.title;
                        var thumbnail = manga.thumbnail;
                        var read_date = manga.read_date;
                        var page = data.page + 1;
                        var total_page = data.total_page;
                        var result = "";
                        result += "<div class=\"manga-card\" onclick=\"showmanga(" +id+ ")\" data-toggle=\"modal\" data-target=\"#modalShowManga\">";
                        result += "<div class=\"img-manga\">";
                        result += "<img src=\"assets\/manga\/" + id + "\/" + thumbnail + "\" id=\"img-manga\">";
                        result += "<div class=\"text-type\">" + type + "<\/div>";
                        if (new_chapter != 0) {
                            result += "<div class=\"text-new-chapter\">" + new_chapter + "<\/div>";
                        }
                        result += "<\/div>";
                        result += "<div class=\"manga-title\">" + title + "<\/div>";
                        result += "<div class=\"manga-info\">";
                        if (chapter != 0) {
                        result += "<span id=\"last-chapter\">Ch." + chapter + "<\/span>";
                        }
                        result += "<span id=\"last-read\" class=\"pull-right\">" + read_date + "<\/span>";
                        result += "<\/div>";
                        result += "<\/div>";
                        if (page-1 == total_page) {
                            $("#btn-load-more").addClass("hidden");
                        } else {
                            $("#btn-load-more").attr('page', page);
                        }
                        $(".manga-list").append(result);
                    }
                } else {
                    $(".manga-list").append("<h3>No data</h3>");
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function search(key) {
        $(".manga-list").html("");
        $("#btn-load-more").html("<i class=\"fas fa-spinner fa-pulse\"><\/i>");
        $.ajax({
            dataType: "JSON",
            type : 'GET',
            url: 'process/list_manga.php',
            data: {id_user:$("#id_user").attr('id_user'), key:key},
            success: function(data) {
                $("#btn-load-more").html("LOAD MORE");
                console.log(data);
                if (data.result.length > 0) {
                    var i;
                    for (i = 0; i< data.result.length; i++) {
                        var manga = data.result[i];
                        var id = manga.id_manga;
                        var type = manga.type;
                        var chapter = Math.trunc(parseFloat(manga.chapter));
                        var not_read = manga.not_read;
                        var new_chapter = not_read;
                        var title = manga.title;
                        var thumbnail = manga.thumbnail;
                        var read_date = manga.read_date;
                        var page = data.page + 1;
                        var total_page = data.total_page;
                        var result = "";
                        result += "<div class=\"manga-card\" onclick=\"showmanga(" +id+ ")\" data-toggle=\"modal\" data-target=\"#modalShowManga\">";
                        result += "<div class=\"img-manga\">";
                        result += "<img src=\"assets\/manga\/" + id + "\/" + thumbnail + "\" id=\"img-manga\">";
                        result += "<div class=\"text-type\">" + type + "<\/div>";
                        if (new_chapter != 0) {
                            result += "<div class=\"text-new-chapter\">" + new_chapter + "<\/div>";
                        }
                        result += "<\/div>";
                        result += "<div class=\"manga-title\">" + title + "<\/div>";
                        result += "<div class=\"manga-info\">";
                        if (chapter != 0) {
                        result += "<span id=\"last-chapter\">Ch." + chapter + "<\/span>";
                        }
                        result += "<span id=\"last-read\" class=\"pull-right\">" + read_date + "<\/span>";
                        result += "<\/div>";
                        result += "<\/div>";
                        if (page-1 == total_page) {
                            $("#btn-load-more").addClass("hidden");
                        } else {
                            $("#btn-load-more").attr('page', page);
                        }
                        $(".manga-list").append(result);
                    }
                } else {
                    $(".manga-list").append("<h3>No data</h3>");
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    $("#search").keyup(function() {
        var key = $(this).val();
        if (key.length == 0) {
            window.location.reload();
        }
        else if (key.length > 2) {
            search(key);
        }
    });

    $("#btn-load-more").click(function() {
        load_data();
    });

    $('#btn_cek').click(function () {
        $('#btn_cek').addClass('hidden');
        $('#btn_loading').removeClass('hidden');

        $.ajax({
            dataType: "JSON",
            type : 'GET',
            url: 'process/cek_manga.php',
            data: {url:$("#link_manga").val()},
            success: function(data) {
                if (data['isExist'] == true) {
                    $('#btn_loading').addClass('hidden');
                    $('#btn_cek').removeClass('hidden');
                    Swal.fire(
                        'Manga Exist',
                        'Manga sudah terdaftar',
                        'error'
                      )
                } else {
                    $('.result_cek').removeClass('hidden');
                    $('#btn_loading').addClass('hidden');
                    $('#btn_simpan').removeClass('hidden');
                    $('#btn_batal').removeClass('hidden');
                    
                    $("#img").attr('src', data['result']['images']);
                    $("#judul_manga").html(data['result']['title']);
                    $("#native_title").html(data['result']['native']);
                    $("#genres").html(data['result']['genres'])
                    $("#release_date").html(data['result']['release_date'])
                    $("#type").html(data['result']['type'])
                    $("#status").html(data['result']['status'])
                    $("#author").html(data['result']['author'])
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $('#btn-show-batch').click(function () {
        $("#btn_batch").removeClass("hidden");
        $("#input_single").addClass("hidden");
        $("#link_batch").removeClass("hidden");
        $("#btn_cek").addClass("hidden");
    });

    $('#btn_batch').click(function () {
        $('#btn_batch').addClass('hidden');
        $('#btn_loading').removeClass('hidden');
        var array = $('#link_batch').val().split('\n');
        var i=0;

        function myLoop () {           //  create a loop function
            setTimeout(function () {    //  call a 3s setTimeout when the loop is called
                $.ajax({
                    dataType: "JSON",
                    type : 'GET',
                    url: 'process/add_manga.php',
                    data: {url:array[i], id_user:$("#id_user").attr('id_user')},
                    success: function(data) {
                        if (data.isExist == 'true') {
                            toastr["error"](data.msg, "Manga " + i + " from " + array.length + " exist");
                        } else {
                            if(data.result == 'sukses') {
                                toastr["success"](data.msg, "Manga " + i + " from " + array.length + " was added");
                            }
                        }
                    },
                    error: function(data) {
                        toastr["error"]("Manga "+ i + " from " + array.length + " " + data.responseText);
                        console.log(data);
                    }
                });
               i++;                     //  increment the counter
               if (i < array.length) {            //  if the counter < 10, call the loop function
                  myLoop();             //  ..  again which will trigger another 
               } else {
                Swal.fire({
                    type: 'success',
                    title: 'Manga berhasil ditambah',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK!'
                }).then((result) => {
                    if (result.value) {
                    location.reload();
                    } else {
                    location.reload();
                    }
                })
               }
            }, 3000)
         }
         
         myLoop()
    });

    $('#btn_batal').click(function () {
        $('.result_cek').addClass('hidden');
        $('#btn_batal').addClass('hidden');
        $('#btn_simpan').addClass('hidden');
        $('#btn_cek').removeClass('hidden');
    });
    $('#btn_simpan').click(function () {
        $('#btn_simpan').addClass('hidden');
        $('#btn_loading').removeClass('hidden');

        $.ajax({
            dataType: "JSON",
            type : 'GET',
            url: 'process/add_manga.php',
            data: {url:$("#link_manga").val(), id_user:$("#id_user").attr('id_user')},
            success: function(data) {
                if (data['isExist'] == 'true') {
                    $('#btn_loading').addClass('hidden');
                    $('#btn_simpan').removeClass('hidden');
                    Swal.fire(
                        'Manga Exist',
                        'Manga sudah terdaftar',
                        'error'
                      )
                } else {
                    if(data['result'] == 'sukses') {
                        Swal.fire({
                            type: 'success',
                            title: 'Manga berhasil ditambah',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK!'
                        }).then((result) => {
                            if (result.value) {
                            location.reload();
                            } else {
                            location.reload();
                            }
                        })
                    }
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
});