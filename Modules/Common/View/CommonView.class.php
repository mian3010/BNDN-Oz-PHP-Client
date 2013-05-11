<?php

class CommonView {
  private $container;

  /**
   * Constructor. Taking the container defining the content of the page
   */
  public function __construct($container) {
    $this->container = $container;
  }

  /**
   * Render the page
   * @return HTML to output
   */
  public function Render() {
  
  	$container = $this->container;
    $containerHtml = $this->RenderContainer();
    
    $footer = new Common_Widget_Footer();
    $footerHtml = $footer->ToHtml();
    
    // $container is able to overwrite $footer
    $css = $container->GetCss() + $footer->GetCss();
    $cssFiles = $container->GetCssFiles() + $footer->GetCssFiles();
    $js = $container->GetJs() + $footer->GetJs();
    $jsFiles = $container->GetJsFiles() + $footer->GetJsFiles();
    
    $header = new Common_Widget_Header($css, $cssFiles, $js, $jsFiles);
    $header->SetTitle($this->container->GetTitle());
    
    foreach($this->container->GetOptions() as $text => $url) $header.AddOptions($text, $url);
        
    $headerHtml = $header->ToHtml();
    
    return $headerHtml . $containerHtml . $footerHtml;
  }

  /**
   * Render the container defining content of the page
   * @return HTML to output
   */
  public function RenderContainer() {
    return $this->container->ToHtml();
  }
  
  
}
