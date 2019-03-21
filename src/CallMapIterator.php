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
    private $registeredMethods;
    abstract protected function getArrayCopy(): ArrayMonad;

    private function initialiseIfNull()
    {
        $this->registeredMethods = $this->registeredMethods ?? new ArrayMonad([]);
    }


    public function __call($method, $args)
    {
        $this->initialiseIfNull();
        if (in_array($method, $this->registeredMethods->getArrayCopy())) {
            return call_user_func_array([new CallMapper($this->getArrayCopy()), $method], $args);
        }
    }

    public function registerMethods(array $methodArray)
    {
        $this->initialiseIfNull();
        $this->registeredMethods->exchangeArray(array_merge($this->registeredMethods->getArrayCopy(), $methodArray));
    }

    public function deRegisterMethods(array $methodArray)
    {
        $this->initialiseIfNull();
        $registeredMethods = $this->registeredMethods;
        $registeredMethods =
            $registeredMethods
            ->bind(function ($method) use ($methodArray) {
                if(in_array($method, $methodArray)) {
                    return new ArrayMonad();
                } else {
                    return new ArrayMonad([$method]);
                }
            });
        $this->registeredMethods = $registeredMethods;
    }
}
