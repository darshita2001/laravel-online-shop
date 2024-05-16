<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
