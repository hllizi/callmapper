<?php

namespace Hllizi\CallMapper\Monoid;

use Hllizi\CallMapper\Monoid\MonoidInterface;

class BoolMonoid 
    implements MonoidInterface
{
    private $value;

    public function neutral(): MonoidInterface
    {
        return new BoolMonoid(false);
    }
    
    public function op($p): MonoidInterface
    {
        return new BoolMonoid($p || $this->value);
    }

    public function return($value): MonoidInterface 
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}

?>

