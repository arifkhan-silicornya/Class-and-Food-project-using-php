<?php


$themeData['terms_about_url'] = smoothLink('index.php?tab1=terms&tab2=notice');


$termType = null;
$termsContent = '';

if (isset($_GET['tab2']))
{
    $termType = $_GET['tab2'];
}

switch($termType)
{
   
  
    
  
    
    case 'notice':
        $termsContent = \miuan\UI::view('terms/notice');
    break;

   
    
    default:
        $termsContent = \miuan\UI::view('terms/notice');
}

$themeData['terms_content'] = $termsContent;
$themeData['page_content'] = \miuan\UI::view('terms/content');
