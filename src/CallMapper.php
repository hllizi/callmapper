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
    private $monoidPrototype;

    protected function allMonoid(): bool
    {
        return
            $this->objects->fold(
                true,
                function ($arg1, $arg2) {
                    return $arg1 && $arg2 instanceof MonoidInterface;
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
 
    protected function accumulate(): MonoidInterface
    {
        return
            $this->objects->fold(
                sizeof($this->objects) == 0 ? null : $this->objects[0]->neutral(),
		function (MonoidInterface $mon1, MonoidInterface $mon2) 
		{
			return $mon1->op($mon2);
                }
            );
    }


    public function __construct(ArrayMonad $objects)
    {
        $this->objects = $objects;
    }

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
        if($applied->allMonoid()) {
            return $applied->accumulate();
        } else {
            return $applied;
        }
    }
}

