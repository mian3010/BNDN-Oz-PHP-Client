<?php

class Common_Widget_Header extends Widget {

  	public function __construct($css = array(), $cssFiles = array(), $js = array(), $jsFiles = array()) {
  
  		foreach($css as $id => $styling) $this->AddCss($styling, $id);
  		foreach($cssFiles as $id => $path) $this->AddCssFile($path, $id);
  	
  		foreach($js as $id => $styling) $this->AddJs($code, $id);
  		foreach($jsFiles as $id => $path) $this->AddJsFile($path, $id);
  	}

 	public function ToHtml() {
  
    	$pageClass = $this->producePageClass();
    
    	$menuLinks = '';
    	$menuLinks .= $this->produceLink('Product/Browse', 'Browse', 'Browse', 1);
    	
    	// Should be invisible if not logged in with a proper role
    	// $menuLinks .= $this->produceLink('URL_HERE', 'My RentIt', 'MyRentIt', 1);
    	// $menuLinks .= $this->produceLink('URL_HERE', 'Admin', 'Admin', 1);
                    
        $pageTitle = $this->GetTitle();
    	$pageLinks = $this->producePageLinks($this->GetOptions());
    	
    	$title = 'RentIt';
    	if(!empty($pageTitle)) $title = $pageTitle . ' :: ' . $title;
    	
   		$css = $this->produceCss($this->GetCss(), $this->GetCssFiles());
    	$js = $this->produceJs($this->GetJs(), $this->GetJsFiles());
  
    	return '
    		<html><head>
    		    <meta charset="utf-8" />
        
    		    <title>' . $title . '</title>
        
     		    <base href="' . UriController::GetBasePath() . '" />
    
        		<!-- Base styling which must come before any styling added by widget -->
        		<link rel="stylesheet" type="text/css" href="'. $this->expandCssPath('reset.css') . '" />
        		<link rel="stylesheet" type="text/css" href="'. $this->expandCssPath('styling.css') . '" />
        
        		' . $css . '
        		' . $js . '
        
    		</head>
    		<body>
        		<div class="' . $pageClass . '" id="site">
            		<header>
                		<nav>
                    		' . $menuLinks . '
                		</nav>
            		</header>
            		<section id="main">
                		<article class="simple">
                    		<header>
                        		<h1>' . $pageTitle . '</h1>
                        		<nav>
                            		' . $pageLinks . '
                        		</nav>
                    		</header>
                    		<section>';
	}
	
	public function SetTitle($title){
	
		parent::SetTitle($title);
	}
	
	public function AddOption($text, $url){
	
		parent::AddOption($text, $url);
	}
	
	private function expandCssPath($path) {
	
		return 'static/css/' . $path;
	}
	
	private function expandJsPath($path) {
	
		return 'static/js/' . $path;
	}
	
	private function producePageClass() {
	
		if(!empty($_GET[0])) {
		
			$result = "page-" . $_GET[0] . '-';
			
			if(!empty($_GET[1])) return $result . $_GET[1];
			else return $result . 'default';
		}
		else return 'page-default-default';
	}
	
	private function produceCss($css, $cssFiles) {
	
		$result = '';
		
		foreach($cssFiles as $path) $result .= '<link rel="stylesheet" type="text/css" href="'. $this->expandCssPath($path) . '" />\n';
		foreach($css as $code) $result .= '<style type="text/css">\n' . $code . '\n</style>\n';
		
		return $result;
	}
	
	private function produceJs($js, $jsFiles) {
	
		$result = '';
		
		foreach($jsFiles as $path) $result .= '<script type="text/javascript" src="'. $this->expandJsPath($path) . '"></script>\n';
		foreach($js as $code) $result .= '<script type="text/javascript">\n' . $code . '\n</script>\n';
		
		return $result;
	}
	
	private function produceLink($url, $text = null, $title = null, $tab = null) {
	
		$url = UriController::GetBasePath(true) . $url;
		
		if($text === null) $text = $url;
		if($title === null) $title = $text;
	
		return '<a title="' . $title . '" href="' . $url . '" ' . ($tab !== null ? 'tabindex="' . $tab .'"' : '') . '>' . $text . '</a>';
	}
	
	private function producePageLinks($options) {
	
		if(count($options) == 0) return '';
	
		$optionTexts = array_keys($options);
		$optionUrls = array_values($options);
	
		$alsoSelect = count($options) > 4;
		$limit = $alsoSelect ? 3 : count($options);
		
		$result = '';
		
		for($i = 0; $i < $limit; $i++){
			
			$text = array_shift($optionTexts);
			$url = array_shift($optionUrls);
			
			$result .= $this->produceLink($url, $text, null, 3);
		}
		
		if($alsoSelect){
		
			array_unshift($optionTexts, 'More...');
			array_unshift($optionUrls, 'javascript:;');
		
			$selector = new Common_Widget_NavigationOption(array_combine($optionTexts, $optionUrls));
			$result .= $selector->ToHtml();
		}
		
		return $result;
		
	}
}