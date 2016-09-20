<?php

namespace ClaudioVenturini\Silex\LocaleDetector;

use Symfony\Component\HttpFoundation\Request;

/**
 * Detect the locale of the user based on the HTTP request
 * 
 * @author Claudio Venturini
 * @copyright Copyright 2016
 */
class LocaleDetector {
	
	private $preferredLocales = null;
	
	public function __construct(Request $request){
		$preferredLocales = array();
		foreach ($request->getLanguages() as $locale){
			$preferredLocales[] = new Locale($locale);
		}
		
		$this->preferredLocales = $preferredLocales;
	}
	
	/**
	 * Get the locale preferred by the user
	 * 
	 * @return LocalePreference The highest priority
	 * preference, or null if the user has no preference
	 */
	public function getUserPreferredLocale() {
		$preferred = null;
		
		$preferences = $this->getUserPreferredLocales();
		if (count($preferences)){
			$preferred = $preferences[0];
		}
		
		return $preferred;
	}
	
	/**
	 * Get the user's preferences on locales
	 * 
	 * @return array Preferences sorted by priority
	 * (from preferences with higher priority to
	 * those with lowest priority)
	 */
	public function getUserPreferredLocales(){
		return $this->preferredLocales;
	}
	
}
