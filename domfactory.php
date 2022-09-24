<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Class for creating HTML Documents
class DomFactory
{

  public $head;
  public $bodyTop;
  public $bodyContent;
  public $bodyBottom;
  public $document;

  function __construct($title="Blank Page")
    {
      $this->head = "<title>" . $title . "</title>";
      $this->bodyTop = "";
      $this->bodyContent = "";
      $this->bodyBottom = "";
      $this->document;
    }

  //Create a dom elmenent such as div, span, p, select, form
  public function castElement($append, $content="", $type="div", $class="", $id="", $lbr=false, $name="", $style="", $additionalAttributes="")
    {
      $element = '<' . $type;
                      if($class != ""){ $element .= ' class="' . $class . '"'; }
                      if($id != ""){ $element .= ' id="' . $id . '"'; }
                      if($name != ""){ $element .= ' name="' . $name . '"'; }
                      if($style != ""){ $element .= ' style="' . $style . '"'; }
                      if($additionalAttributes != ""){ $element .= ' ' .  $additionalAttributes; }
                      if($type == "input" || $type == "br"){ $element .= ' /'; }
      $element .= '>';

      if ($lbr == "br")
        {
        $content = str_replace(array("\r\n","\n"),'<br>', $content);
        }
      elseif ($lbr == "p")
        {
          $content = "<p>" . $content;
          $content = str_replace(array("\r\n","\n"),'</p><p>', $content);
          $content .= "</p>";
        }

      if($type !== "input" && $type !== "br"){ $element .= $content; }

      if($type !== "input" && $type !== "br"){ $element .= '</' . $type . '>'; }

      if($append == true)
        {
          $this->bodyContent .= $element;
        }
      else
        {
          return $element;
        }

    }

  //Insert additional options into a select element
  public function SelectInjectOption($append, $element="<select></select>", $value="", $content="", $selected=false)
    {
      $option = '<option value="' . $value . '"';
      if ($selected == true)
        {
          $option .= " selected>";
        }
      else
        {
          $option .= ">";
        }

      $option .= $content;

      $option .= "</option>";

      $element = str_replace("</select>", $option . "</select>", $element);

      if($append == true)
        {
          $this->bodyContent .= $element;
        }
      else
        {
          return $element;
        }

    }

  //Append meta elements to the document head
  public function addMeta($append, $name="", $content="", $charset="")
    {
      $metatag =  "<meta ";
      if($name !== ""){$metatag .= 'name="'. $name .'"';
                       $metatag .= 'content="'. $content .'"';}
      if($charset !== ""){$metatag .= 'charset="'. $charset .'"';}
      $metatag .= ">";

      if($append == true)
        {
          $this->head .= $metatag;
        }
      else
        {
          return $metatag;
        }
    }  

  //Append style sheets to the document head
  public function addStyleSheet($append, $ref)
    {
      $stylesheet = "<link href='$ref' rel='stylesheet' />";
      if($append == true)
        {
          $this->head .= $stylesheet;
        }
      else
        {
          return $stylesheet;
        }
    }

  //Create a jQuery event Listener. IdentifierType values: "id", "class", "raw"
  public function setJQueryListener($append, $identifierType, $elementIdentifier, $callbackFunction, $listener="click")
    {
      if($identifierType == "id")
      {
        $element = "#" . $elementIdentifier;
      }
      elseif($identifierType == "class")
      {
        $element = "." . $elementIdentifier;
      }
      elseif($identifierType == "raw")
      {
        $element = $elementIdentifier;
      }

      $listener = '<script>jQuery("'. $element .'").on("'. $listener .'", function(){'. $callbackFunction .'});</script>';

      if($append == true)
          {
            $this->bodyBottom .= $listener;
          }
      else
          {
            return $listener;
          }

    }
  
  //Append custom styles
  public function addStyles($append, $styles)
    {
      $styles = "<style>" . $styles . "</style>";

      if($append == true)
        {
          $this->head .= $styles;
        }
      else
        {
          return $styles;
        }
    }    
    
