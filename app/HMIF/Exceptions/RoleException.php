<?php namespace HMIF\Exceptions;

use Exception;

class RoleException extends Exception {

    public function __construct($message, $code = 0, Exception $previous = null) {

        parent::__construct($message, $code, $previous);
    }
}