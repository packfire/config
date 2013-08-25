<?php

/**
 * Packfire Framework for PHP
 * By Sam-Mauris Yong
 *
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) Sam-Mauris Yong <sam@mauris.sg>
 * All rights reserved.
 */

namespace Packfire\Config\Driver;

use Packfire\Config\Config;
use Camspiers\JsonPretty\JsonPretty;

/**
 * A JSON configuration file that returns an array of configuration information.
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Packfire\Config\Driver
 * @since 1.0.0
 */
class Json extends Config
{
    /**
     * {@inheritdoc}
     */
    public function read()
    {
        $this->data = json_decode(file_get_contents($this->file), true);
    }

    /**
     * {@inheritdoc}
     */
    public function write($file = null)
    {
        $jsonPretty = new JsonPretty();
        $output = $jsonPretty->prettify($this->data);
        file_put_contents($file ? $file : $this->file, $output);
    }
}
