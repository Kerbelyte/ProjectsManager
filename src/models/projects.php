<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany as ManyToMany;
use Doctrine\ORM\Mapping\JoinTable as JoinTable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Projects")
 */
class Projects
{
    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(type="string") 
     */
    protected $name;

    /**
     * @ManyToMany(targetEntity="Employees", inversedBy="Projects")
     * @JoinTable(name="projects_employees")
     */
    private $employees;

    public function getEmployees() {
        return $this->employees;
    }

    public function addEmployee($employee) {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
        }
    }

    public function getId() {
        return $this->id;
    }    

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }

    public function getEmployeeList() {

        $result = '';
        foreach($this->employees as $employee) {
            $result .= $employee->getName() . ', ';
        }
        return rtrim($result, ', ');
    }
}
