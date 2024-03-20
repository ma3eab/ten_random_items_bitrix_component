<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if($arParams["IBLOCK_ID"] < 1) {
	ShowError("IBLOCK_ID IS NOT DEFINED");
	return false;
}

if(!isset($arParams["ITEMS_LIMIT"])) {
	$arParams["ITEMS_LIMIT"] = 10;
}

$arNavParams = array();

if ($arParams["ITEMS_LIMIT"] > 0) {
	$arNavParams = array(
		"nPageSize" => $arParams["ITEMS_LIMIT"],
	);
}

$arNavigation = CDBResult::GetNavParams($arNavParams);

	if(!CModule::IncludeModule("iblock")) {
		$this->AbortResultCache();
		ShowError("IBLOCK_MODULE_NOT_INSTALLED");
		return false;
	}	

	$arSort= array("RAND" => "ASC");
	$arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y", "ACTIVE_DATE" => "Y");
	$arSelect = array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_TEXT", "DETAIL_PAGE_URL", "PREVIEW_PICTURE");

	$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams, $arSelect);

	if ($arParams["DETAIL_URL"]) {
		$rsElement->SetUrlTemplates($arParams["DETAIL_URL"]);
	}

	while($obElement = $rsElement->GetNextElement()) {

		$arElement = $obElement->GetFields();
		if ($arElement["PREVIEW_PICTURE"]) {
			$arElement["PREVIEW_PICTURE"] = CFile::GetFileArray($arElement["PREVIEW_PICTURE"]);
		} 
		//$arElement["PROPERTIES"] = $obElement->GetProperties();

		$arResult["ITEMS"][] = $arElement;
	}

	$arResult["NAV_STRING"] = $rsElement->GetPageNavStringEx($navComponentObject, "", "", "");

	$this->IncludeComponentTemplate();

?>