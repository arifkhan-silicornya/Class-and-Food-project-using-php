<?php

if (! isLogged())
{
    header('Location: ' . smoothLink('index.php?tab1=logout'));
}

/* */
$i = 0;
$listCategories = '';

foreach (getPageCategories() as $parent_category)
{
	$themeData['list_parent_category_label'] = $lang[$parent_category['name']];
	$childCategories = '';

	foreach (getPageCategories($parent_category['id']) as $main_category)
	{
		$themeData['list_category_id'] = $main_category['id'];
		$themeData['list_category_name'] = $lang[$main_category['name']];

		$childCategories .= \miuan\UI::view('timeline/page/create/list-category-each');
	}

	$themeData['list_child_categories'] = $childCategories;
	$listCategories .= \miuan\UI::view('timeline/page/create/list-parent-category-each');
}

$themeData['list_categories'] = $listCategories;
/* */

$themeData['page_content'] = \miuan\UI::view('timeline/page/create/content');
