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
  public function render() {
    return "Hello deudes";
  }

  /**
   * Render the container defining content of the page
   * @return HTML to output
   */
  public function renderContainer() {
    return $this->container->ToHtml();
  }
}
