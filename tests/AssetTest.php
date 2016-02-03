<?php

class AssetTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_contains_the_asset_info()
    {
        $asset = new \Administr\Assets\Asset('test.css', 100);

        $this->assertSame('test.css', $asset->getName());
        $this->assertSame(100, $asset->getPriority());
    }
}
