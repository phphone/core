<?php
/**
 * User: Mike Knooihuisen
 * @version 11/15/18
 */

namespace PHPhone\Core\Speech;


use GuzzleHttp\Client;
use PHPhone\PHPhone\Speech\VoiceRSS;

class VoiceRSSDriver extends TTSDriver
{

	public function getVoices()
	{
		return [
			"en-us", "ca-es", "zh-cn", "zh-hk", "zh-tw", "da-dk",
			"nl-nl", "en-au", "en-ca", "en_gb", "en-in", "fi-fi",
			"fr-ca", "fr-fr", "de-de", "it-it", "ja-jp", "ko-kr",
			"nb-no", "pl-pl", "pt-br", "pt-pt", "ru-ru", "es-mx",
			"es-es", "sv-se"
		];
	}

	public function getDefaultVoice()
	{
		return "en-us";
	}

	public function getKey()
	{
		return "voicerss";
	}

	public function request($filename, $text, $voice)
	{
		return $this->speech([
			'key' => env("VR_KEY"),
			'hl' => $voice,
			'src' => $text,
			'r' => '0',
			'c' => 'mp3',
			'f' => '44khz_16bit_stereo',
			'ssml' => 'false',
			'b64' => 'false'
		]);

	}

	/**
	 * @param $settings
	 * @return string file contents
	 * @throws \GuzzleHttp\Exception\GuzzleException on request failure
	 */
	private function speech($settings) {
		$client = new Client();
		$response = $client->request('POST', "https://api.voicerss.org", [
			'form_params' => [$settings]
		]);
		return $response->getBody()->getContents();
	}
}