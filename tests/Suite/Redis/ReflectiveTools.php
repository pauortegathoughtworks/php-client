<?php

namespace SplitIO\Test\Suite\Redis;

use ReflectionClass;

class ReflectiveTools
{
    public static function cacheFromFactory(\SplitIO\Sdk\Factory\SplitFactory $factory)
    {
        $reflectionFactory = new ReflectionClass('\SplitIO\Sdk\Factory\SplitFactory');
        $reflectionCache = $reflectionFactory->getProperty('cache');
        $reflectionCache->setAccessible(true);
        return $reflectionCache->getValue($factory);
    }

    public static function clientFromFactory(\SplitIO\Sdk\Factory\SplitFactory $factory)
    {
        $reflectionFactory = new ReflectionClass('\SplitIO\Sdk\Factory\SplitFactory');
        $reflectionCache = $reflectionFactory->getProperty('cache');
        $reflectionCache->setAccessible(true);
        $cachePool = $reflectionCache->getValue($factory);

        $reflectionPool = new ReflectionClass('\SplitIO\Component\Cache\Pool');
        $reflectionAdapter = $reflectionPool->getProperty('adapter');
        $reflectionAdapter->setAccessible(true);
        $adapter = $reflectionAdapter->getValue($cachePool);

        $reflectionSafeRedis = new ReflectionClass('SplitIO\Component\Cache\Storage\Adapter\SafeRedisWrapper');
        $reflectionCacheAdapter= $reflectionSafeRedis->getProperty('cacheAdapter');
        $reflectionCacheAdapter->setAccessible(true);
        $adapter = $reflectionCacheAdapter->getValue($adapter);

        $reflectionPRedis = new ReflectionClass('SplitIO\Component\Cache\Storage\Adapter\PRedis');
        $reflectionClient= $reflectionPRedis->getProperty('client');
        $reflectionClient->setAccessible(true);
        return $reflectionClient->getValue($adapter);
    }

    public static function clientFromCachePool(\SplitIO\Component\Cache\Pool $cachePool)
    {
        $reflectionPool = new ReflectionClass('\SplitIO\Component\Cache\Pool');
        $reflectionAdapter = $reflectionPool->getProperty('adapter');
        $reflectionAdapter->setAccessible(true);
        $adapter = $reflectionAdapter->getValue($cachePool);

        $reflectionSafeRedis = new ReflectionClass('SplitIO\Component\Cache\Storage\Adapter\SafeRedisWrapper');
        $reflectionCacheAdapter= $reflectionSafeRedis->getProperty('cacheAdapter');
        $reflectionCacheAdapter->setAccessible(true);
        $adapter = $reflectionCacheAdapter->getValue($adapter);

        $reflectionPRedis = new ReflectionClass('SplitIO\Component\Cache\Storage\Adapter\PRedis');
        $reflectionClient= $reflectionPRedis->getProperty('client');
        $reflectionClient->setAccessible(true);
        return $reflectionClient->getValue($adapter);
    }
}
