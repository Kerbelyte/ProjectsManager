<?php

// DELETE LOGIC
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if ($id > 0) {
        $employeesManager->delete($id);
    }
}

// CREATE LOGIC

if (isset($_POST['add_employee'])) {
    if (empty($_POST['employees_name'])) {
        echo '<div style="color: red">Please enter employee name!</div>';
    } else {
        $createResult = $employeesManager->create($_POST['employees_name'], $_POST['project_id']);
        if (!$createResult) {
            echo '<div style="color: red">The Employee name already exists!</div>';
        } else {
            echo '<div style="color: green">The Employee successfully created!</div>';
        }
    }
}

// READ LOGIC
echo '<table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>PROJECT</th>
                <th>ACTIONS</th>
            </tr>
        </thead>';

$data = $employeesManager->read();
if (count($data) > 0) {
    foreach ($data as $row) {
        echo "<tr>
            <td style=\"width:10%\">" . $row->getId() . "</td>
            <td style=\"width:30%\">" . $row->getName() . "</td>
            <td style=\"width:30%\">" . $row->getProjectList() . "</td>
            <td style=\"width:30%\">
                <a class=\"update\" href=\"index.php?path=employees_form&id=" . $row->getId() . "\">
                    <i class=\"far fa-edit\"></i>
                </a>
                <a class=\"delete\" href=\"index.php?path=employees&delete=" . $row->getId() . "\">
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
<form class="employees-form" action="index.php?path=employees" method="POST">
    <label class="employee-name" for="name" style="font-size: 16px; color: grey">Add new employee:</label>
    <input style="margin-left: 5px; margin-right: 5%;" type="text" name="employees_name" placeholder="Add employee name">
    <label class="project-name" for="name" style="margin-right: 5px; font-size: 16px; color: grey;">Project name:</label>
    <select name="project_id">
        <option value=0></option>
        <?php

        $projects = $projectsManager->read();

        foreach ($projects as $project) {
            echo "<option value=" . $project->getId() . ">" . $project->getName() . "</option>";
        }
        ?>

    </select>
    <input style="margin-left: 10px;" type="submit" name="add_employee" value="Add">
</form>