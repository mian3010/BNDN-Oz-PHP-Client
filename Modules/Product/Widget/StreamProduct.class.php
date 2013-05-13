<?php

class Product_Widget_StreamProduct extends Widget_Container {
	
	public function __construct($stream, $type) {
		if(stristr($type, 'video')) {
			$vs = new Widget_Video($stream);
			$vs->ToHtml();
		}
		else if(stritr($type, 'audio')) {
			
		}
		else if(stristr($type, 'music')) {
			
		}
		else if(stristr($type, 'ebook')) {
			
		}
	}
}
