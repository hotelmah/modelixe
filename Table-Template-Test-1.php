<?php

namespace TEST;

require_once('vendor/autoload.php');
// require_once('src/ModeliXe.php');

use ModeliXe\ModeliXe;

/* ===================================================================================================================== */

$TestDataSet = array(
    0 => array("Welcome", "to", "the", "wonderful", "world", "of", "PHP"),
    1 => array("Where", "fun", "and", "sun", "exists", "always", "indefinitely"),
    2 => array("The", "people", "learn", "when", "given", "the", "chance"),
    3 => array("Imagination", "is", "the", "highest", "form", "of", "research")
);

/* ===================================================================================================================== */

$html = new ModeliXe("Templates/Table.tpl", '', '', -1, false);
$html->setModeliXe();

/* ===================================================================================================================== */

$html->mxText("TableHeaderTop", "TOP: This is the top header of the table Bloc looping test");
$html->mxText("tdTextFirstBefore", "Column 1 before");
$html->mxText("tdTextLastBefore", "Column span 2 through " . count($TestDataSet[0]) . " before");

/* ===================================================================================================================== */

$html->mxBloc("bloc_loop_table_row", "modify", "Templates/Table-Row.tpl");

foreach ($TestDataSet as $TestDataItem) {
    foreach ($TestDataItem as $Key => $Value) {
        $html->mxText("bloc_loop_table_row.bloc_loop_table_definition.tdText", $Value);
        $html->mxBloc("bloc_loop_table_row.bloc_loop_table_definition", "loop");
    }
    $html->mxText("bloc_loop_table_row.NewLine", chr(0x0D));
    $html->mxBloc("bloc_loop_table_row", "loop");
}

/* ===================================================================================================================== */

$html->mxText("tdTextFirstAfter", "Column 1 after");
$html->mxText("tdTextLastAfter", "Column span 2 through " . count($TestDataSet[0]) . " after");

$html->mxText("TableHeaderBottom", "BOTTOM: This is bottom header of the table Bloc looping test");
$html->mxSelect("SelBelowTable", "SelTest", "SelTest", null, array("helloVal" => "Hello", "catVal" => "Cat", "inVal" => "in", "theVal" => "the", "hatVal" => "Hat"), '', '', '');

/* ===================================================================================================================== */

$html->mxText("Title", "ModeliXe Table Bloc Looping Test");
$html->mxText("colSpanPartail", count($TestDataSet[0]) - 1);
$html->mxText("ColSpanTotal", count($TestDataSet[0]));

/* ===================================================================================================================== */

$html->mxWrite(false);
unset($html);

/* ===================================================================================================================== */
