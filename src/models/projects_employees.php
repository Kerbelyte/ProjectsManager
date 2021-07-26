<?php

namespace Models;

/**
 * @ORM\Entity
 * @ORM\Table(name="Addresses")
 */
class Projects_Employees
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id_projects;

   /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id_employees;
}    

?>