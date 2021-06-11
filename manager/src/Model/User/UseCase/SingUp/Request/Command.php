<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\SingUp\Request;

class Command
{
    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $password;
}