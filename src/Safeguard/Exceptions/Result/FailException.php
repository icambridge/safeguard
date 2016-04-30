<?php

namespace Safeguard\Exceptions\Result;

class FailException extends ResultException
{
    function getResultType()
    {
        return "fail";
    }
}
