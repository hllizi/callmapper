<?php

namespace Hllizi\CallMapper\Monoid;

use Hllizi\CallMapper\Monoid\MonoidInterface;

class StringMonoid extends Monoid
{
    public function neutral()
    {
        return new StringMonoid("");
    }
    
    public function op($string)
    {
        return new StringMonoid($string . $this->value);
    }
}

?>

