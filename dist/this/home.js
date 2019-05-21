$(document).ready(function() {
    $.ajax({
        dataType: "JSON",
        type : 'GET',
        url: 'process/get_status.php',
        data: {id_user:$("#id_user").attr('id_user')},
        success: function(data) {
                $("#total_manga").html(data['total']);
                $("#update_today").html(data['update']);
                $("#not_read").html(data['not_read']);
        },
        error: function(data) {

        }
    });
});