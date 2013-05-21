<?php

class Error_Controller_Default extends CommonController {
  public function Fatal() {
    $t = new Widget_Text("The server encountered an unexpected error.\n&nbsp;\n
      You have been redirected to this page to avoid calling the server again, failing and redirecting.\n&nbsp;\n
      The cause could be that the server is down. Please try again later");
    $t->style = "color: #ff5b5b; font-weight: bold; font-size: 14px;";
    $t->SetTitle('Fatal error');
    $t->AddOption('Retry', '');
    return $t;
  }
}
