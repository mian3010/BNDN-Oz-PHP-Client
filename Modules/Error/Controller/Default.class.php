<?php

class Error_Controller_Default extends CommonController {
  public function Fatal() {
    $t = new Widget_Text("The server encountered an unexpected error.\n&nbsp;\n
      The server could be down. Please try again later");
    $t->style = "color: #A63400; font-weight: bold; font-size: 14px;";
    $t->SetTitle('Fatal error');
    $t->AddOption('Retry', '');
    return $t;
  }
}
