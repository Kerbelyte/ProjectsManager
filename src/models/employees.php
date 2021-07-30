<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany as ManyToMany;
use Doctrine\ORM\Mapping\JoinTable as JoinTable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Employees")
 */
class Employees
{
    public function __construct()
    {
        $this->projects = new ArrayCollection();
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
     * @ManyToMany(targetEntity="Projects", inversedBy="Employees")
     * @JoinTable(name="projects_employees")
     */
    private $projects;

    public function getProjects() {
        return $this->projects;
    }

    public function addProject($project) {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }

    public function getProjectList() {

        $result = '';
        foreach($this->projects as $project) {
            $result .= $project->getName() . ', ';
        }
        return rtrim($result, ', ');
    } 
}    

?>