<?php 
    session_start();
    date_default_timezone_set("Asia/Kolkata");
    include "config.php";
    if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
        header('location:index.php');
    }
    
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $captcha_field = $_POST['captcha'];

        $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
        $query = mysqli_query($link,$sql);

        if(mysqli_num_rows($query) == 1){
            if($captcha_field == $_SESSION['captcha']){
                unset($_SESSION['captcha']);

                $log = getHostByName($_SERVER['HTTP_HOST']).' - '.date("F j, Y, g:i a").PHP_EOL.
                "Login_".time().PHP_EOL.
                "---------------------------------------".PHP_EOL;
                file_put_contents('logs/log_'.date("j-n-Y").'.log', $log, FILE_APPEND);

                if(isset($_POST['remember_me'])){
                    setcookie('username', $username, time()+24*60*60);
                    setcookie('password', $_POST['password'], time()+24*60*60);
                }else{
                    setcookie('username','');
                    setcookie('password','');
                }
                $data = mysqli_fetch_assoc($query);
                $_SESSION['id'] = $data['id'];
                $_SESSION['name'] = $data['name'];
                $_SESSION['timeout'] = time()+1800;
                $_SESSION['login_at'] = date('h:m:s a');
                sleep(1);
                header('location:index.php');
            }else{
                $_SESSION['error'] = 'Wrong captcha';
            }
        }else{
            $_SESSION['error'] = 'Username or Password maybe wrong';
        }
    }

    $captcha_array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    shuffle($captcha_array);
    $captcha_code = substr(implode('',$captcha_array),0,6);
    $_SESSION['captcha'] = $captcha_code;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Login</title>


    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
        #login
        {
            margin: 18% 30%;
            border: 1px solid lightgray;
            padding: 10px 20px 40px;
            box-shadow: 2px 5px 5px 2px lightgray;
        }
    </style>
</head>
<body class="bg-gradient-primary">
<div class="container">
      <!-- Outer Row -->
      <div  class="row justify-content-center">

<div id="login" class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Iniciar sesion</h1>
                        </div>
                        
                        <?php if(isset($_SESSION['error'])){ ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>
                        <form action="" method="POST" class="user">
                        
                        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class='fas fa-user'></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Usuario" id="username" name="username" value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : '' ?>" requied>
        </div>
                        
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class='fas fa-key'></i></span>
            </div>
            <input type="password" class="form-control" placeholder="Contraseña" id="password" name="password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : '' ?>" required>
            <div class="input-group-append">
                <button type="button" class="input-group-text" onclick="passwordToggle()" id="toggle-btn"><i class='far fa-eye-slash'></i></button>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text bg-dark text-white"><strong style="letter-spacing:2px"><?php echo $_SESSION['captcha'] ?></strong></span>
            </div>
            <input type="text" class="form-control" placeholder="Captcha" id="captcha" name="captcha" required>
        </div>
        <div class="text-right mb-4">
            <input  type="checkbox" id="remember_me" name="remember_me" <?php echo isset($_COOKIE['username']) || isset($_COOKIE['password']) ? 'checked' : '' ?>> Recuerdame
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block" name="login">Ingresar</button>
   
            
                        </form>
                        <hr>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

  <div >
      
   

</body>
</html>
<script type="text/javascript">
    //Password visibility
    function passwordToggle(){
        var btn = document.getElementById('toggle-btn');
        var pw = document.getElementById('password');

        if(pw.type == 'password'){
            pw.type = 'text'
            btn.innerHTML = "<i class='far fa-eye'></i>"
        }else{
            pw.type = 'password'
            btn.innerHTML = "<i class='far fa-eye-slash'></i>"
        }
    }

    //Error message hide
    setTimeout(function(){
        document.getElementsByClassName('alert')[0].style.display = 'none';
    }, 3000);
</script>