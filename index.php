<?php 
    session_start();
    include "authentication.php";
    include "config.php";

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 3;
    $offset = ($page-1)*$limit;
    $sql = "SELECT * FROM users LIMIT $limit OFFSET $offset";
    $query = mysqli_query($link,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD ADMIN</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <style>
        .fas{
            font-size: 20px;
        }
        .fa-edit:hover{
            color: green;
        }
        .fa-trash:hover{
            color: red;
        }
    </style>
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <nav class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Sistema de usuarios <sup></sup></div>
            </a>

                  <!-- Divider -->
              <hr class="sidebar-divider my-0">
        <!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="location:index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>
            <?php echo isset($_SESSION['id']) ? 'Bienvenido '.$_SESSION['name'] : '' ?> 
        
        </span></a>
</li>

     <!--p class="nav-item text-white">
            <?php echo isset($_SESSION['login_at']) ? 'Hora de inicio de sesión: '.$_SESSION['login_at'] : '' ?> | &nbsp;&nbsp;
        </p>
        <p class="float-right">
            <a href="logout.php" class="btn btn-danger"><i class='fas fa-sign-out-alt'></i> Cerrar sesión</a>
        </p-->
               <!-- Divider -->
               <hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item ">
    <a class="nav-link" href="location:index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Inicio</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">


<!-- Nav Item - Dashboard -->
<li class="nav-item ">
    <a class="nav-link" href="create.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Agregar usuario</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">



    </nav>

    <div class="container">
        
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <h1 class="text-center">Lista de usuarios</h1>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><p class="navbar-brand">
            <?php echo isset($_SESSION['id']) ? ' '.$_SESSION['name'] : '' ?> 
        </p></span>
                                
                             
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                               
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Hora de incio de sesion: 
                                    <p class="nav-item text-black">
            <?php echo isset($_SESSION['login_at']) ? ' '.$_SESSION['login_at'] : '' ?>  &nbsp;&nbsp;
        </p>
                                </a>
                             
                                <div class="dropdown-divider"></div>
                                <p >
            <a href="logout.php" class="dropdown-item"><i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i> Cerrar sesión</a>
        </p>
                            </div>
                        </li>

                    </ul>

                </nav>
        
     

        <!--div class="text-right"><a href="create.php" class="btn btn-success mb-2"><i class='fas fa-plus'></i> Agregar usuario</a></div-->

        <?php if(isset($_SESSION['success'])){ ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>
        <?php if(isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>
        <?php if(isset($_SESSION['warning'])){ ?>
            <div class="alert alert-warning"><?php echo $_SESSION['warning']; unset($_SESSION['warning']); ?></div>
        <?php } ?>

        <table class="table table-bordered table-striped table-hover">
            <thead class="bg-light text-center text-gray">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if(mysqli_num_rows($query) == 0){ ?>
                    <tr><td colspan="7" class="text-center">No record found</td></tr>
                <?php }else{ 
                    $psql = "SELECT * FROM users";
                    $pquery = mysqli_query($link,$psql);
                    $total_record = mysqli_num_rows($pquery);
                    $total_page = ceil($total_record/$limit);
                    ?>
                    <?php while($row = mysqli_fetch_assoc($query)){ ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td>
                            <?php if($row['sex'] == 'male'){ ?>
                                <i class='fas fa-male'></i> Male
                            <?php } ?>
                            <?php if($row['sex'] == 'female'){ ?>
                                <i class='fas fa-female'></i> Female
                            <?php } ?>
                        </td>
                        <td><?php echo $row['phone'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><img src="uploads/<?php echo $row['image'] ?>" width="100" height="125"></td>
                        <td>
                            <a href="update.php?id=<?php echo $row['id'] ?>" class="text-dark"><i class='fas fa-edit'></i></a>&nbsp;&nbsp;
                            <a href="delete.php?id=<?php echo $row['id'] ?>" class="text-dark"><i class='fas fa-trash'></i></a>
                        </td>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
        <ul class="pagination">
            <li class="page-item <?php echo ($page > 1) ? '' : 'disabled' ?>"><a class="page-link" href="index.php?page=<?php echo $page-1 ?>">Previous</a></li>
        <?php for($i=1;$i<=$total_page;$i++){ ?>
            <li class="page-item <?php echo ($page == $i) ? 'active' : '' ?>"><a class="page-link" href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
        <?php } ?>
            <li class="page-item <?php echo ($total_page > $page) ? '' : 'disabled' ?>"><a class="page-link" href="index.php?page=<?php echo $page+1 ?>">Next</a></li>
        </ul>
    </div>
</body>
</html>