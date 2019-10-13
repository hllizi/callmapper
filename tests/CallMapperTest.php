<?php
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 20.03.19
 * Time: 12:24
 */
use Hllizi\CallMapper\CallMapIterator;
use Hllizi\CallMapper\Monoid\MonoidInterface;
use Hllizi\CallMapper\Monoid\MonoidFactory;
use Hllizi\PHPMonads\ArrayMonad;


class Container
	implements Iterator
{
    use CallMapIterator;
    private $elements;

    public function __construct($elements)
    {
	echo "Into container\n";
        $this->elements = new ArrayMonad($elements);
        $this->registerMethods(['isFoo', 'number', 'name']);
    }

    public function getArrayCopy()
    {
        return $this->elements;
    }

    public function current() {
    	return $this->elements->getIterator()->current();
    }

    public function key() {
    	return $this->elements->getIterator()->key();
    }

    public function next() {
    	return $this->elements->getIterator()->next();
    }


    public function rewind() {
    	return $this->elements->getIterator()->rewind();
    }

    public function valid() {
    	return $this->elements->getIterator()->valid();
    }
}

class Element
{
    private $no;
    private $name;

    public function __construct($name, $no)
    {
        $this->no = $no;
        $this->name = $name;
    }

    public function number()
    {
        return $this->no;
    }

    public function name()
    {
	return $this->name;
    }

    public function isFoo()
    {
        $isBjoern = strcmp("Foo", $this->name) == 0;
        return $isBjoern;
    }
}

class CallMapperTest extends \PHPUnit\Framework\TestCase
{

    private $testObject;
    private $objects;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        $this->objects = new ArrayMonad();
        $this->objects[] = [new Element("Foo", 1), new Element("Bjarne", 101)];
        $this->objects[] = [new Element("Foo", 1), new Element("Bjarne", 10)];
        $this->objects[] = [new Element("Fooboy", 1), new Element("Bjarne", 101)];
        $this->objects[] = [new Element("Fooboy", 1), new Element("Bjarne", 10)];

        $this->objects = $this->objects->map(function ($array) {
            return new Container($array);
        });
	echo "Constructed, constructing parent.";
        parent::__construct($name, $data, $dataName);
    }

    public function testSingleMethod()
    {

	echo "Single Method";
        $this->assertTrue($this->objects[0]->isFoo()());
//	echo "First asserted";
//        $this->assertTrue($this->objects[1]->isFoo()());
//	echo "Second asserted";
//        $this->assertFalse($this->objects[2]->isFoo()());
//	echo "Third asserted";
//        $this->assertFalse($this->objects[3]->isFoo()());
//    }
//
//    public function testMethodChain()
//    {
//        $this->assertTrue($this->objects[0]->number());
//        $this->assertFalse($this->objects[1]->number());
//        $this->assertTrue($this->objects[2]->number());
//        $this->assertFalse($this->objects[3]->number());
    }
}
