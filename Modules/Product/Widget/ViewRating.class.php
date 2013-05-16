<?php

class Product_Widget_ViewRating extends Widget_Wrapper {
  public function __construct($product, $height = 20, $width = 20) {
    $this->title = $product->rating->score." from ".$product->rating->count." votes";
    $goodPct = ($product->rating->score > 0) ? $product->rating->score/5*100 : 0;
    $badPct  = ($product->rating->score < 0) ? abs($product->rating->score)/5*100 : 0;
    $img["good"]    = new Widget_Image('static/img/good.png');
    $img["goodF"]   = new Widget_Image('static/img/good_f.png');
    $img["bad"]     = new Widget_Image('static/img/bad.png');
    $img["badF"]    = new Widget_Image('static/img/bad_f.png');
    $img["neutral"] = new Widget_Image('static/img/neutral.png');
    foreach ($img as $i) {
      $i->height = $height;
      $i->width = $width;
      $i->ToHtml();
    }

    $this->AddCss('.part-wrapper { position: relative; }');
    $this->AddCss('.wrapper, .f-wrapper { height: '.$height.'px; }');
    $this->AddCss('.f-wrapper { position: absolute; top: 0; left: 0; }');
    $this->AddCss('.good-wrapper, .bad-wrapper { width: '.($width*5).'px; }');
    $this->AddCss('.neutral-wrapper { width: '.$width.'px; display: block; }');
    $this->AddCss('.good-wrapper { background: url('.$img["good"]->src.'); }');
    $this->AddCss('.good-f-wrapper { background: url('.$img["goodF"]->src.'); }');
    $this->AddCss('.bad-wrapper { background: url('.$img["bad"]->src.'); }');
    $this->AddCss('.bad-f-wrapper { right: 0; left: auto; background: url('.$img["badF"]->src.'); background-position: right; }');
    $this->AddCss('.neutral-wrapper { background: url('.$img["neutral"]->src.'); }');
    
    $gw = new Widget_Wrapper();
    $gw->classes[] = 'part-wrapper';
    $gwnf = new Widget_Wrapper();
    $gwnf->classes[] = 'wrapper good-wrapper';
    $gwf = new Widget_Wrapper();
    $gwf->classes[] = 'f-wrapper good-f-wrapper';
    $gwf->style = 'width: '.$goodPct.'%;';
    $gw->classes[] = 'left';
    $gw->widgets = array($gwnf, $gwf);

    for ($i = 5; $i > 0; $i--) {
      $ghw = new Widget_Link('Product/Rate/'.$product->id.'/'.$i);
      $ghw->classes[] = 'good-hover-'.$i;
      $ghw->classes[] = 'f-wrapper good-hover';
      $ghw->AddCss('.good-hover-'.$i.' { width: '.(100/5*$i).'%; }');
      $gw->widgets[] = $ghw;
    }
    $this->AddCss('.good-hover { background: none; }');
    $this->AddCss('.good-hover:hover { background: url('.$img["goodF"]->src.'); }');

    $nw = new Widget_Link('Product/Rate/'.$product->id.'/0');
    $nw->classes[] = 'wrapper neutral-wrapper';
    $nw->classes[] = 'left';

    $bw = new Widget_Wrapper();
    $bw->classes[] = 'part-wrapper';
    $bwnf = new Widget_Wrapper();
    $bwnf->classes[] = 'wrapper bad-wrapper';
    $bwf = new Widget_Wrapper();
    $bwf->classes[] = 'f-wrapper bad-f-wrapper';
    $bwf->style = 'width: '.$badPct.'%;';
    $bw->classes[] = 'left';
    $bw->widgets = array($bwnf, $bwf);

    for ($i = -5; $i < 0; $i++) {
      $bhw = new Widget_Link('Product/Rate/'.$product->id.'/'.$i);
      $bhw->classes[] = 'bad-hover-'.$i;
      $bhw->classes[] = 'f-wrapper bad-hover';
      $bhw->AddCss('.bad-hover-'.$i.' { width: '.(100/5*abs($i)).'%; }');
      $bw->widgets[] = $bhw;
    }
    $this->AddCss('.bad-hover { right: 0; left: auto; background: none; }');
    $this->AddCss('.bad-hover:hover { background: url('.$img["badF"]->src.'); }');
    
    $this->widgets[] = $bw;
    $this->widgets[] = $nw;
    $this->widgets[] = $gw;
  }
}
