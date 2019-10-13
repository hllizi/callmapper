<?php
namespace Hllizi\Callmapper\Monoid;

interface MonoidInterface
{
	public function neutral(): MonoidInterface;
	public function op(MonoidInterface $a): MonoidInterface;
	public function return($a): MonoidInterface;
        public function value();
}
