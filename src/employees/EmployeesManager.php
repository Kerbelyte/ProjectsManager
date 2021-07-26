<?php

namespace Employees;

class EmployeesManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function delete($id)
    {
        if ($id > 0) {
            $delete = 'DELETE FROM projects_employees WHERE id_employees = ?';
            $stmt = $this->conn->prepare($delete);
            $stmt->bind_param('i', $id);
            $stmt->execute();

            $delete = 'DELETE FROM employees WHERE id = ?';
            $stmt = $this->conn->prepare($delete);
            $stmt->bind_param('i', $id);
            $stmt->execute();
        }
    }

    public function create($name)
    {
        $nameFromDB = null;
        $sql = "SELECT name FROM employees WHERE name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($nameFromDB);
        $stmt->fetch();
        $stmt->close();
        if ($nameFromDB === null) {
            $stmt = $this->conn->prepare('INSERT INTO employees (name) VALUES (?)');
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->close();

            if ($_POST['project_id'] != 0) {
                $employeeID = $this->conn->insert_id;
                $stmt = $this->conn->prepare('INSERT INTO projects_employees (id_employees, id_projects) VALUES (?, ?)');
                $projectID = $_POST['project_id'];
                $stmt->bind_param('ii', $employeeID, $projectID);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            echo '<div style="color: red">The Employee name already exists!</div>';
        }
    }

    public function update($id)
    {
        $stmt = $this->conn->prepare('UPDATE employees SET name = ? WHERE id = ?');
        $stmt->bind_param('si', $_POST['name'], $id);
        $stmt->execute();
        $stmt->close();

        $stmt = $this->conn->prepare('INSERT INTO projects_employees (id_employees, id_projects) VALUES (?, ?)');
        $projectID = $_POST['project_id'];
        $stmt->bind_param('ii', $id, $projectID);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php?path=employees');
        exit;
    }

    public function deleteProjects($id)
    {
        $delete = 'DELETE FROM projects_employees WHERE id_employees = ?  AND id_projects = ?';
        $stmt = $this->conn->prepare($delete);
        $stmt->bind_param('ii', $id, $_GET['delete_project_id']);
        $stmt->execute();
    }

    public function read()
    {
        $sql = "SELECT employees.id as employees_id, employees.name as employees_name, GROUP_CONCAT(' ', projects.name) as names
        FROM employees
        LEFT JOIN projects_employees ON projects_employees.id_employees = employees.id
        LEFT JOIN projects ON projects.id = projects_employees.id_projects
        GROUP BY employees.id";

        $result = mysqli_query($this->conn, $sql);

        $rows = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }
        return $rows;    
    }

    public function getEmplyees()
    {
        $rows = [];
        $sql = "SELECT id, name FROM employees";
        $result = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function showEmplyees()
    {
        $sql = "SELECT employees.name, employees.id 
        FROM projects_employees 
        LEFT JOIN employees ON employees.id = projects_employees.id_employees 
        WHERE projects_employees.id_projects = {$_GET['id']}";

        $result = mysqli_query($this->conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    public function getEmployeeName($id)
    {
        $sql = "SELECT employees.name
            FROM employees
            WHERE employees.id = $id";

        $result = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['name'];
    }
    
}
