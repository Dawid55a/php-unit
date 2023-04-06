<?php

namespace Recruitment\Cart\Exception;

class QuantityTooLowException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}