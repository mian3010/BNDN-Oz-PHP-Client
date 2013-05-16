<?php

/*
 * Get a small Widget of Product for showing in a list
 */
class Account_Widget_SmallViewAccount extends Widget_Wrapper {
  public function __construct($account) {
    $this->classes[] = 'clearfix';
    $this->classes[] = 'small-account';
    $this->classes[] = 'hasLargeTitle';
    $css = <<<CSS
      .small-account-text {
        height: 100px;
        margin-right: 100px;
      }
      .small-account {
        width: 295px;
        margin: 10px 10px 10px 0;
        position: relative;
      }
      .small-account-inner {
        border: 1px dashed #000;
      }
      .small-account-inner img {
        margin-right: 10px;
      }
CSS;
    $this->AddCss($css);
    $this->wrapperTitle = $account->user;

    $tw = new Widget_Link("Account/View/".$account->user);
    $t = new Account_Widget_ViewThumbnail($account->id);
    $t->classes[] = 'left';
    $tw->widgets = array($t);

    $tx = new Widget_Text(isset($account->about_me) ? $account->about_me : '');
    $tx->classes[] = 'small-account-text';

    $w = new Widget_Wrapper();
    $w->classes[] = 'small-account-inner';
    $w->classes[] = 'hasALittleBitOfPadding';

    $w->widgets[] = $tw;
    $w->widgets[] = $tx;
    $this->widgets[] = $w;
  }
}
