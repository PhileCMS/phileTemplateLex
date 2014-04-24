<?php
/**
 * Plugin class
 */
namespace Phile\Plugin\Phile\TemplateLex;

/**
 * Lex Phile template engine
 */
class Plugin extends \Phile\Plugin\AbstractPlugin implements \Phile\Gateway\EventObserverInterface {
	public function __construct() {
		\Phile\Event::registerEvent('plugins_loaded', $this);
	}

	public function on($eventKey, $data = null) {
		// check $eventKey for which you have registered
		if ($eventKey == 'plugins_loaded') {
			\Phile\ServiceLocator::registerService('Phile_Template', new \Phile\Plugin\Phile\TemplateLex\Template\Lex($this->settings));
		}
	}
}
