<?php
/**
 * User: Mike Knooihuisen
 * @version 11/15/18
 */

namespace PHPhone\Core\Speech;


abstract class TTSDriver implements TTSInterface
{
	protected $filename, $text, $voice;

	/**
	 * @param string $filename the desired ending filename
	 * @param string $text the text to say
	 * @param null $voice the voice to use to speak the text
	 * @throws \Exception if an input is invalid or on generation failure.
	 * @return bool success or failure
	 */
	public function generate($filename, $text, $voice = null) {
		if($voice == null) {
			$voice = self::getDefaultVoice();
		}

		$this->validate($filename, $text, $voice);
		logger(null, "Made it here");
		$result = $this->request($filename, $text, $voice);

		if($result) {
			//TODO: MOdule reload sounds
		} else {
			logger()->error("Could not generate audio file.");
			throw new \Exception("Could not generate audio file.");
		}

		return $result;
	}



	/**
	 * @param string $filename the desired filename to save to
	 * @param string $text the desired speech text
	 * @param string $voice the desired voice to speak the text
	 * @return bool true if validated
	 * @throws \Exception if an input is invalid.
	 */
	private function validate($filename, $text, $voice){
		if($this->text == null || trim($text) == "") {
			logger()->error("No speech text found.  Aborting!");
			throw new \Exception("No speech text found.  Aborting!");
		} else if($filename == null || trim($filename) == "") {
			logger()->error("Invalid filename.  Aborting!");
			throw new \Exception("Invalid filename.  Aborting!");
		} else if(array_search($voice, self::getVoices()) === false) {
			$msg = "Voice invalid.  Valid voices are: ".
				implode(", ", self::getVoices());
			logger()->error($msg);
			throw new \Exception($msg);
		}

		return true;
	}
}