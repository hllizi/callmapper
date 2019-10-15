<?php

namespace Hllizi\CallMapper\Monoid;

use Hllizi\CallMapper\Monoid\MonoidInterface;

class NumericMonoid extends Monoid
{
    public function neutral()
    {
        return new NumericMonad(0);
    }
    
    public function op($p)
    {
        return new NumericMonoid($p + $this->value);
    }
}

?>

