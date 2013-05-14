<?php

class Widget_Notifications extends Widget {

  	public function __construct() {
  	
  	}

 	public function ToHtml() {
 		
  		$errors =& $_SESSION['errors'];
  		$info =& $_SESSION['info'];
  		$successes =& $_SESSION['successes'];
  		
  		if(empty($errors) && empty($info) && empty($successes)) return '';
  
  		$html =		'<div id="notifications">';
  					
  		if(!empty($errors)){
  		
  			$html .= '<ul class="error">';
  			
  			while(($msg = array_shift($errors)) !== NULL) $html .= '<li>Error: ' . $msg . '</li>';
  			
  			$html .= '</ul>';
  		}
  		
  		if(!empty($info)){
  		
  			$html .= '<ul class="info">';
  			
  			while(($msg = array_shift($info)) !== NULL) $html .= '<li>Info: ' . $msg . '</li>';
  			
  			$html .= '</ul>';
  		}
  		
  		if(!empty($successes)){
  		
  			$html .= '<ul class="success">';
  			
  			while(($msg = array_shift($successes)) !== NULL) $html .= '<li>Success: ' . $msg . '</li>';
  			
  			$html .= '</ul>';
  		}
  					
  		$html .=	'</div>';
  		
  		return $html;
    }
}
