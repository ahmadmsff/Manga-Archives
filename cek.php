<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checking Manga..</title>
    <style>
        body {
            overflow-x:visible;
            overflow-y: scroll;
        }
        h3 {
            text-align:center;
        }
        .update {
            color: green;
        }
        .no-update {
            color: grey;
        }
        #audio {
            display: none;
        }
    </style>
</head>
<body>
    <audio controls id="audio">
        <source src="assets/sound/notif.mp3" type="audio/mpeg">
    </audio>
    <h3>Checking update started</h3>
    
    
<!-- jQuery 3 -->
<script src="dist/jQuery/jquery.min.js"></script>
<script>
$(document).ready(function(){
    function play() {
        var audio = document.getElementById("audio");
        audio.play();
    }
    $.ajax({
        type : 'GET',
        url: 'process/get_id.php',
        dataType: "JSON",
        success: function(result) {
            var counter = 0;
            var num = 0;
            var all = result.length;
            var i = setInterval(function(){
                
                $.ajax({
                    type : 'GET',
                    url: 'process/update.php',
                    dataType: "JSON",
                    data: {id_manga: result[counter]},
                    success: function(data) {
                        num++;
                        document.title = "[" + num + " of " + all +"]";
                        $("body").append("[" + num + " of " + all +"]" + data.result + "<br>");
                        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
                        if(data.status == "update") {
                            play();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });

                counter++;
                if(counter === result.length) {
                    clearInterval(i);
                    $("body").append("<h3>Checking update finished</h3>");
                }
            }, 2000);
        },
        error: function(result) {
            console.log(result);
        }
    });
});
</script>
</body>
</html>