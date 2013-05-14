<?php

class Product_Widget_StreamProduct extends Widget_Container {
	
	public function __construct($src, $type) {
		if(stristr($type, 'video') || stristr($type, 'film')) {
			$this->widgets[] = new Widget_Video($src);
		}
		else if(stristr($type, 'audio') || stristr($type, 'music')) {
			$this->widgets[] = new Widget_Audio($src);
		}
		else if(stristr($type, 'ebook')) {
			$this->widgets[] = new Widget_PDFViewer($src);
		}
	}
}
