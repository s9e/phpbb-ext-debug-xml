<?php

/**
* @package   s9e\debugxml
* @copyright Copyright (c) 2020 The s9e authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\debugxml;

use DOMDocument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return ['core.text_formatter_s9e_render_before' => 'onRender'];
	}

	public function onRender($event)
	{
		$useErrors = libxml_use_internal_errors(true);
		$dom = new DOMDocument;
		$success = $dom->loadXML($event['xml']);
		libxml_use_internal_errors($useErrors);
		if ($success)
		{
			return;
		}

		$event['xml'] = '<r><CODE>' . htmlspecialchars(print_r(libxml_get_last_error(), true)) . '</CODE><CODE lang="xml">' . htmlspecialchars($event['xml']) . '</CODE></r>';
	}
}
