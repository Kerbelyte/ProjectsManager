<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjectManager</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <header>
        <h1>Projects Manager system</h1>
        <div class="switch">
            <a href="index.php?path=projects">Projects</a>
            <a href="index.php?path=employees">Employees</a>
        </div>
    </header>

    <div class="container">
        <?php
        include 'db.php';

        $path = !empty($_GET['path']) ? $_GET['path'] : '';
        switch ($path) {
            case 'employees_form':
                include 'employees_form.php';
                break;
            case 'employees':
                include 'employees.php';
                break;
            case 'projects_form':
                include 'projects_form.php';
                break;
            default:
                include 'projects.php';
        }

        $table = 'projects';
        $title = 'EMPLOYEES';
        $allowedPaths = array('projects', 'employees');

        if (isset($_GET['path'])) {
            if (in_array($_GET['path'], $allowedPaths)) {
                $table = $_GET['path'];
                $title = $_GET['path'] == 'projects' ? 'EMPLOYEES' : 'PROJECTS';
            } else {
                echo '<span style="color:red;margin:auto; display:table;"> ERROR 404!</span>';
                die();
            }
        }

        ?>

    </div>
    <footer class="footer">
        <div class="text-duo">
            <p class="one">Copyright @2021 <a href="https://linkedin.com/in/dovilė-kerbelytė-66634a162">Dovile</a></p>
            <p class="two">Designed by <a href="https://linkedin.com/in/dovilė-kerbelytė-66634a162">By Myself</a></p>
            <div class="clear"></div>
        </div>

    </footer>
</body>

</html>