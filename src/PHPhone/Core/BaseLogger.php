<?php
/**
 * User: Mike Knooihuisen
 * @version 11/12/18
 */

namespace PHPhone\Core;

use \Zend\Log\Logger;

abstract class BaseLogger
{
	protected static $instance = null;

	public static function getInstance($level = null, $message = null){
		if(self::$instance == null) {
			$class = get_called_class();
			self::$instance = new $class();
			self::$instance->setup();
		}
	    return self::$instance->log($level, $message);
	}

	public abstract function setup();
	public abstract function log($level, $msg);

	public function error($msg)
	{
		return $this->log(Logger::ERR, $msg);
	}

	public function warning($msg)
	{
		return $this->log(Logger::WARN, $msg);
	}

	public function info($msg)
	{
		return $this->log(Logger::INFO, $msg);
	}

	public function emergency($msg)
	{
		return $this->log(Logger::EMERG, $msg);
	}

	public function debug($msg)
	{
		return $this->log(Logger::DEBUG, $msg);
	}

	public function alert($msg)
	{
		return $this->log(Logger::ALERT, $msg);
	}

	public function critical($msg)
	{
		return $this->log(Logger::CRIT, $msg);
	}

	public function notice($msg)
	{
		return $this->log(Logger::NOTICE, $msg);
	}
}