<?php

namespace Hllizi\CallMapper\Monoid;

use Hllizi\CallMapper\Monoid\MonoidInterface;

class StringMonoid 
    implements MonoidInterface
{
    private $value;

    public function neutral()
    {
        return new StringMonoid("");
    }
    
    public function op($string)
    {
        return new StringMonoid($string . $this->value);
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

