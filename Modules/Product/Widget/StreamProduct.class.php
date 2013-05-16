<?php

class Product_Widget_StreamProduct extends Widget_Container {
	
	public function __construct($src, $product) {
		$this->SetTitle($product->title);
    $this->AddCss('
      .meta{ margin-top:25px; }
      .desc{ word-wrap:normal; width: 280px; }
    ');
		$type = $product->type;

		if(stristr($type, 'video') || stristr($type, 'film')) {
			$streamer = new Widget_Video($src);
		}
		else if(stristr($type, 'audio') || stristr($type, 'music')) {
			$streamer = new Widget_Audio($src);
		}
		else if(stristr($type, 'ebook')) {
			$streamer = new Widget_PDFViewer($src);
		}
    $streamer->width=650;
		
		$slider = new Widget_Slider();
		$slider->SlideRight();

    $thumb = new Product_Widget_ViewThumbnail($product->id);
    $thumb->width = 300;
    $thumb->height = 300;
		$slider->widgets[] = $thumb;

    $rate = new Product_Widget_ViewRating($product);
    $rate->classes[] = 'hasALittleBitOfPadding';
    $rate->classes[] = 'meta';
    $slider->widgets[] = $rate;

    $wDesc = new Widget_Wrapper();
    $desc = new Widget_Paragraph($product->description);
    $wDesc->classes[] = 'hasALittleBitOfPadding';
    $wDesc->classes[] = 'meta';
    $wDesc->classes[] = 'desc';
    $wDesc->widgets[] = $desc;
    $slider->widgets[] = $wDesc;
		
		$this->widgets[] = $streamer;
		$this->widgets[] = $slider;
	}
}
