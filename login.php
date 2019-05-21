<?php
session_start();
if(@$_SESSION['user'] == "logged") {
    header('Location: index.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Login Page</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- This -->
    <link rel="stylesheet" href="dist/this/login.css">
</head>
<body class="login-body">
    
    <!-- Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 login-box bg-white">
                <div class="title text-body">Login</div>
                <div class="form-login">
                    <div class="alert alert-danger hidden" id="alert" role="alert"><b></b></div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="email" id="email" placeholder="Email address">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <button class="btn btn-lg btn-block btn-primary" id="btn-login">LOGIN</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Content -->

<!-- jQuery -->
<script src="dist/jQuery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="dist/Bootstrap/js/bootstrap.min.js"></script>
<!-- This -->
<script type="text/javascript" src="dist/this/login.js"></script>
<script>
</script>
</body>
</html>
<?php
}
?>