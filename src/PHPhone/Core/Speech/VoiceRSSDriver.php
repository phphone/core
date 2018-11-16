<?php
/**
 * User: Mike Knooihuisen
 * @version 11/15/18
 */

namespace PHPhone\Core\Speech;


use GuzzleHttp\Client;

class VoiceRSSDriver extends TTSDriver
{

	public static function getVoices()
	{
		return [
			"en-us", "ca-es", "zh-cn", "zh-hk", "zh-tw", "da-dk",
			"nl-nl", "en-au", "en-ca", "en_gb", "en-in", "fi-fi",
			"fr-ca", "fr-fr", "de-de", "it-it", "ja-jp", "ko-kr",
			"nb-no", "pl-pl", "pt-br", "pt-pt", "ru-ru", "es-mx",
			"es-es", "sv-se"
		];
	}

	public static function getDefaultVoice()
	{
		return "en-us";
	}

	public static function getKey()
	{
		return "voicerss";
	}

	public function request($filename, $text, $voice)
	{
		$key = env("VOICERSS_KEY");

		if($key === false) {
			throw new \Exception("VoiceRSS API Key missing.  Set it in .env");
			return false;
		}

		try {
			$audio = $this->speech([
				'key' => $key,
				'hl' => $voice,
				'src' => $text,
				'r' => '0',
				'c' => 'wav',
				'f' => '44khz_16bit_stereo',
				'b64' => 'false'
			]);
		} catch (\GuzzleHttp\Exception\GuzzleException $exception) {
			logger()->error("VOICERSS API request Failed!");
			logger()->error($exception->getMessage());
			return false;
		}


		$file = env("ASTERISK_SOUNDS_DIR", '/var/lib/asterisk/sounds');
		$file .= '/' . explode('-', $voice)[0] . '/' . $filename . '.wav';
		file_put_contents($file, $audio);

		return true;

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