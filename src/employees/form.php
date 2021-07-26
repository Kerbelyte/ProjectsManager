<?php
include 'db.php';
$employeesManager = new Employees\EmployeesManager($conn);
$id = (int) $_GET['id'];


// update logic

if (isset($_POST['name'])) {
    if (empty($_POST['name'])) {
        echo '<div style="color: red">Please enter employee name!</div>';
    } else {
        $employeesManager->update($id);
    }
}

$employeeName = $employeesManager->getEmployeeName($id);

?>

<form style="justify-content: center; padding: 20px; display: flex" method="POST">
    <label style="padding: 12px 12px 12px 0; display: inline-block;" for="name">Employee name:</label>
    <input style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: medium;" type="text" id="name" name="name" value="<?php echo $employeeName; ?>" placeholder="Employee name">
    <label style="padding: 12px 12px 12px 12px; display: inline-block;" for="name">Project name:</label>
    <select style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: medium;" name="project_id">
        <option value=0></option>
        <?php

        //    select employee project logic
        $projectsManager = new Projects\ProjectsManager($conn);
        $projects = $projectsManager->getProjects();

        foreach ($projects as $project) {
            echo "<option value={$project["id"]}>{$project["name"]}</option>";
        }
        ?>
    </select>
    <input style="background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer;float: right; margin-left: 10px;" type="submit" name="update" value="Update">
</form>

<label style="justify-content: center; padding: 20px; display: flex;">Employee projects:
    <?php

    //    delete employee project logic

    if (!empty($_GET['delete_project_id'])) {
        $employeesManager = new Employees\EmployeesManager($conn);
        $employeesManager->deleteProjects($id);
    }
    //    select employee projects logic

    $projects = new Projects\ProjectsManager($conn);
    $projects = $projectsManager->showEmplyees();

    foreach($projects as $project) {
        echo "<div style=\"position: relative; margin-left: 12px; padding: 0px 30px 0px 20px; border: 1px solid lightgrey;
        border-radius: 5px;\">{$project["name"]}
                    <a style= \"position: absolute; right: 0;padding: 0px; padding-right: 3px;line-height: 9px;color: red; font-size: small;\"
                    href=\"index.php?path=employees_form&id={$_GET['id']}&delete_project_id={$project['id']}\">
                    <i class=\"fas fa-times\"></i>    
                    </a>
            </div>";
    }
    ?>
</label>