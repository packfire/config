<?php /*
 * Copyright (C) 2014 Sam-Mauris Yong. All rights reserved.
 * This file is part of the Packfire Config component project, which is released under New BSD 3-Clause license.
 * See file LICENSE or go to http://opensource.org/licenses/BSD-3-Clause for full license details.
 */

namespace Packfire\Config;

/**
 * A generic configuration file
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Packfire\Config
 * @since 1.0.0
 */
class Config implements ConfigInterface
{
    /**
     * The data read from the configuration file
     * @var array
     * @since 1.0.0
     */
    protected $data = array();

    /**
     * Set the defaults for missing configuration
     * @param \Packfire\Config\ConfigInterface $defaults The default configuration to place
     * @since 1.0.0
     */
    public function defaults(ConfigInterface $defaults)
    {
        $this->data = ArrayUtility::mergeRecursiveDistinct($defaults->get(), $this->data);
    }

    /**
     * Merge the configuration from the other Config
     * @param \Packfire\Config\ConfigInterface $config The configuration to merge in
     * @since 1.2.0
     */
    public function merge(ConfigInterface $config)
    {
        $this->data = ArrayUtility::mergeRecursiveDistinct($this->data, $config->get());
    }

    /**
     * Get the value from the configuration file.
     *
     * You can get values nested inside arrays by entering multiple keys as
     * arguments to the method.
     *
     * Example:
     * <code>$value = $config->get('app', 'name'); // $data = array('app' => array('name' => 'Packfire')); </code>
     * <code>$value = $config->get('database', 'default', 'host'); // $data = array('database' => array('default' => array('host' => 'localhost'))); </code>
     *
     * @param string $key,... The key of the data to load.
     * @return mixed Returns the data read or NULL if the key is not found.
     * @since 1.0.0
     */
    public function get()
    {
        $keys = func_get_args();
        $data = $this->data;
        foreach ($keys as $key) {
            if (is_array($data)) {
                if (isset($data[$key])) {
                    $data = $data[$key];
                } else {
                    $data = null;
                    break;
                }
            } else {
                break;
            }
        }
        return $data;
    }

    /**
     * Set a value to the configuration data
     *
     * You can set values nested inside arrays by entering multiple keys as
     * arguments to the method.
     *
     * Example:
     * <code>$config->set('app', 'name', 'Packfire'); </code>
     * <code>$config->set('database', 'default', 'host', 'localhost');</code>
     *
     * @param string $key,... The key of the data to load.
     * @param mixed $value,... The value to set
     * @since 1.0.2
     * @return void
     */
    public function set($key, $value)
    {
        $keys = func_get_args();
        $value = array_pop($keys);
        $this->setValueRecursive($this->data, $keys, $value);
    }

    protected function setValueRecursive(&$scope, $keys, $value)
    {
        $key = array_shift($keys);
        if ($keys) {
            if (!isset($scope[$key]) || null === $scope[$key]) {
                $scope[$key] = array();
            }
            $this->setValueRecursive($scope[$key], $keys, $value);
        } else {
            $scope[$key] = $value;
        }
    }
}
