<?php
/**
 * User: Mike Knooihuisen
 * @version 11/12/18
 */

namespace PHPhone\Core;

use \Zend\Log\Logger as ZLoggger;

trait Logger
{
	protected static $logHandler = null;
	protected static $messages = [];
	protected static $levels = [];

	public static function attach($class){
	    self::$logHandler = $class;
	    $levels = self::$levels;
	    $messages = self::$messages;
	    for($i = 0; $i < sizeof(self::$messages); $i++) {
	    	self::log($levels[$i], $messages[$i]);
		}
		self::$messages = [];
	    self::$levels = [];
	}

	public function log($level, $msg)
	{
		if(self::$logHandler == null) {
			self::$messages[] = $msg;
			self::$levels[] = $level;
		} else {
			new self::$logHandler->log($level, $msg);
		}
	}
}