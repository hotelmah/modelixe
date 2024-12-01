<?php

namespace TEST;

require_once('Includes/ModeliXe.php');

use MODELIXE\ModeliXe;

/* ===================================================================================================================== */

$TestData = array(
    0 => array("Welcome", "to", "the", "wonderful", "world", "exists"),
    1 => array("where", "fun", "and", "sun", "exists", "always"),
    2 => array("The", "people", "have", "spoken", "loudly", "right")
);

/* ===================================================================================================================== */

// form initialization
$echo_html = new ModeliXe("Templates/KAP-Test-Table.tpl", '', '', -1, false);
$echo_html -> setModeliXe();

$echo_html -> mxText("Title", "Hello Table Test!");
$echo_html -> mxText("TableHeaderTop", "This is the header of Table Test");
$echo_html -> mxText("TD1", "Kevin");
$echo_html -> mxText("TD2", "Elmah");

$echo_html -> mxBloc("bloc_loop_table_row", "modify", "Templates/KAP-Test-Table-Row.tpl");

foreach ($TestData as $TestDataItem) {
    foreach ($TestDataItem as $Key => $Value) {
        $echo_html -> mxText("bloc_loop_table_row.bloc_loop_table_definition.tdText", $Value);
        $echo_html -> mxBloc("bloc_loop_table_row.bloc_loop_table_definition", "loop");
    }
    $echo_html -> mxBloc("bloc_loop_table_row", "loop");
}

$echo_html -> mxText("TableHeaderBottom", "This is table status bottom");
$echo_html -> mxSelect("SelectBelowTable", "SelTableTest", "SelTableTest", null, array("NewsVal" => "News", "ShoutOutsVal" => "ShoutOuts", "ContactFormSubmitsVal" => "ContactFormSubmits"), '', '', '');

$echo_html -> mxWrite(false);
unset($echo_html);
