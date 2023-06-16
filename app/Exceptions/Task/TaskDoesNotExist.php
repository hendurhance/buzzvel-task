<?php

namespace App\Exceptions\Task;

use App\Traits\HttpResponse;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class TaskDoesNotExist extends Exception
{
    use HttpResponse;

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        if (is_null($message)) {
            $message = 'Task does not exist';
        }

        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        return $this->error($this->getMessage(), null, Response::HTTP_NOT_FOUND);
    }
}
