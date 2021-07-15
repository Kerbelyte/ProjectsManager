<?php
include 'db.php';
$id = (int) $_GET['id'];

// update logic
if (isset($_POST['project_name'])) {
    $stmt = $conn->prepare('UPDATE projects SET name = ? WHERE id = ?');
    $name = $_POST["project_name"];
    $stmt->bind_param('si', $name, $id);
    $stmt->execute();
    $stmt->close();

    $projectID = $conn->insert_id;
    $stmt = $conn->prepare('INSERT INTO projects_employees (id_projects, id_employees) VALUES (?, ?)');
    $employeeID = $_POST['emloyee_id'];
    $stmt->bind_param('ii', $id, $employeeID);
    $stmt->execute();
    $stmt->close();

    header('Location: /ProjectsManager/index.php?path=projects');
    exit;
}

$sql = "SELECT projects.id, projects.name
            FROM projects
            WHERE projects.id = $id";
$result = mysqli_query($conn, $sql);
$name = mysqli_fetch_assoc($result);

?>
<form style="justify-content: center; padding: 20px; display: flex" method="POST">
    <label style="padding: 12px 12px 12px 0; display: inline-block;" for="name">Project name:</label>
    <input style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: medium;" type="text" id="name" name="project_name" value="<?php echo $name['name']; ?>" placeholder="Project name">
    <label style="padding: 12px 12px 12px 12px; display: inline-block;" for="name">Employee name:</label>
    <select style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: medium;" name="emloyee_id">
        <option value=0></option>
        <?php

        //    select project employees logic
        $sql = "SELECT id, name FROM employees";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value={$row["id"]}>{$row["name"]}</option>";
        }
        ?>
    </select>
    <input style="background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer;float: right; margin-left: 10px;" 
           type="submit" name="update" value="Update">
</form>

<label style="justify-content: center; padding: 20px; display: flex;">Project employees:
    <?php

    //    delete project employees logic

    if (!empty($_GET['delete_employee_id'])) {
        $delete = 'DELETE FROM projects_employees WHERE id_projects = ?  AND id_employees = ?';
        $stmt = $conn->prepare($delete);
        $stmt->bind_param('ii', $id, $_GET['delete_employee_id']);
        $stmt->execute();
    }
    //    select project employees logic
    $sql = "SELECT employees.name, employees.id 
    FROM projects_employees 
    LEFT JOIN employees ON employees.id = projects_employees.id_employees 
    WHERE projects_employees.id_projects = {$_GET['id']}";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style=\"position: relative; margin-left: 12px; padding: 0px 30px 0px 20px; border: 1px solid lightgrey;
        border-radius: 5px;\">{$row["name"]}
                    <a style= \"position: absolute; right: 0;padding: 0px; padding-right: 3px;line-height: 9px;color: red; font-size: small;\"
                    href=\"index.php?path=projects_form&id={$_GET['id']}&delete_employee_id={$row['id']}\">
                    <i class=\"fas fa-times\"></i>    
                    </a>
            </div>";
    }
    ?>
</label>