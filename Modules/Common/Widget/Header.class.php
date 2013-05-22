<?php
/**
 * Widget for displaying the header. Must not be used without using the footer after
 */
class Widget_Header extends Widget {

  	public function __construct($css = array(), $cssFiles = array(), $js = array(), $jsFiles = array()) {
  
  		foreach($css as $id => $styling) $this->AddCss($styling, $id);
  		foreach($cssFiles as $id => $path) $this->AddCssFile($path, $id);
  	
  		foreach($js as $id => $code) $this->AddJs($code, $id);
  		foreach($jsFiles as $id => $path) $this->AddJsFile($path, $id);
  	}

 	public function ToHtml() {
    	$pageClass = $this->producePageClass();
    	
    	$notifications = new Widget_Notifications();
    	$notificationsHtml = $notifications->ToHtml();
    
    	$menuLinks = '';
    	$menuLinks .= $this->produceLink('Account/Dashboard', 'Dashboard', 'Dashboard', 1);
    	$menuLinks .= $this->produceLink('Product/ViewTypes', 'Browse products', 'Browse products', 1);
    	$menuLinks .= $this->produceLink('Account/ViewAll', 'View accounts', 'View accounts', 1);
        if ($_GET[0] != "Error" && $_GET[1] != "Fatal") {
          $ac = new Auth_Controller_Default();
          $login = $ac->Login();
          $username = 'Login';
          if(isset($_SESSION['username'])) $username = $_SESSION['username'];
          $mouse = new Widget_ClickBox($username);
          $mouse->widgets[] = $login;
          $mouse->AddCss('#' . $mouse->id . '{ float:right; }');
 
          foreach ($mouse->GetCss() as $css) $this->AddCss($css);
          foreach ($mouse->GetJs() as $js) $this->AddJs($js);
          $menuLinks .= $mouse->ToHtml();
        }
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

            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        
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
            		' . $notificationsHtml . '
            		<section id="main">
                		<article class="simple">
                    		<header>
                        		<h1>' . $pageTitle . '</h1>
                        		<nav>
                            		' . $pageLinks . '
                        		</nav>
                    		</header>
                    		<section class="clearfix">';
	}

  /**
   * Get the path for a css file
   * @param $path The file
   * @return the full path
   */
  private function expandCssPath($path) {
		return 'static/css/' . $path;
	}
	
  /**
   * Get the path for a js file
   * @param $path The file
   * @return the full path
   */
	private function expandJsPath($path) {
		return 'static/js/' . $path;
	}
	
  /**
   * Produce the page classes from module and method
   * @return The string containing the classes
   */
	private function producePageClass() {
		if(!empty($_GET[0])) {
		
			$result = "page-" . $_GET[0] . '-';
			
			if(!empty($_GET[1])) return $result . $_GET[1];
			else return $result . 'default';
		}
		else return 'page-default-default';
	}

  /**
   * Produce the css to put on page
   * @param $css Array containing css from page
   * @param $cssFile Array of files to include on page
   * @return string containing all styles and includes
   */
	private function produceCss($css, $cssFiles) {
		$result = '';
		
		foreach($cssFiles as $path) $result .= '<link rel="stylesheet" type="text/css" href="'. $this->expandCssPath($path) . '" />';
		foreach($css as $code) $result .= '<style type="text/css">' . $code . '</style>';
		
		return $result;
	}

  /**
   * Produce the js to put on page
   * @param $js Array containing the js from page
   * @param @$jsFiles Array containing the files to include on page
   * @return string containing all js and includes
   */
	private function produceJs($js, $jsFiles) {
	
    $result = '';
		
		foreach($jsFiles as $path) $result .= '<script type="text/javascript" src="'. $this->expandJsPath($path) . '"></script>';
		foreach($js as $code) $result .= '<script type="text/javascript">' . $code . '</script>';
		
		return $result;
	}

  /**
   * Produce a link from path, text, title and tabindex
   * @param $url The path of the link
   * @param $text The text the link should contain
   * @param $title The title of the link
   * @param $tab The tabindex
   * @return html link
   */
	private function produceLink($url, $text = null, $title = null, $tab = null) {
	
		$url = UriController::GetBasePath(true) . $url;
		
		if($text === null) $text = $url;
		if($title === null) $title = $text;
	
		return '<a title="' . $title . '" href="' . $url . '" ' . ($tab !== null ? 'tabindex="' . $tab .'"' : '') . '>' . $text . '</a>';
	}

  /**
   * Produce the page links to put on page
   * @param $options Array of links
   * @return HTML for the links
   */
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
