<?php
/**
 * Widget containing a PDF
 */
class Widget_PDFViewer extends WidgetContainer {
	private $source;
	
	public function __construct($source) {
		$this->source = $source;
	}
	
	public function ToHtml() {
		return '<iframe ' . $this->GetAttributes() . ' src='.$this->source.'></iframe>';
	}
}
