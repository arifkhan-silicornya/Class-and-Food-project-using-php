<?php
if ($logged != true) {
    header('Location: ' . smoothLink('index.php?tab1=logout'));
}

/* */
$themeData['create_page_url'] = smoothLink('index.php?tab1=create_page');
$themeData['create_group_url'] = smoothLink('index.php?tab1=create_group');

/* Managed Pages */
$i = 0;
$listManagedPages = '';

foreach (getManagedPages() as $page) {
	$themeData['list_page_url'] = $page['url'];
	$themeData['list_page_username'] = $page['username'];
	$themeData['list_page_avatar_url'] = $page['avatar_url'];
	$themeData['list_page_name'] = $page['name'];
	
	$listManagedPages .= \miuan\UI::view('more/list-page-each');
	$i++;
}

if ($i < 1) {
	$listManagedPages = \miuan\UI::view('more/no-pages');
}
$themeData['list_managed_pages'] = $listManagedPages;

/* Managed Groups */
$i = 0;
$listManagedGroups = '';

foreach (getManagedGroups() as $group) {
	$themeData['list_group_url'] = $group['url'];
	$themeData['list_group_username'] = $group['username'];
	$themeData['list_group_name'] = $group['name'];
	
	$listManagedGroups .= \miuan\UI::view('more/list-group-each');
	$i++;
}

if ($i < 1) {
	$listManagedGroups = \miuan\UI::view('more/no-groups');
}
$themeData['list_managed_groups'] = $listManagedGroups;
/* */

$themeData['page_content'] = \miuan\UI::view('more/content');
