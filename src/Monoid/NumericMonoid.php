<?php

namespace Hllizi\CallMapper\Monoid;

use Hllizi\CallMapper\Monoid\MonoidInterface;

class NumericMonoid 
    implements MonoidInterface
{
    private $value;

    public function neutral()
    {
        return new NumericMonad(0);
    }
    
    public function op($p)
    {
        return new NumericMonoid($p + $this->value);
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

