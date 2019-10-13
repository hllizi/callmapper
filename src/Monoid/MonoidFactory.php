<?php
namespace Hllizi\CallMapper\Monoid;

use Hllizi\CallMapper\Monoid\NumericMonoid;
use Hllizi\CallMapper\Monoid\BoolMonoid;
use Hllizi\CallMapper\Monoid\ArrayMonoid;
use Hllizi\CallMapper\Monoid\StringMonoid;

class MonoidFactory {
    public function makeMonoid($value)
    {
        if(is_numeric($value)) {
            return new NumericMonoid($value);
        }
        
        if(is_bool($value)) {
            return new BoolMonoid($value);
        }
    
        if(is_array($value)) {
            return new ArrayMonoid($value);
        }

        if(is_string($value)) {
            return new StringMonoid($value);
        }
        
        return $value;
    }
} 

?>
