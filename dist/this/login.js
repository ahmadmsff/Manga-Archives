
$(document).ready(function() {
    $("#btn-login").click(function(){
        login();
    });

    $('#email').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            login();
        }
    });

    $('#password').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            login();
        }
    });

    function login() {
        var email = $("#email").val();
        var pass = $("#password").val();
        if (email == "") {
            $("#alert").removeClass("hidden");
            $("#alert").html("Email tidak boleh kosong");
            $("#email").focus();
            $
        } else if (pass == "") {
            $("#alert").removeClass("hidden");
            $("#alert").html("Password tidak boleh kosong");
            $("#password").focus();
        } else {
            $("#alert").addClass("hidden");
            $.ajax({
                url: 'process/login.php',
                type: 'POST',
                dataType: 'JSON',
                data: {email: email, pass: pass},
                success: function(response) {
                  if(response == "found") {
                      window.location.href = "index.php";
                  } else {
                    $("#alert").removeClass("hidden");
                    $("#alert").html("Email atau password salah");
                  }
                }
            });
        }
    }
});