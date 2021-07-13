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
        $msg = '<div style="color: red">Please enter a name</div>';
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
                <th>PROJECTS</th>
                <th style="padding-left: 60px;">ACTIONS</th>
            </tr>
        </thead>';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row["employees_id"]}</td>
            <td>{$row["employees_name"]}</td>
            <td>{$row["names"]}</td>
            <td>
                <a href=\"index.php?path=employees&delete=${row["employees_id"]}\">DELETE</a>
                <a href=\"employees_form.php?id=${row["employees_id"]}\">UPDATE</a>
            </td>
          </tr>";
    }
} else {
    echo '0 results';
}
echo '</table>';

mysqli_close($conn);

?>
<br>
<form method="POST">
    <label for="name" style="font-size: 16px; color: grey">Employee name:</label><br>
    <input type="text" name="name" placeholder="Add employee name"><br>
    <input type="submit" name="add_employee" value="Add">
</form>