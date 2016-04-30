<?php

namespace Safeguard\Exceptions\Result;

class WarningException extends ResultException
{
    function getResultType()
    {
        return "warning";
    }
}
