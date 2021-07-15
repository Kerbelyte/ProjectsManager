<?php

// DELETE LOGIC
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if ($id > 0) {
        $delete = 'DELETE FROM projects_employees WHERE id_employees = ?';
        $stmt = $conn->prepare($delete);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $delete = 'DELETE FROM employees WHERE id = ?';
        $stmt = $conn->prepare($delete);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    header('Location: /ProjectsManager/index.php?path=employees');
    exit;
}

// ADD NEW LOGIC
if (isset($_POST['add_employee'])) {
    if (empty($_POST['name'])) {
        echo '<div style="color: red">Please enter employee name</div>';
    } else {
        $stmt = $conn->prepare('INSERT INTO employees (name) VALUES (?)');
        $name = $_POST['name'];
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->close();
        header('Location: /ProjectsManager/index.php?path=employees');
        exit;
    }
}

$sql = "SELECT employees.id as employees_id, employees.name as employees_name, GROUP_CONCAT(' ', projects.name) as names
FROM employees
LEFT JOIN projects_employees ON projects_employees.id_employees = employees.id
LEFT JOIN projects ON projects.id = projects_employees.id_projects
GROUP BY employees.id";

$result = mysqli_query($conn, $sql);
echo '<table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>PROJECT</th>
                <th>ACTIONS</th>
            </tr>
        </thead>';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td style=\"width:10%\">{$row["employees_id"]}</td>
            <td style=\"width:30%\">{$row["employees_name"]}</td>
            <td style=\"width:30%\">{$row["names"]}</td>
            <td style=\"width:30%\">
                <a class=\"delete\" href=\"index.php?path=employees&delete=${row["employees_id"]}\">
                    <i class=\"fa fa-trash\"></i>
                </a>
                <a class=\"update\" href=\"index.php?path=employees_form&id=${row["employees_id"]}\">
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
<form class="employees-form" method="POST">
    <label class="employee-name" for="name" style="font-size: 16px; color: grey">Employee name:</label><br>
    <input type="text" name="name" placeholder="Add employee name"><br>
    <input style="margin-left: 10px;" type="submit" name="add_employee" value="Add">
</form>