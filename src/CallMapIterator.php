<?php
namespace Hllizi\CallMapper;
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 20.03.19
 * Time: 12:23
 */

use Hllizi\PHPMonads\ArrayMonad;
use Hllizi\CallMapper\CallMapper;


trait CallMapIterator
{
    abstract protected function getArrayCopy(): ArrayMonad;

    public function __call($method, $args)
    {
        if (true) {
            return call_user_func_array([new CallMapper($this->getArrayCopy()), $method], $args);
        }
    }
}
