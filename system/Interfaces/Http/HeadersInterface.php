<?php

namespace System\Interfaces\Http;

use System\Interfaces\CollectionInterface;

/**
 * Headers Interface
 *
 * @package System
 * @since   3.0.0
 */
interface HeadersInterface extends CollectionInterface
{
    public function add ( $key, $value );
    
    public function normalizeKey ( $key );
}
