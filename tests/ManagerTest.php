<?php

use Administr\Assets\Manager;

class ManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Manager
     */
    private $manager;

    public function setUp()
    {
        $this->manager = new Manager;
    }

    /** @test */
    public function it_adds_an_asset_of_type()
    {
        $this->manager->add('test.css', 'css');

        $this->assertCount(1, $this->manager->get('css'));
    }

    /** @test */
    public function it_orders_the_assets_by_priority()
    {
        $this->manager->add('test1.css', 'css', 1);
        $this->manager->add('test2.css', 'css', 2);

        $this->assertSame(['test2.css', 'test1.css'], $this->manager->get('css'));
    }

    /** @test */
    public function it_can_be_chained_on_add()
    {
        $this->manager
            ->add('test1.css', 'css')
            ->addCSS('test2.css')
            ->addCss('test3.css');

        $this->assertCount(3, $this->manager->get('css'));
    }

    /** @test */
    public function it_adds_asset_with_magic_method()
    {
        $this->manager->addCSS('test.css');

        $this->assertCount(1, $this->manager->getCSS());
    }

    /** @test */
    public function it_returns_empty_array_when_key_does_not_exist_or_it_has_no_assets()
    {
        $this->assertCount(0, $this->manager->getCss());
    }

    /**
     * @test
     * @expectedException BadMethodCallException
     */
    public function it_throws_exception_on_magic_method_when_bogus_one_is_called()
    {
        $this->manager->testMethod();
    }
}
