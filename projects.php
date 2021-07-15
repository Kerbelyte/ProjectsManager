<?php

// DELETE LOGIC

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if ($id > 0) {
        $delete = 'DELETE FROM projects_employees WHERE id_projects = ?';
        $stmt = $conn->prepare($delete);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $delete = 'DELETE FROM projects WHERE id = ?';
        $stmt = $conn->prepare($delete);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    header('Location: /ProjectsManager/index.php?path=projects');
    exit;
}

// ADD NEW LOGIC

if (isset($_POST['add_project'])) {
    if (empty($_POST['project_name'])) {
        echo '<div style="color: red">Please enter project name</div>';
    } else {
        $sql = "SELECT name FROM projects WHERE name = ?";
        $name = $_POST['project_name'];
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($nameFromDB);
        $stmt->fetch();
        $stmt->close();
        if ($nameFromDB === null) {
            $stmt = $conn->prepare('INSERT INTO projects (name) VALUES (?)');
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->close();

            if ($_POST['emloyee_id'] != 0) {
                $projectID = $conn->insert_id;
                $stmt = $conn->prepare('INSERT INTO projects_employees (id_projects, id_employees) VALUES (?, ?)');
                $employeeID = $_POST['emloyee_id'];
                $stmt->bind_param('ii', $projectID, $employeeID);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            echo '<div style="color: red">The Project name already exists!</div>';
        }
    }
}

$sql = "SELECT projects.id as projects_id, projects.name as projects_name, GROUP_CONCAT(' ', employees.name) as names
            FROM projects
            LEFT JOIN projects_employees ON projects_employees.id_projects = projects.id
            LEFT JOIN employees ON employees.id = projects_employees.id_employees
            GROUP BY projects.id";

$result = mysqli_query($conn, $sql);
echo '<table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMPLOYEES</th>
                <th>ACTIONS</th>
            </tr>
        </thead>';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td style=\"width:10%\">{$row["projects_id"]}</td>
            <td style=\"width:30%\">{$row["projects_name"]}</td>
            <td style=\"width:30%\">{$row["names"]}</td>
            <td style=\"width:30%\">
                <a class=\"delete\" href=\"index.php?path=projects&delete=${row["projects_id"]}\">
                    <i class=\"fa fa-trash\"></i>
                </a>
                <a class=\"update\" href=\"index.php?path=projects_form&id=${row["projects_id"]}\">
                <i class=\"far fa-edit\"></i>
                </a>
            </td>
          </tr>";
    }
} else {
    echo '0 results';
}
echo '</table>';


?>

<form method="POST">
    <label for="name" style="font-size: 16px; color: grey">Add new project:</label>
    <input class="project-name" type="text" id="name" name="project_name" value="" placeholder="Project name">
    <label class="employee-name" for="name" style="font-size: 16px; color: grey">Employee name:</label>
    <select name="emloyee_id">
        <option value=0></option>
        <?php
        $sql = "SELECT id, name FROM employees";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value={$row["id"]}>{$row["name"]}</option>";
        }
        ?>

    </select>
    <input style="margin-left: 10px;" type="submit" name="add_project" value="Add">
</form>