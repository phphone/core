<?php
/**
 * User: Mike Knooihuisen
 * @version 11/15/18
 */

namespace PHPhone\Core\Speech;


interface TTSInterface
{

	/**
	 * @param string $filename the file name to save to
	 * @param string $text to speak
	 * @param string $voice the voice to use
	 * @return bool true on success, else false
	 */
	public function request($filename, $text, $voice);

	/**
	 * @return string the default voice for the driver
	 */
	public static function getDefaultVoice();

	/**
	 * @return array all available voices for the driver
	 */
	public static function getVoices();

	/**
	 * @return string the key used to identify this driver in commands
	 */
	public static function getKey();

	/**
	 * @return bool whether or not SSML is supported by this driver.
	 */
	public static function supportsSSML();

}