<?php
class Widget_Audio extends WidgetContainer {
	private $source;
	
	public function __construct($source) {
		$this->source = $source;
	}
	
	public function ToHtml() {
		return '<audio controls ' . $this->GetAttributes() . '><source src='.$this->source.'></audio>';
	}
}