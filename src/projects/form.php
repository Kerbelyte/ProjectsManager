<?php

$id = (int) $_GET['id'];

// update logic
if (isset($_POST['project_name'])) {
    if (empty($_POST['project_name'])) {
        echo '<div style="color: red">Please enter project name!</div>';
    } else {
        $projectsManager->update($id, $_POST['project_name'],$_POST['employee_id']);
    }
}

$projectName = $projectsManager->getProjectName($id);

?>
<form style="justify-content: center; padding: 20px; display: flex" method="POST">
    <label style="padding: 12px 12px 12px 0; display: inline-block;" for="name">Project name:</label>
    <input style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: medium;" type="text" id="name" name="project_name" value="<?php echo $projectName; ?>" placeholder="Project name">
    <label style="padding: 12px 12px 12px 12px; display: inline-block;" for="name">Employee name:</label>
    <select style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: medium;" name="employee_id">
        <option value=0></option>
        <?php

        //    select project employees logic
        $employees = $employeesManager->read();

        foreach ($employees as $employee) {
            echo "<option value=" . $employee->getId() . ">" . $employee->getName() . "</option>";
        }
        ?>
    </select>
    <input style="background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer;float: right; margin-left: 10px;" type="submit" name="update" value="Update">
</form>

<label style="justify-content: center; padding: 20px; display: flex;">Project employees:
    <?php

    //    delete project employees logic

    if (!empty($_GET['delete_employee_id'])) {
        $projectsManager->deleteEmployees($id, $_GET['delete_employee_id']);
    }

    //    select project employees logic
    $employees = $projectsManager->getProjectEmployees($id);

    foreach ($employees as $employee) {
        echo "<div style=\"position: relative; margin-left: 12px; padding: 0px 30px 0px 20px; border: 1px solid lightgrey;
        border-radius: 5px;\">" . $employee->getName() . "
                    <a style= \"position: absolute; right: 0;padding: 0px; padding-right: 3px;line-height: 9px;color: red; font-size: small;\"
                    href=\"index.php?path=projects_form&id={$id}&delete_employee_id=" . $employee->getId() . "\">
                    <i class=\"fas fa-times\"></i>    
                    </a>
            </div>";
    }
    ?>
</label>