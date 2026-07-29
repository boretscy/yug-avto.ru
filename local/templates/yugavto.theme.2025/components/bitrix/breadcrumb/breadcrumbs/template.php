<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$arResult = array_merge(
	[[
		'TITLE' => 'Главная',
		'LINK' => '/'
	]],
	$arResult
);

$strReturn = '<div class="bg-yalightbluegray py-2 py-md-4"><div class="container breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList"><div class="row"><div class="col text-minus-minus breadcrumbs-wrapper">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = '';
	if ( $index > 0 ) $arrow = '<img class="breadcrumbs-arrow" src="'.SITE_TEMPLATE_PATH.'/assets/images/svg/icon-breadcrumbs.svg" alt="" />';

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<div class="breadcrumbs-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				'.$arrow.'
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item" class="text-decoration-none c-yadarkgray c-h-yablack">
					<span itemprop="name">'.$title.'</span>
				</a>
				<meta itemprop="position" content="'.($index + 1).'" />
			</div>';
	}
	else
	{
		$link = !empty($arResult[$index]["LINK"]) ? $arResult[$index]["LINK"] : $_SERVER['REQUEST_URI'];
		$strReturn .= '
			<div class="breadcrumbs-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				'.$arrow.'
				<a href="'.$link.'" itemprop="item" class="text-decoration-none c-yadarkgray">
					<span itemprop="name">'.$title.'</span>
				</a>
				<meta itemprop="position" content="'.($index + 1).'" />
			</div>';
	}
}

$strReturn .= '</div></div></div></div>';

if ( $arResult[1]['LINK'] == '/cars/' ) {
	$arResult[1]['LINK'] = '/cars/new/';
}

return $strReturn;
