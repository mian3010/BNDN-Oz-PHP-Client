<?php
class Widget_Audio extends WidgetContainer {
	private $source;
	
	public function __construct($source) {
		$this->source = $source;
	}
	
	public function ToHtml() {
		return '<audio controls><source src='.$this->source.'></audio>';
	}
}