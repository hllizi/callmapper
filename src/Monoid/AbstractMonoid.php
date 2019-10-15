<?php

namespace Hllizi\CallMapper\Monoid;

abstract class AbstractMonoid 
    implements MonoidInterface {

    protected $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function value() {
        return $this->value;
    }

    abstract public function neutral(): MonoidInterface;
    abstract public function op(MonoidInterface $m): MonoidInterface;
}
