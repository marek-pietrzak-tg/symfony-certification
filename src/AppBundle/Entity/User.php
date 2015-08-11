<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class User
{
    /**
     * @Assert\NotBlank(groups={"admin"})
     */
    private $adminPassword;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}