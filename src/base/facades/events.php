<?php
/**
 * Created by PhpStorm.
 * User: zhangming
 * Date: 2017/8/14
 * Time: 17:12
 */
/**
 * @see base_events_dispatcher
 */
class base_facades_events extends base_facades_facade
{
    /**
     * The events dispatcher instance
     *
     * @var base_events_dispatcher
     */
    private static $event;

    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor() {
        if (!static::$event)
        {
            static::$event = new base_events_dispatcher();
        }
        return static::$event;
    }
}