<?php

session_start();

include_once'class/webpage.class.php';

$page = new Webpage('planning des matchs');

echo $page->toHTML();