<?php

class Widget_ClickEditField extends Widget {
  private $handler = '';
  private $readonly;
  private $label;
  private $field = null;
  private $value;
  public function __construct($value = '', $readonly = false){
    $this->value = $value;
    $this->readonly = $readonly;
  }

  public function GetJs() {
    $js = <<<JAVASCRIPT
      $(window).load(function() {
        $('.click-edit-field .field-value').click(function() {
          $(this).css('display', 'none');
          $(this).parent().find('.field')
            .val($(this).text())
            .css('display', '')
            .focus();
        });
        $('.click-edit-field .field').blur(function() {
          $(this).css('display', 'none');
          $(this).parent().find('.field-value')
            .text($(this).val())
            .css('display', '')
        });
      });
JAVASCRIPT;
    $this->AddJs($js);
    return parent::GetJs();
  }

  public function GetCss() {
    $css = <<<CSS
      .click-edit-field.empty .field-value {
        display: inline-block;
        height: 1em;
        width: 150px;
      }
      .click-edit-field {
        display: inline-block;
      }
CSS;
    $this->AddCss($css);
    return parent::GetCss();
  }

  public function ToHtml() {
    $w = new Widget_Wrapper();
    $w->classes[] = 'click-edit-field';
    if (trim($this->value) == '') $w->classes[] = 'empty';

    //Edit field
    $fl = new Widget_Label($this->value);
    $fl->classes[] = 'field-value';
    if ($this->field == null) $fi = new Widget_InputField($this->value);
    else $fi = $this->field;
    $fi->classes[] = 'field';
    $fi->style = "display:none;";

    //Add to wrapper
    $w->widgets[] = $fl;
    $w->widgets[] = $fi;

    return $w->ToHtml();
  }
}
