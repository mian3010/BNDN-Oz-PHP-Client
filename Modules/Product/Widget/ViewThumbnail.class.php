<?php

class Product_Widget_ViewThumbnail extends Widget_Container {
		public function __construct($id) {
			$thumb = new Widget_Image("http://rentit.itu.dk/RentIt27/RentItService.svc/products/".$id."/thumbnail");
			$thumb->width = 100;
			$thumb->height = 100;
				
			$this->widgets[] = $thumb;
		}
}
