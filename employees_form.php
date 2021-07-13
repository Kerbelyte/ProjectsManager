<?php
include 'db.php';
$id = (int) $_GET['id'];

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

<form method="POST">
    <label for="name" style="font-size: 16px; color: grey">Employee name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo $name['name']; ?>" placeholder="Employee name"><br>
    <input type="submit" name="update" value="Update">
</form>
<br>
