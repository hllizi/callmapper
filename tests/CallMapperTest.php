<?php
include(__DIR__ . "/../vendor/autoload.php");
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 20.03.19
 * Time: 12:24
 */
use Hllizi\CallMapper\CallMapIterator;
use Hllizi\PHPMonads\ArrayMonad;

class Container
{
    use CallMapIterator;
    private $elements;

    public function __construct($elements)
    {
        $this->elements = $elements;
        $this->registerMethods(['isFoo', 'number']);
    }

    protected function getArrayCopy()
    {
        return new ArrayMonad($this->elements);
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
        return new Number($this->no);
    }

    public function isFoo()
    {
        $isBjoern = strcmp("Foo", $this->name) == 0;
        return $isBjoern;
    }
}

class Number
{
    private $no;

    public function __construct($no) {
        $this->no = $no;
    }
    public function isBig() {
        return $this->no > 100;
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
        parent::__construct($name, $data, $dataName);
    }

    public function testSingleMethod()
    {

        $this->assertTrue($this->objects[0]->isFoo());
        $this->assertTrue($this->objects[1]->isFoo());
        $this->assertFalse($this->objects[2]->isFoo());
        $this->assertFalse($this->objects[3]->isFoo());
    }

    public function testMethodChain()
    {
        $this->assertTrue($this->objects[0]->number()->isBig());
        $this->assertFalse($this->objects[1]->number()->isBig());
        $this->assertTrue($this->objects[2]->number()->isBig());
        $this->assertFalse($this->objects[3]->number()->isBig());
    }
}