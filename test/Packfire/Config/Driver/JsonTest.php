<?php

namespace Packfire\Config\Driver;

use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_TestCase;

class JsonTest extends ConfigTestSetter
{
    protected function setUp()
    {
        $this->prepare('Packfire\\Config\\Driver\\Json');
    }

    public function testFile()
    {
        $this->assertEquals($this->file, $this->object->file());
    }

    public function testRead()
    {
        $data = <<<EOT
{
    "test": {
        "data": 5,
        "route": false
    }
}
EOT;
        $root = vfsStream::setup('root');
        $file = vfsStream::newFile('config.json');
        $root->addChild($file);
        $file->withContent($data);

        $reader = new Json(vfsStream::url('root/config.json'));
        $reader->read();

        $this->assertEquals(array('test' => array('data' => 5, 'route' => false)), $reader->get());
    }

    public function testWrite()
    {
        $root = vfsStream::setup('root');
        $file = vfsStream::newFile('config.json');
        $root->addChild($file);

        $reader = new Json(vfsStream::url('root/config.json'));
        $reader->set('test', 5);
        $reader->set('alpha', 'bravo', 5);

        $reader->write();

        $expected = array(
            'test' => 5,
            'alpha' => array(
                'bravo' => 5
            )
        );
        $this->assertEquals($expected, json_decode(file_get_contents(vfsStream::url('root/config.json')), true));
    }
}
