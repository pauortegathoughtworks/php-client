<?php
namespace SplitIO\Component\Common;

use Psr\Log\LoggerInterface;
use SplitIO\Component\Cache\Pool;

/**
 * Class Di
 * @package SplitIO\Common
 */
class Di
{
    const KEY_LOG = 'SPLIT-LOGGER';

    const KEY_FACTORY_TRACKER = 'FACTORY-TRACKER';

    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * @var array
     */
    private $container = array();

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return self The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    public function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    public function __wakeup()
    {
    }

    /**
     * @param $key
     * @param $instance
     */
    private function setKey($key, $instance)
    {
        $this->container[$key] = $instance;
    }

    /**
     * @param $key
     * @return mixed
     */
    private function getKey($key)
    {
        return (isset($this->container[$key])) ? $this->container[$key] : null;
    }

    /**
     * Set an object instance with its key
     * @param $key
     * @param $instance
     */
    public static function set($key, $instance)
    {
        self::getInstance()->setKey($key, $instance);
    }

    /**
     * Given a key returns the object instance associated with this.
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        return self::getInstance()->getKey($key);
    }


    /**
     * @param LoggerInterface $logger
     */
    public static function setLogger($logger)
    {
        self::set(self::KEY_LOG, $logger);
    }

    /**
     * @return null|\Psr\Log\LoggerInterface
     */
    public static function getLogger()
    {
        return self::get(self::KEY_LOG);
    }
}
