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
			$preferredLocales[] = Locale::fromLocaleString($locale);
		}
		
		$this->preferredLocales = $preferredLocales;
	}
	
	/**
	 * Get the locale preferred by the user
	 * 
	 * @return Locale The highest priority
	 * preference, or null if the user has no preference
	 */
	public function getPreferredLocale() {
		$preferred = null;
		
		$preferences = $this->getPreferredLocales();
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
	public function getPreferredLocales(){
		return $this->preferredLocales;
	}
	
	/**
	 * Get the locale preferred by the user among those available,
	 * or the given default locale if none of the user's preferred
	 * locales is available.
	 * 
	 * @param Locale[] $availableLocales The locales available
	 * @param Locale $defaultLocale The default locale
	 * @return Locale The preferred available locale, or the default locale
	 */
	public function getPreferredAvailableLocale(array $availableLocales, Locale $defaultLocale = null) {
		$preferred = $defaultLocale;
		
		$preferences = $this->getPreferredAvailableLocales($availableLocales);
		if (count($preferences)){
			$preferred = $preferences[0];
		}
		
		return $preferred;
	}
	
	/**
	 * Get the user's preferred locale among those available
	 * 
	 * @param Locale[] $availableLocales The locales available
	 * against which to match the user's preferences
	 * @return array Preferences sorted by priority
	 * (from preferences with higher priority to
	 * those with lowest priority)
	 */
	public function getPreferredAvailableLocales(array $availableLocales = null){
		// First search a locale matching exactly (both language and country)
		$preferredAvailableLocales = array();
		foreach ($this->preferredLocales as $locale){
			foreach ($availableLocales as $availableLocale){
				if ($locale->equals($availableLocale)){
					$preferredAvailableLocales[] = $locale;
					break;
				}
			}
		}
		
		// Else search a locale matching only by language
		if (!$preferredAvailableLocales){
			foreach ($this->preferredLocales as $locale){
				foreach ($availableLocales as $availableLocale){
					if ($locale->equalsLanguage($availableLocale)){
						$preferredAvailableLocales[] = $locale;
						break;
					}
				}
			}
		}
		
		return $preferredAvailableLocales;
	}
	
}
