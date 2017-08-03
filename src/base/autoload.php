<?php
/**
 * Created by PhpStorm.
 * User: silen
 * Date: 2017/2/9
 * Time: 23:21
 */

class ClassLoader{

	protected static $_aliases = array();


	/**
	 * Add the aliases to ClassLoader
	 *
	 * @param  array  $aliases
	 * @return bool
	 */
    public static function addAliases($aliases)
    {
        if (is_array($aliases))
        {
            static::$_aliases = array_merge(static::$_aliases, $aliases);
        }
    }

}