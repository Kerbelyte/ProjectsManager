<?php

namespace Models;

/**
 * @ORM\Entity
 * @ORM\Table(name="Addresses")
 */
class Projects
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