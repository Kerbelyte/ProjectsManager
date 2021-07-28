<?php

namespace Employees;

class EmployeesManager
{
    private $conn;
    private $entityManager;

    public function __construct($conn, $entityManager)
    {
        $this->conn = $conn;
        $this->entityManager = $entityManager;
    }

    public function delete($id)
    {
        $employee = $this->entityManager->find('Models\Employees', $id);
        if ($employee !== null) {
            foreach ($employee->getProjects() as $project) {
                $employee->getProjects()->removeElement($project);
                $project->getEmployees()->removeElement($employee);
            }
            $this->entityManager->remove($employee);
            $this->entityManager->flush();
        }
    }

    public function create($name, $projectId)
    {
        $employee = $this->entityManager->getRepository('Models\Employees')->findOneBy(array('name' => $name));
        if ($employee !== null) {
            return false;
        }
        $employee = new \Models\Employees();
        $employee->setName($name);

        if ($projectId !== 0) {
            $project = $this->entityManager->getRepository('Models\Projects')->findOneBy(array('id' => $projectId));
            if ($project !== null) {
                $employee->addProject($project);
            }
        }
        $this->entityManager->persist($employee);
        $this->entityManager->flush();
        return true;
    }

    public function update($id, $name, $projectId)
    {
        $employee = $this->entityManager->find('Models\Employees', $id);
        $employee->setName($name);
        if ($projectId != 0) {
            $project = $this->entityManager->getRepository('Models\Projects')->findOneBy(array('id' => $projectId));
            $employee->addProject($project);
        }
        $this->entityManager->flush();
        header('Location: index.php?path=employees');
    }

    public function deleteProjects($employeeId, $projectId)
    {
        $employee = $this->entityManager->find('Models\Employees', $employeeId);
        $project = $this->entityManager->getRepository('Models\Projects')->findOneBy(array('id' => $projectId));
        $employee->getProjects()->removeElement($project);
        $project->getEmployees()->removeElement($employee);
        $this->entityManager->flush();
    }

    public function read()
    {
        $result = [];
        $employees = $this->entityManager->getRepository('Models\Employees')->findAll();
        foreach ($employees as $employee) {
            $result[] = $employee;
        }
        return $result;
    }

    public function getEmployeeName($id)
    {
        $employee = $this->entityManager->getRepository('Models\Employees')->findOneBy(array('id' => $id));
        return $employee->getName();
    }

    public function getEmployeeProject($id)
    {
        $employee = $this->entityManager->getRepository('Models\Employees')->findOneBy(array('id' => $id));
        return $employee->getProjects();
    }
}
