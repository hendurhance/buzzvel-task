<?php

namespace App\Exceptions\Task;

use App\Traits\HttpResponse;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class TaskNotOwnedByUser extends Exception
{
    use HttpResponse;

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        if (is_null($message)) {
            $message = 'Task not owned by user';
        }

        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        return $this->error($this->getMessage(), null, Response::HTTP_FORBIDDEN);
    }
}
