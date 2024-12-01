<?php

namespace TEST;

require_once('Includes/ModeliXe.php');

use MODELIXE\ModeliXe;

/* ===================================================================================================================== */

// form initialization
$echo_html = new ModeliXe("Templates/KAP-Test-Quad.tpl", '', '', -1, false);
$echo_html -> setModeliXe();

$echo_html -> mxText("TopLeft1", "Hello");
$echo_html -> mxText("TopRight1", "Kevin");
$echo_html -> mxText("BottomLeft1", "This is");
$echo_html -> mxText("BottomRight1", "a test.");
$echo_html -> mxSelect("BottomRight5", "Test", "Test", null, array("helloVal" => "Hello", "catVal" => "Cat", "hatVal" => "Hat"), '', '', '');

$echo_html -> mxWrite(false);
unset($echo_html);
