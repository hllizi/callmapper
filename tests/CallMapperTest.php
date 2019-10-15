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


class Container extends ArrayMonad
{
    use CallMapIterator;
    private $elements;

    public function __construct($elements)
    {
	echo "Into container\n";
        parent::__construct($elements);
        $this->registerMethods(['isFoo', 'number', 'name']);
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
       if(strcmp("Foo", $this->name) == 0) {
        return true;
        } else {
        return false;
        }
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
        $this->assertTrue($this->objects[0]->isFoo());
        $this->assertTrue($this->objects[1]->isFoo());
        $this->assertFalse($this->objects[2]->isFoo());
        $this->assertFalse($this->objects[3]->isFoo());
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
