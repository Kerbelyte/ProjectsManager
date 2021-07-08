<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjectManager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
<header>
    <h1 style="text-align: center; color: black">Projects Manager system</h1>
        <div class="container">
            <a href="?path=projects">Projects</a><br>
            <a href="?path=employees">Employees</a>
        </div>
    </header>

    <div class="container">
        <?php
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'projects';
        $table = 'projects';
        $title = strtoupper($_GET['path']);
        $allowedPaths = array('projects', 'employees');

        if(isset($_GET['path']) and (in_array($_GET['path'], $allowedPaths))) {
                $table = $_GET['path'];
        } 

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if(!isset($_GET['path']) or $_GET['path'] == 'projects') {
        $sql = "SELECT projects.id as projects_id, projects.name as projects_name, GROUP_CONCAT(' ', employees.name) as names
        FROM projects
        LEFT JOIN projects_employees ON projects_employees.id_projects = projects.id
        LEFT JOIN employees ON employees.id = projects_employees.id_employees
        GROUP BY projects.id";
        } else { 
            $sql = "SELECT employees.id as employees_id, employees.name as employees_name, GROUP_CONCAT(' ', projects.name) as names
            FROM employees
            LEFT JOIN projects_employees ON projects_employees.id_employees = employees.id
            LEFT JOIN projects ON projects.id = projects_employees.id_projects
            GROUP BY employees.id";}

        $result = mysqli_query($conn, $sql);
        echo '<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>' . $title . '</th>
                    </tr>
                </thead>';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row["$table" ."_id"]}</td>
                    <td>{$row["$table" ."_name"]}</td>
                    <td>{$row["names"]}</td>
                  </tr>";
            }
        } else {
            echo "0 results";
        }
        echo("</table>");

        mysqli_close($conn);
        ?>
    </div>
</body>

</html>