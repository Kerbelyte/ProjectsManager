<?php

namespace Projects;

class ProjectsManager 
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function delete($id)
    {
        if ($id > 0) {
            $delete = 'DELETE FROM projects_employees WHERE id_projects = ?';
            $stmt = $this->conn->prepare($delete);
            $stmt->bind_param('i', $id);
            $stmt->execute();
    
            $delete = 'DELETE FROM projects WHERE id = ?';
            $stmt = $this->conn->prepare($delete);
            $stmt->bind_param('i', $id);
            $stmt->execute();
        }
    }

    public function create($name)
    {
        $nameFromDB = null;
        $sql = "SELECT name FROM projects WHERE name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($nameFromDB);
        $stmt->fetch();
        $stmt->close();
        if ($nameFromDB === null) {
            $stmt = $this->conn->prepare('INSERT INTO projects (name) VALUES (?)');
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->close();

            if ($_POST['emloyee_id'] != 0) {
                $projectID = $this->conn->insert_id;
                $stmt = $this->conn->prepare('INSERT INTO projects_employees (id_projects, id_employees) VALUES (?, ?)');
                $employeeID = $_POST['emloyee_id'];
                $stmt->bind_param('ii', $projectID, $employeeID);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            echo '<div style="color: red">The Project name already exists!</div>';
        }
    }

    public function update($id)
    {
        $stmt = $this->conn->prepare('UPDATE projects SET name = ? WHERE id = ?');
        $stmt->bind_param('si', $_POST["project_name"], $id);
        $stmt->execute();
        $stmt->close();

        $stmt = $this->conn->prepare('INSERT INTO projects_employees (id_projects, id_employees) VALUES (?, ?)');
        $employeeID = $_POST['emloyee_id'];
        $stmt->bind_param('ii', $id, $employeeID);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteEmployees($id)
    {
        $delete = 'DELETE FROM projects_employees WHERE id_projects = ?  AND id_employees = ?';
        $stmt = $this->conn->prepare($delete);
        $stmt->bind_param('ii', $id, $_GET['delete_employee_id']);
        $stmt->execute();
    }

    public function read()
    {
        $sql = "SELECT projects.id as projects_id, projects.name as projects_name, GROUP_CONCAT(' ', employees.name) as names
            FROM projects
            LEFT JOIN projects_employees ON projects_employees.id_projects = projects.id
            LEFT JOIN employees ON employees.id = projects_employees.id_employees
            GROUP BY projects.id";

        $result = mysqli_query($this->conn, $sql);

        $rows = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
        }
        return $rows;    
    }

    public function getProjects()
    {
        $rows = [];
        $sql = "SELECT id, name FROM projects";
        $result = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getProjectName($id)
    {
        $sql = "SELECT projects.name
            FROM projects
            WHERE projects.id = $id";
        $result = mysqli_query($this->conn, $sql);
        $row =  mysqli_fetch_assoc($result);
        return $row['name'];
    }

    public function showEmplyees()
    {
        $sql = "SELECT projects.name, projects.id 
        FROM projects_employees 
        LEFT JOIN projects ON projects.id = projects_employees.id_projects 
        WHERE projects_employees.id_employees = {$_GET['id']}";

        $result = mysqli_query($this->conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }
}
