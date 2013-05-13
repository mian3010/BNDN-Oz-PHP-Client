<?php

class Product_Widget_StreamProduct extends Widget_Container {
	
	public function __construct($stream, $type) {
		if(stristr($type, 'video') || stristr($type, 'film')) {
			$vs = new Widget_Video($stream);
			echo $vs->ToHtml();
		}
		else if(stristr($type, 'audio')) {
			
		}
		else if(stristr($type, 'music')) {
			
		}
		else if(stristr($type, 'ebook')) {
			
		}
	}
}
