<?php

namespace Packfire\Config\Driver;

use org\bovigo\vfs\vfsStream;

/**
 * Test class for YamlConfig.
 * Generated by PHPUnit on 2012-07-14 at 06:11:25.
 */
class YamlTest extends ConfigTestSetter
{
    protected function setUp()
    {
        $this->prepare('Packfire\\Config\\Driver\\Yaml');
    }

    public function testRead()
    {
        $data = <<<EOT
---
test:
  data: 5
  route: false
...
EOT;
        
        $root = vfsStream::setup('root');
        $file = vfsStream::newFile('config.yml');
        $root->addChild($file);
        $file->withContent($data);

        $reader = new Yaml(vfsStream::url('root/config.yml'));
        $reader->read();

        $this->assertEquals(array('test' => array('data' => 5, 'route' => false)), $reader->get());
    }
}
