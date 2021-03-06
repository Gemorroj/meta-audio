<?php

namespace duncan3dc\MetaAudioTests\Modules;

use duncan3dc\MetaAudio\Modules\Id3v2;
use duncan3dc\ObjectIntruder\Intruder;

class Id3v2MockTest extends \PHPUnit_Framework_TestCase
{
    private $module;

    public function setUp()
    {
        $module = new Id3v2;
        $this->module = new Intruder($module);
    }


    public function testGetArtist()
    {
        $this->module->tags = [
            "TPE1" => "rise against",
            "TPE2" => "trivium",
        ];

        $this->assertSame("rise against", $this->module->getArtist());
    }
    public function testGetAlbumArtist()
    {
        $this->module->tags = [
            "TPE2" => "trivium",
        ];

        $this->assertSame("trivium", $this->module->getArtist());
    }


    public function testSetArtist()
    {
        $this->module->tags = [];

        $this->module->setArtist("coheed and cambria");
        $this->module->saveChanges = false;

        $this->assertSame("coheed and cambria", $this->module->tags["TPE1"]);
        $this->assertSame("coheed and cambria", $this->module->tags["TPE2"]);
    }


    public function keyProvider()
    {
        $keys = [
            "AAAA"  =>  true,
            "    "  =>  false,
            "TIT2"  =>  true,
            "TT2\0" =>  false,
        ];
        foreach ($keys as $key => $expected) {
            yield [$key, $expected];
        }
    }
    /**
     * @dataProvider keyProvider
     */
    public function testValidKey($key, $expected)
    {
        $frames = $key . "\0\0\0\0\0\0\0";

        $result = $this->module->parseItem($frames);

        if ($expected) {
            $this->assertSame([$key, ""], $result);
        } else {
            $this->assertNull($result);
        }
    }
}
