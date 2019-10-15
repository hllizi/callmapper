<?php

namespace Hllizi\CallMapper\Monoid;

use Hllizi\CallMapper\Monoid\MonoidInterface;

class ArrayMonoid extends Monoid
{
    public function neutral()
    {
        return new ArrayMonoid([]);
    }
    
    public function op($array)
    {
        return new ArrayMonoid($array + $this->value);
    }
}

?>

