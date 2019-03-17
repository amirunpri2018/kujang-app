<?php

namespace System\Exception;

use Interop\Container\Exception\ContainerException as InteropContainerException;
use InvalidArgumentException;

class ContainerException extends InvalidArgumentException implements InteropContainerException
{

}

