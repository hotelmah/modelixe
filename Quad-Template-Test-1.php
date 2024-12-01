<?php

namespace TEST;

// require_once('vendor/autoload.php');
require_once('src/ModeliXe.php');

use MODELIXE\ModeliXe;

/* ===================================================================================================================== */

$html = new ModeliXe("Templates/Quad.tpl", '', '', -1, false);
$html->setModeliXe();

/* ===================================================================================================================== */

$html->mxText("TopLeft1", "1: One");
$html->mxText("TopLeft2", "2: Two");
$html->mxText("TopLeft3", "3: Three");
$html->mxText("TopLeft4", "4: Four");

// BlocTopLeft has content inside the block from the template.
// In this case we are appending to the existing content.
if (true) {
    $html->mxBloc("BlocTopLeft", "appe", "<strong>This is appended.</strong>");
}

/* ===================================================================================================================== */

$html->mxText("TopRight1", "1: Five");
$html->mxText("TopRight2", "2: Six");

// Notice the '.' This is because these two fields are contanined within the Bloc.
$html->mxText("BlocTopRight.TopRight3", "3: Seven");
$html->mxText("BlocTopRight.TopRight4", "4: Eight");

// Delete the content inside the Bloc.
// Change the below from true to false to see the exisiting content from the template.
if (true) {
    $html->mxBloc("BlocTopRight", "dele", "");
}

/* ===================================================================================================================== */

$html->mxText("BottomLeft1", "1: Nine");
$html->mxText("BottomLeft2", "2: Ten");
$html->mxText("BottomLeft3", "3: Eleven");

// BotttomLeft4 is inside the Bloc
$html->mxText("BlocBottomLeft.BottomLeft4", "4: Twelve");

// Replace content of the Bloc. BotttomLeft4 is one template variable found in the Bloc.
if (true) {
    $html->mxBloc("BlocBottomLeft", "repl", "<strong>This is replaced.</strong>");
}

/* ===================================================================================================================== */

$html->mxText("BottomRight1", "1: Thirteen");
$html->mxText("BottomRight2", "2: Fourteen");
$html->mxText("BottomRight3", "3: Fifteen");
$html->mxText("BottomRight4", "4: Sixteen");

// Modify content of the Bloc template variable in the template.
// This one does not have exisiting content inside.
// There is more to this. You can change the template reference.
if (true) {
    $html->mxBloc("BlocBottomRight", "modi", "<strong>Change the template reference using modify</strong>.");
}

// How to use a select form control.
$html->mxText("LabelFor", "SelTest");
$html->mxSelect("BottomRight5", "SelTest", "SelTest", null, array("helloVal" => "Hello", "catVal" => "Cat", "inVal" => "in", "theVal" => "the", "hatVal" => "Hat"), '', '', '');

/* ===================================================================================================================== */

$html->mxText("Title", "ModeliXe Features Test");

$html->mxWrite(false);
unset($html);

/* ===================================================================================================================== */
