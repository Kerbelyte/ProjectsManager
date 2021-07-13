<?php
include 'db.php';
$id = (int) $_GET['id'];

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

<br>
<form method="POST">
    <label for="name" style="font-size: 16px; color: grey">Project name:</label><br>
    <input type="text" id="name" name="project_name" value="<?php echo $name['name']; ?>" placeholder="Project name"><br>
    <label for="name" style="font-size: 16px; color: grey">Employee name:</label><br>
    <select name="emloyee_id">
        <option value=0></option>
        <?php
        $sql = "SELECT id, name FROM employees";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value={$row["id"]}>{$row["name"]}</option>";
        }
        mysqli_close($conn);
        ?>

    </select><br>
    <input type="submit" name="update" value="Update">
</form>