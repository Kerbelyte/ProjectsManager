<?php
include 'db.php';
$id = (int) $_GET['id'];

// update logic

if (isset($_POST['name'])) {
    if (empty($_POST['name'])) {
        echo '<div style="color: red">Please enter employee name!</div>';
    } else {
        $stmt = $conn->prepare('UPDATE employees SET name = ? WHERE id = ?');
        $name = $_POST['name'];
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $stmt->close();

        $employeeID = $conn->insert_id;
        $stmt = $conn->prepare('INSERT INTO projects_employees (id_employees, id_projects) VALUES (?, ?)');
        $projectID = $_POST['project_id'];
        $stmt->bind_param('ii', $id, $projectID);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php?path=employees');
        exit;
    }
}

$sql = "SELECT employees.id, employees.name
            FROM employees
            WHERE employees.id = $id";

$result = mysqli_query($conn, $sql);
$name = mysqli_fetch_assoc($result);

?>

<form style="justify-content: center; padding: 20px; display: flex" method="POST">
    <label style="padding: 12px 12px 12px 0; display: inline-block;" for="name">Employee name:</label>
    <input style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: medium;" type="text" id="name" name="name" value="<?php echo $name['name']; ?>" placeholder="Employee name">
    <label style="padding: 12px 12px 12px 12px; display: inline-block;" for="name">Project name:</label>
    <select style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: medium;" name="project_id">
        <option value=0></option>
        <?php

        //    select employee project logic
        $sql = "SELECT id, name FROM projects";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value={$row["id"]}>{$row["name"]}</option>";
        }
        ?>
    </select>
    <input style="background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer;float: right; margin-left: 10px;" type="submit" name="update" value="Update">
</form>

<label style="justify-content: center; padding: 20px; display: flex;">Employee projects:
    <?php

    //    delete employee project logic

    if (!empty($_GET['delete_project_id'])) {
        $delete = 'DELETE FROM projects_employees WHERE id_employees = ?  AND id_projects = ?';
        $stmt = $conn->prepare($delete);
        $stmt->bind_param('ii', $id, $_GET['delete_project_id']);
        $stmt->execute();
    }
    //    select employee projects logic
    $sql = "SELECT projects.name, projects.id 
    FROM projects_employees 
    LEFT JOIN projects ON projects.id = projects_employees.id_projects 
    WHERE projects_employees.id_employees = {$_GET['id']}";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style=\"position: relative; margin-left: 12px; padding: 0px 30px 0px 20px; border: 1px solid lightgrey;
        border-radius: 5px;\">{$row["name"]}
                    <a style= \"position: absolute; right: 0;padding: 0px; padding-right: 3px;line-height: 9px;color: red; font-size: small;\"
                    href=\"index.php?path=employees_form&id={$_GET['id']}&delete_project_id={$row['id']}\">
                    <i class=\"fas fa-times\"></i>    
                    </a>
            </div>";
    }
    ?>
</label>