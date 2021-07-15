<?php
include 'db.php';
$id = (int) $_GET['id'];

// update logic

if (isset($_POST['name'])) {
    $stmt = $conn->prepare('UPDATE employees SET name = ? WHERE id = ?');
    $name = $_POST['name'];
    $stmt->bind_param('si', $name, $id);
    $stmt->execute();
    $stmt->close();
    header('Location: /ProjectsManager/index.php?path=employees');
    exit;
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
    <input style="background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer;float: right; margin-left: 10px;" type="submit" name="update" value="Update">
</form>

