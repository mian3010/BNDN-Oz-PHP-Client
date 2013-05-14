<?php
class Widget_PDFViewer extends WidgetContainer {
	private $source;
	
	public function __construct($source) {
		$this->source = $source;
	}
	
	public function ToHtml() {
		return '<iframe src='.$this->source.'></iframe>';
	}
}