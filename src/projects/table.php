<?php

$projectsManager = new Projects\ProjectsManager($conn);
// DELETE LOGIC

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $projectsManager->delete($id);

    header('Location: index.php?path=projects');
    exit;
}

// CREATE LOGIC

if (isset($_POST['add_project'])) {
    if (empty($_POST['project_name'])) {
        echo '<div style="color: red">Please enter project name!</div>';
    } else {
        $projectsManager->create($_POST['project_name']);
    }
}

// READ LOGIC
echo '<table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMPLOYEES</th>
                <th>ACTIONS</th>
            </tr>
        </thead>';
  
$data = $projectsManager->read();
if (count($data) > 0) {
    foreach ($data as $row) {
        echo "<tr>
            <td style=\"width:10%\">{$row["projects_id"]}</td>
            <td style=\"width:30%\">{$row["projects_name"]}</td>
            <td style=\"width:30%\">{$row["names"]}</td>
            <td style=\"width:30%\">
                <a class=\"update\" href=\"index.php?path=projects_form&id=${row["projects_id"]}\">
                    <i class=\"far fa-edit\"></i>
                </a>
                <a class=\"delete\" href=\"index.php?path=projects&delete=${row["projects_id"]}\">
                    <i class=\"fa fa-trash\"></i>
                </a>
            </td>
          </tr>";
    }
} else {
    echo '0 results';
}
echo '</table>';

?>

<form class="projects-form" method="POST">
    <label for="name" style="font-size: 16px; color: grey;">Add new project:</label>
    <input style="margin-left: 5px; margin-right: 5%;" class="project-name" type="text" id="name" name="project_name" value="" placeholder="Project name">
    <label style="margin-right: 5px; font-size: 16px; color: grey;" class="employee-name" for="name">Employee name:</label>
    <select name="emloyee_id">
        <option value=0></option>
        <?php
        $employees = new Employees\EmployeesManager($conn);
        $employees = $employees->getEmplyees();

        foreach ($employees as $employee) {
            echo "<option value={$employee["id"]}>{$employee["name"]}</option>";
        }
        ?>

    </select>
    <input style="margin-left: 10px;" type="submit" name="add_project" value="Add">
</form>