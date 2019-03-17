<?php

namespace System\Exception;

use Interop\Container\Exception\NotFoundException as InteropNotFoundException;
use RuntimeException;

class ContainerValueNotFoundException extends RuntimeException implements InteropNotFoundException
{

}