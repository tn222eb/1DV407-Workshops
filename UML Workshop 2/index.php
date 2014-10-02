<?php 

require_once("src/view/HTMLView.php");
require_once("src/view/MemberView.php");

$htmlView = new HTMLView();

$MemberView = new \view\MemberView();

$html = $MemberView->display();

$htmlView->echoHTML($html);