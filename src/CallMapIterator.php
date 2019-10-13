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
use Hllizi\CallMapper\Monoid\MonoidInterface;
use Hllizi\CallMapper\Monoid\MonoidFactory;


trait CallMapIterator
{
    private $registeredMethods;
    private $monoidFactory;

    public function __call($method, $args)
    {
        $this->monoidFactory = $this->monoidFactory ?? new MonoidFactory();
        $this->initialiseIfNull();
//        if (in_array($method, $this->registeredMethods->getArrayCopy())) {
//            return call_user_func_array([new CallMapper($this->getArrayCopy()), $method], $args);
//        }
        $call = function($object) use ($method, $args) {
            return call_user_func_array([$object, $method], $args);
        };
	$applied = new CallMapper([]);
	foreach($this as $item) {
		$applied[] = $this->monoidFactory->makeMonoid($call($item));
	}
        if($applied->allMonoid()) {
            return $applied->accumulate()->value();
        } else {
            return $applied;
        }
    }

    public function fold($initial, callable $fun)
    {
        $value = $initial;
        foreach($this as $current) {
            $value = $fun($value, $current);
        }
        return $value;
    }

    protected function allMonoid(): bool
    {
        return
            $this->fold(
                true,
                function ($arg1, $arg2) {
                    $isMonoid = $arg2 instanceof MonoidInterface;
                    return $arg1 && $isMonoid;
                });
    }
 
    protected function accumulate(): MonoidInterface
    {

        if(sizeof($this) == 0) {
            return null;
        } else 
            {
               $neutral = $this[0]->neutral();
        }
                
        return
            $this->fold(
                $neutral,
		function (MonoidInterface $mon1, MonoidInterface $mon2) 
		{
                        if($mon1 === null) {
                            return $null;
                        }
			return $mon1->op($mon2);
                }
            );
    }

    private function initialiseIfNull()
    {
        //$this->registeredMethods = $this->registeredMethods ?? new ArrayMonad([]);
    }

    public function registerMethods(array $methodArray)
    {
        $this->initialiseIfNull();
        //$this->registeredMethods->exchangeArray(array_merge($this->registeredMethods->getArrayCopy(), $methodArray));
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

    protected function registeredMethod(string $method): bool
    {
	    return in_array($method, $this->registeredMethods->getArrayCopy());
    }
}
