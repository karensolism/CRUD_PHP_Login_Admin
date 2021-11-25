<?php 
    session_start();
    include "authentication.php";
    include "config.php";

    $id = $_GET['id'];

    if(isset($_SESSION['id'])){
        $sql = "SELECT image FROM users WHERE id='$id'";
        $query = mysqli_query($link,$sql);
        $arr = mysqli_fetch_assoc($query);

        $dsql = "DELETE FROM users WHERE id='$id'";
        $dquery = mysqli_query($link,$dsql);
        if($dquery){
            if($arr['image'] != 'avatar.png'){
                $image_path = 'uploads/'.$arr['image'];
                unlink($image_path);
            }
            $log = getHostByName($_SERVER['HTTP_HOST']).' - '.date("F j, Y, g:i a").PHP_EOL.
            "Record deleted_".time().PHP_EOL.
            "---------------------------------------".PHP_EOL;
            file_put_contents('logs/log_'.date("j-n-Y").'.log', $log, FILE_APPEND);

            $_SESSION['warning'] = "Usuario eliminado satisfactoriamente";
            header('location:index.php');
        }else{
            $_SESSION['error'] = "Algo salió mal, usuario no eliminado";
            header('location:index.php');
        }
    }else{
        $log = getHostByName($_SERVER['HTTP_HOST']).' - '.date("F j, Y, g:i a").PHP_EOL.
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $log = "User".rand().'_'.time().": ".getHostByName($_SERVER['HTTP_HOST']).' - '.date("F j, Y, g:i a").PHP_EOL.
        "Page trying to access: ".$url.PHP_EOL.
        "---------------------------------------".PHP_EOL;
        file_put_contents('logs/unauth_log_'.date("j-n-Y").'.log', $log, FILE_APPEND);
    }
?>