<?
/**
 * @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var string $componentName
 * @var string $componentTemplate
 * @global CDatabase $DB
 * @global CUser $USER
 * @global CMain $APPLICATION
 */
if (!isset($arParams["CACHE_TIME"])) {
$arParams["CACHE_TIME"] = 36000000;
}
$arFilter = $arParams["FILTER"] ?? [];
if ($arParams['IBLOCK_ID']) {
$arFilter['IBLOCK_ID'] = (int)$arParams['IBLOCK_ID'];
$arResult['ID'] = $arFilter['IBLOCK_ID'];
}
if (!$arFilter['IBLOCK_ID']) {
ShowError("Не указан ID инфоблока");
return;
}
$arFields = $arParams["FIELDS"] ?? [];
$arProperties = $arParams["PROPERTIES"] ?? [];
$arSort = $arParams["SORT"] ?? [];
$limit = $arParams["СOUNT"] ?? 0;
$arResult['ITEMS'] = \Axi\Iblock\Element::fetchList($arFilter, $arFields, $arProperties, $arSort, $limit);
$obTextParser = new CTextParser();
foreach ($arResult['ITEMS'] as &$arItem) {
$arResult['ELEMENTS'][] = $arItem['ID'];
$arButtons = CIBlock::GetPanelButtons(
$arItem["IBLOCK_ID"],
$arItem["ID"],
0,
["SECTION_BUTTONS" => false, "SESSID" => false]
);
$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
}







$this->includeComponentTemplate();
if (isset($arResult["ID"])) {
if ($USER->IsAuthorized() && $APPLICATION->GetShowIncludeAreas()) {
$arButtons = CIBlock::GetPanelButtons(
$arResult["ID"],
0,
$arParams["PARENT_SECTION"],
["SECTION_BUTTONS" => false]
);
$this->addIncludeAreaIcons(
CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons)
);
}
return $arResult["ELEMENTS"];
}


?>

