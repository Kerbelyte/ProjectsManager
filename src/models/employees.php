<?php

namespace Models;

/**
 * @ORM\Entity
 * @ORM\Table(name="Addresses")
 */
class Employees
{
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
}    

?>