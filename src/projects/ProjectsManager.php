<?php

namespace Projects;

class ProjectsManager
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
        $project = $this->entityManager->find('Models\Projects', $id);
        if ($project !== null) {
            foreach ($project->getEmployees() as $employee) {
                $employee->getProjects()->removeElement($project);
                $project->getEmployees()->removeElement($employee);
            }
            $this->entityManager->remove($project);
            $this->entityManager->flush();
        }
    }

    public function create($name, $employeeId)
    {
        $project = $this->entityManager->getRepository('Models\Projects')->findOneBy(array('name' => $name));
        if ($project !== null) {
            return false;
        }
        $project = new \Models\Projects();
        $project->setName($name);

        if ($employeeId !== 0) {
            $employee = $this->entityManager->getRepository('Models\Employees')->findOneBy(array('id' => $employeeId));
            if ($employee !== null) {
                $project->addEmployee($employee);
            }
        }
        $this->entityManager->persist($project);
        $this->entityManager->flush();
        return true;
    }

    public function update($id, $name, $employeeId)
    {
        $project = $this->entityManager->find('Models\Projects', $id);
        $project->setName($name);
        if ($employeeId != 0) {
            $employee = $this->entityManager->getRepository('Models\Employees')->findOneBy(array('id' => $employeeId));
            $project->addEmployee($employee);
        }
        $this->entityManager->flush();
        header('Location: index.php?path=projects');
    }

    public function deleteEmployees($ProjectId, $employeeId)
    {
        $project = $this->entityManager->find('Models\Projects', $ProjectId);
        $employee = $this->entityManager->getRepository('Models\Employees')->findOneBy(array('id' => $employeeId));
        $employee->getProjects()->removeElement($project);
        $project->getEmployees()->removeElement($employee);
        $this->entityManager->flush();
    }

    public function read()
    {
        $result = [];
        $employees = $this->entityManager->getRepository('Models\Projects')->findAll();
        foreach ($employees as $employee) {
            $result[] = $employee;
        }
        return $result;
    }

    public function getProjectName($id)
    {
        $project = $this->entityManager->getRepository('Models\Projects')->findOneBy(array('id' => $id));
        return $project->getName();
    }

    public function getProjectEmployees($id)
    {
        $project = $this->entityManager->getRepository('Models\Projects')->findOneBy(array('id' => $id));
        return $project->getEmployees();
    }
}
