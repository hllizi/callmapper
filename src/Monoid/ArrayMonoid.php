<?php

namespace Hllizi\CallMapper\Monoid;

use Hllizi\CallMapper\Monoid\MonoidInterface;

class ArrayMonoid 
    implements MonoidInterface
{
    private $value;

    public function neutral()
    {
        return new ArrayMonoid([]);
    }
    
    public function op($array)
    {
        return new ArrayMonoid($array + $this->value);
    }

    public function return($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}

?>

