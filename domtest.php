<?php
//Class Testing Section: Create full example Document with class instance

$dom = new DomFactory("Site Title");

$dom->addScriptFromLink(true, "https://code.jquery.com/jquery-3.6.1.min.js");
$dom->addMeta(true, "description", "This is a site description created with DomFactory.");

$styles = "
          .clearboth
            {
              clear: both;
              width: 100%;
              height: 1px;
              border-bottom: 2px solid black;
            }
          #ID2
            {
              cursor: pointer;
            }
          ";

$dom->addStyles(true, $styles);

$content = "Hello World!
This is a test.

Testing, big time.";

$dom->castElement(true, $content, "div", "elementClass", "ID1", "br", "Name1", "float: left; color: red;");
$dom->castElement(true, $content, "button", "elementClass", "ID2", "p", "Name2", "float: right; color: blue;");

$dom->castElement(true, "", "div", "clearboth");

$newSelect = $dom->castElement(false, "<option value='Hello World!'>Hello World!</option>", "select", "", "worldselect");

$newSelect = $dom->SelectInjectOption(false, $newSelect, "1", "One");
$newSelect = $dom->SelectInjectOption(false, $newSelect, "2", "Two", true);
$newSelect = $dom->SelectInjectOption(false, $newSelect, "3", "Three");

$dom->appendHook("domhook1", "content");

$dom->appendToBody($newSelect, "content");

$dom->castElement(true, "", "br");

$dom->castElement(true, $content, "div", "elementClass", "ID3", "br", "Name3");

$callbackFunction = "jQuery('#ID1').toggle('slow');";

$dom->setJQueryListener(true, "id", "ID2", $callbackFunction);

$callbackFunction = "jQuery('#ID3').html(jQuery(this).val());";

$dom->setJQueryListener(true, "id", "worldselect", $callbackFunction, "change");  

$dom->castElement(true, "", "div", "clearboth");
$appendable = $dom->castElement(false, "Appended to Hook.", "span", "elementClass", "ID5", "br", "Name5", "color: green;");
$dom->appendToHook("domhook1", $appendable);
$dom->appendToHook("domhook1", $dom->castElement(false, "", "br"));

$dom->constructDOM();

echo $dom->document;
?>