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
  			
  			while($msg = array_shift($errors)) $html .= '<li>' . $msg . '</li>';
  			
  			$html .= '</ul>';
  		}
  		
  		if(!empty($info)){
  		
  			$html .= '<ul class="info">';
  			
  			while($msg = array_shift($info)) $html .= '<li>' . $msg . '</li>';
  			
  			$html .= '</ul>';
  		}
  		
  		if(!empty($successes)){
  		
  			$html .= '<ul class="success">';
  			
  			while($msg = array_shift($successes)) $html .= '<li>' . $msg . '</li>';
  			
  			$html .= '</ul>';
  		}
  					
  		$html .=	'</div>';
  		
  		return $html;
    }
}
