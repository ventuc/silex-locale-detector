<?php

namespace ClaudioVenturini\Silex\LocaleDetector;

class Locale {

	private $language;
	private $country;
	
	public function __construct($locale){
		$matches = array();
		preg_match ("/^([a-zA-Z]+)((?:_|-)([a-zA-Z]+)){0,1}/", $locale, $matches);
		
		$this->language = strtolower($matches[1]);
		$this->country = isset($matches[3])?strtoupper($matches[3]):null;
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

}