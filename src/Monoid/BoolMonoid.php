<?php

namespace Hllizi\CallMapper\Monoid;

use Hllizi\CallMapper\Monoid\MonoidInterface;

class BoolMonoid extends AbstractMonoid
{
    public function neutral(): MonoidInterface
    {
        return new BoolMonoid(false);
    }
    
    public function op($p): MonoidInterface
    {
        return new BoolMonoid($p->value || $this->value);
    }
}

?>

