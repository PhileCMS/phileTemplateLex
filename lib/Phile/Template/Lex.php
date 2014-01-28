<?php

namespace Phile\Template;

use Phile\Registry;
use Phile\Event;

class Lex implements TemplateInterface {
	/**
	 * @var array the complete phile config
	 */
	protected $settings;

	/**
	 * @var array the config for lex
	 */
	protected $config;

	/**
	 * @var \Phile\Model\Page
	 */
	protected $page;

	public function __construct($config = null)	{
		if (!is_null($config)) {
			$this->config = $config;
		}
		$this->settings = Registry::get('Phile_Settings');
	}

	public function setCurrentPage(\Phile\Model\Page $page) {
		$this->page = $page;
	}

	private function object_to_array($data) {
		if (is_array($data) || is_object($data)) {
			$result = array();
			foreach ($data as $key => $value) {
				$result[$key] = $this->object_to_array($value);
			}
			return $result;
		}
		return $data;
	}

	public function render() {
		$pageRepository = new \Phile\Repository\Page();
		$output = 'No template found!';
		if (file_exists(THEMES_DIR . $this->settings['theme'])) {
			$parser = new \Lex\Parser();
			$data = array(
				'config' => $this->settings,
				'base_dir' => rtrim(ROOT_DIR, '/'),
				'base_url' => $this->settings['base_url'],
				'theme_dir' => THEMES_DIR . $this->settings['theme'],
				'theme_url' => $this->settings['base_url'] .'/'. basename(THEMES_DIR) .'/'. $this->settings['theme'],
				'site_title' => $this->settings['site_title'],
				'current_page' => array(
					'title' => $this->page->getTitle(),
					'url' => $this->page->getUrl()
					),
				'meta' => $this->page->getMeta()->getAll(),
				'content' => $this->page->getContent()
				);
			// we need to break down this object for Lex
			$pages = $pageRepository->findAll($this->settings);
			$data['pages'] = array();
			for ($i=0; $i < count($pages); $i++) {
				$data['pages'][] = array(
					'title' => $pages[$i]->getTitle(),
					'url' => $pages[$i]->getUrl(),
					'content' => $pages[$i]->getContent(),
					'meta' => $pages[$i]->getMeta()
					);
			}

			Event::triggerEvent('template_engine_registered', array('engine' => &$parser));

			$file = $twig_vars['theme_dir']. '/' . $this->page->getMeta()->get('template').'.html';
			if ($this->page->getMeta()->get('template') !== null && file_exists($file)) {
				$template = $this->page->getMeta()->get('template');
			} else {
				$template = 'index';
			}
			$output = $parser->parse(file_get_contents($data['theme_dir'] . '/' . $template . '.lex'), $data);
		}
		return $output;
	}
}