  //Append script file to top of document body
  public function addScriptFromLink($append, $ref)
    {
      $script = "<script src='$ref'></script>";
      if($append == true)
        {      
          $this->bodyTop .= $script;
        }
      else
        {
          return $script;
        }
    }

  //Append custom script to bottom of document body
  public function addScript($append, $content)
    {
      if($append == true)
        {           
          $this->bodyBottom .= "<script>";
          $this->bodyBottom .= $content;
          $this->bodyBottom .= "</script>";
        }
      else
        {
          return $script;
        }
    }

  //Append custom element to document head
  public function appendToHead($content)
    {
      $this->head .= $content;
    }

  //Append custom element to document body
  public function appendToBody($content, $position="content")
    {
      if ($position == "top")
      {
        $this->bodyTop .= $content;
      }
      elseif ($position == "content")
      {
        $this->bodyContent .= $content;
      }
      elseif ($position == "bottom")
      {
        $this->bodyBottom .= $content;
      }
    }
  //Append hook
  public function appendHook($name, $position="content")
    {
      if ($position == "top")
      {
        $this->bodyTop .= '<hook>'. $name .'</hook>';
      }
      elseif ($position == "content")
      {
        $this->bodyContent .= '<hook>'. $name .'</hook>';
      }
      elseif ($position == "bottom")
      {
        $this->bodyBottom .= '<hook>'. $name .'</hook>';
      }
      elseif ($position == "head")
      {
        $this->head .= '<hook>'. $name .'</hook>';
      }
    }
  //Append to hook
  public function appendToHook($name, $element, $position="content")
    {
      if ($position == "top")
      {        
        $this->bodyTop = preg_replace('/<hook>'.$name.'<\/hook>/', $element.'$0', $this->bodyTop);
      }
      elseif ($position == "content")
      {
        $this->bodyContent = preg_replace('/<hook>'.$name.'<\/hook>/', $element.'$0', $this->bodyContent);
      }
      elseif ($position == "bottom")
      {
        $this->bodyBottom = preg_replace('/<hook>'.$name.'<\/hook>/', $element.'$0', $this->bodyBottom);
      }
      elseif ($position == "head")
      {
        $this->head = preg_replace('/<hook>'.$name.'<\/hook>/', $element.'$0', $this->head);
      }
    }
  //Construct HTML document from instantiated $head, $bodyTop, $bodyContent, and $bodyBottom properties and store it in the $document property
  public function constructDOM()
    {
      $this->bodyTop = preg_replace('/<hook>(.*?)<\/hook>/', '', $this->bodyTop);
      $this->bodyContent = preg_replace('/<hook>(.*?)<\/hook>/', '', $this->bodyContent);
      $this->bodyBottom = preg_replace('/<hook>(.*?)<\/hook>/', '', $this->bodyBottom);
      $this->head = preg_replace('/<hook>(.*?)<\/hook>/', '', $this->head);

      $this->document =   "<!DOCTYPE html>
                          <html>";
      $this->document .=    "<head>";
      $this->document .=    $this->head;
      $this->document .=    "</head>";
      $this->document .=    "<body>";
      $this->document .=    $this->bodyTop;
      $this->document .=    $this->bodyContent;
      $this->document .=    $this->bodyBottom;
      $this->document .=    "</body>";
      $this->document .=  "</html>";
    }
}

//Dom Factory Functions
  //castElement($append=false, $content="", $type="div", $lbr=false, $class="", $id="", $name="", $style="", $additionalAttributes="")
    //If $append is false, the function will return the element as a string. If it is true, the function will append the element in the generated document's body section
    //$lbr can be set to br or p to replace line breaks with corresponding elements in the $content variable
    //If $type is "br" or "input", $content is no longer used and the element will be self closing (/>). Additional input parameters can be appended via $additionalAttributes
    //$additionalAttributes can take any content to be appended inside the opening tag. The form should be: 'attribute="value"'
  //SelectInjectOption
    //$element takes a fully formed select element in string form, then replaces the closing tag </select> with the injected option and a new </select> closing tag
    //$value, $content, and $selected (bool) define the option element's parameters

//Test Implementation:
  include("domtest.php");
?>