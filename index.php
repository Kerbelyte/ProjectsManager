<?php
ob_start();

include "bootstrap.php";


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjectManager</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <header>
        <h1>Projects Manager system</h1>
        <div class="switch">
            <a class="<?= (empty($_GET['path']) || $_GET['path'] == 'projects') ? 'active' : ''; ?>" href="index.php?path=projects">Projects</a>
            <a class="<?= ($_GET['path'] == 'employees') ? 'active' : ''; ?>" href="index.php?path=employees">Employees</a>
        </div>
    </header>

    <div class="container">
        <?php

        $path = !empty($_GET['path']) ? $_GET['path'] : '';
        switch ($path) {
            case 'employees_form':
                include 'src/employees/form.php';
                break;
            case 'employees':
                include 'src/employees/table.php';
                break;
            case 'projects_form':
                include 'src/projects/form.php';
                break;
            default:
                include 'src/projects/table.php';
        }
        ?>

    </div>
    <footer class="footer">
        <p class="one">Copyright @2021 <a style="color:white;" href="https://linkedin.com/in/dovilė-kerbelytė-66634a162">Dovile</a></p>
        <p class="two">Designed by <a style="color:white;" href="https://linkedin.com/in/dovilė-kerbelytė-66634a162">By Myself</a></p>
        <div class="clear"></div>

    </footer>

</body>

</html>

<?php
ob_end_flush();
?>