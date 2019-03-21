<?php
namespace Hllizi\CallMapper;
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 20.03.19
 * Time: 12:22
 */
use Hllizi\PHPMonads\ArrayMonad;
use Hllizi\PHPMonads\MonadTrait;

class CallMapper
{
    use MonadTrait;
    private $objects;

    protected function allBools(): bool
    {
        return
            $this->objects->fold(
                true,
                function ($arg1, $arg2) {
                    return $arg1 && is_bool($arg2);
                });
    }

    protected function some(): bool
    {
        return
            $this->objects->fold(
                false,
                function ($bool1, $bool2) {
                    return $bool1 || $bool2;
                }
            );
    }

    public function __construct(ArrayMonad $objects)
    {
        $this->objects = $objects;
    }

 /*   public function __invoke()
    {
        if ($this->objects->fold(
            true,
            function ($arg1, $arg2) {
                return $arg1 && is_bool($arg2);
            })
        ) {

            return
                $this->objects->fold(
                    false,
                    function ($bool1, $bool2) {
                        return $bool1 || $bool2;
                    }
                );
        } else {
            throw new \Exception("CallMapper may not be invoked with non-boolean elements.");
        }

    }*/

    public function return($x)
    {
        return new CallMapper($this->objects->return($x));
    }

    public function bind(callable $function)
    {
            $innerFunction = function ($object) use ($function) {
                return call_user_func($function, $object)->getObjects();
            };
            return new CallMapper($this->objects->bind($innerFunction));
    }

    public function getObjects()
    {
        return $this->objects;
    }

    public function __call($method, $args)
    {
        $call = function($object) use ($method, $args) {
            return call_user_func_array([$object, $method], $args);
        };
        $applied = $this->map($call);
        if($applied->allBools()) {
            return $applied->some();
        } else {
            return $applied;
        }
    }
}

