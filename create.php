<?php 
    session_start();
    include "authentication.php";
    include "config.php";

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $sex = $_POST['sex'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $photo = $_FILES['photo'];
        $photo_name = $photo['name'];
        $photo_temp = $photo['tmp_name'];

        move_uploaded_file($photo_temp,'uploads/'.$photo_name);

        if(empty($photo_name)){
            $sql = "INSERT INTO users (name,sex,phone,email,image) VALUES ('$name','$sex','$phone','$email','avatar.png')";
        }else{
            $sql = "INSERT INTO users (name,sex,phone,email,image) VALUES ('$name','$sex','$phone','$email','$photo_name')";
        }
        $query = mysqli_query($link,$sql);
        if($query){
            $log = getHostByName($_SERVER['HTTP_HOST']).' - '.date("F j, Y, g:i a").PHP_EOL.
            "Record created_".time().PHP_EOL.
            "---------------------------------------".PHP_EOL;
            file_put_contents('logs/log_'.date("j-n-Y").'.log', $log, FILE_APPEND);

            $_SESSION['success'] = "Usuario agregado satisfactoriamente";
            header('location:index.php');
        }else{
            $_SESSION['error'] = "Algo salió mal, usuario no registrado";
            header('location:index.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Agregar Usuario</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name"><strong>Nombre</strong></label>
                <input type="text" class="form-control" placeholder="Enter fullname" name="name" required>
            </div>
            <div class="form-group">
                <label for="email"><strong>Sexo</strong></label><br>
                <input type="radio" name="sex" value="male"> Masculino &nbsp;
                <input type="radio" name="sex" value="female"> Femenino
            </div>
            <div class="form-group">
                <label for="phone"><strong>Telefono</strong></label>
                <input type="text" class="form-control" placeholder="Enter phone number" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email"><strong>Email</strong></label>
                <input type="email" class="form-control" placeholder="Enter email" name="email" required>
            </div>
            <div class="form-group">
                <label for="photo"><strong>Foto</strong></label><br>
                <input type="file" name="photo">
            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary" name="submit">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>