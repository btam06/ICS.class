<?php
namespace Itzamna;

/**
 * 
 */
class TextFormatter
{
	/**
	 * Format HTML, strip tags, escape various characters for ICS text safety
	 *
	 * @param string $text The string to format
	 * @return string Formatted text
	 */
	public function __invoke($text) {

		$translations = array(
			"</p>"   => '.\n  ',
			"<br/>"  => '\n',
			"\r\n"   => '\n',
			"&nbsp;" => ' ',
			","      => '\,',
			";"      => '\;',
			":"      => '\:'
		);

		$text = strip_tags($text, '<a>');
		$text = str_replace(array_keys($translations), array_values($translations), $text);
		$text = html_entity_decode($text);

		return $text;
	}
}