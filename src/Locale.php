<?php

namespace ClaudioVenturini\Silex\LocaleDetector;

class Locale {

	private $language;
	private $country;
	
	public function __construct($language, $country = null){
		$this->language = strtolower($language);
		if ($country){
			$this->country = strtoupper($country);
		}
	}
	
	public function getLanguage() {
		return $this->language;
	}
	
	public function getCountry() {
		return $this->country;
	}
	
	public function getLocale(){
		$locale = $this->getLanguage();
		if ($this->getCountry() != null){
			$locale .= "_" . $this->getCountry();
		}
		
		return $locale;
	}
	
	public function equals(Locale $other){
		return ($this->getLocale() === $other->getLocale());
	}
	
	public function equalsLanguage(Locale $other){
		return ($this->getLanguage() === $other->getLanguage());
	}
	
	/**
	 * Parse a locale from a locale string
	 * 
	 * @param string $localeString The locale string (e.g. "it_IT")
	 * @return Locale The locale
	 */
	public static function fromLocaleString($localeString){
		$matches = array();
		preg_match ("/^([a-zA-Z]+)((?:_|-)([a-zA-Z]+)){0,1}/", $localeString, $matches);
		
		return new static(strtolower($matches[1]), isset($matches[3])?strtoupper($matches[3]):null);
	}
	
	/**
	 * Parse a set of locales from locales strings
	 *
	 * @param string[] $localesStrings The locales strings (e.g. "it_IT")
	 * @return Locale[] The locales
	 */
	public static function fromLocalesStrings(array $localesStrings){
		$locales = array();
		
		foreach ($localesStrings as $localeString){
			$locales[] = static::fromLocaleString($localeString);
		}
		return $locales;
	}

}