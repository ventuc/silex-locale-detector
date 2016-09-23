<?php

namespace ClaudioVenturini\Silex\LocaleDetector;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Silex\Application;

/**
 * Provider for the Language Detector service
 * 
 * @author Claudio Venturini
 * @copyright Copyright 2016
 */
class LocaleDetectorProvider implements ServiceProviderInterface {
	
	public function register(Container $container) {
		$container['locale.detector'] = (function (Application $app) {
			return new LocaleDetector($app['request_stack']->getCurrentRequest());
		});
	}
	
}