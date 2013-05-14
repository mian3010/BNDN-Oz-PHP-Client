<?php

class Product_Widget_StreamProduct extends Widget_Container {
	
	public function __construct($src, $product) {
		$this->SetTitle($product->title);
		$type = $product->type;
		
		$streamer = null;
		if(stristr($type, 'video') || stristr($type, 'film')) {
			$streamer = new Widget_Video($src);
		}
		else if(stristr($type, 'audio') || stristr($type, 'music')) {
			$streamer = new Widget_Audio($src);
		}
		else if(stristr($type, 'ebook')) {
			$streamer = new Widget_PDFViewer($src);
		}
		
		$slider = new Widget_Slider();
		$slider->SlideRight();
		
		$slider->widgets[] = new Product_Widget_ViewThumbnail($product->id);
		//$slider->widgets[] = new Product_Widget_ViewRating("Add rating widget!");
		$slider->widgets[] = new Widget_Label("Insert rating");
		$slider->widgets[] = new Widget_Paragraph($product->description);
		
		$this->widgets[] = $streamer;
		$this->widgets[] = $slider;
	}
}
