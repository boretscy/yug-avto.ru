<?php
/**
 * Migration: Create GALLERY property in IBLOCK 11 (News) and add it to admin form options.
 * Idempotent: can be executed multiple times safely.
 */
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule("iblock");

header("Content-Type: text/plain; charset=utf-8");

try {
    $res = \CIBlockProperty::GetList([], ["IBLOCK_ID" => 11, "CODE" => "GALLERY"]);
    if ($prop = $res->Fetch()) {
        $propId = $prop["ID"];
        echo "Property GALLERY already exists with ID: {$propId}\n";
    } else {
        $ibp = new \CIBlockProperty();
        $arFields = [
            "NAME" => "Галерея",
            "ACTIVE" => "Y",
            "SORT" => 500,
            "CODE" => "GALLERY",
            "PROPERTY_TYPE" => "F",
            "ROW_COUNT" => 1,
            "COL_COUNT" => 30,
            "MULTIPLE" => "Y",
            "MULTIPLE_CNT" => 5,
            "FILE_TYPE" => "jpg, gif, bmp, png, jpeg, webp",
            "IBLOCK_ID" => 11,
            "WITH_DESCRIPTION" => "N",
            "SEARCHABLE" => "N",
            "FILTRABLE" => "N",
            "IS_REQUIRED" => "N"
        ];
        $propId = $ibp->Add($arFields);
        if (!$propId) {
            throw new \Exception("Failed to add property: " . $ibp->LAST_ERROR);
        }
        echo "Created property GALLERY with ID: {$propId}\n";
    }

    global $DB;
    $rs = $DB->Query("SELECT * FROM b_user_option WHERE CATEGORY = 'form' AND NAME = 'form_element_11'");
    $updatedCount = 0;
    while ($row = $rs->Fetch()) {
        $val = @unserialize($row["VALUE"], ["allowed_classes" => false]);
        if (!empty($val["tabs"])) {
            if (strpos($val["tabs"], "PROPERTY_{$propId}") === false) {
                $needle = "--DETAIL_TEXT--#--Детальное описание--";
                $replacement = $needle . ",--PROPERTY_{$propId}--#--Галерея--";
                if (strpos($val["tabs"], $needle) !== false) {
                    $val["tabs"] = str_replace($needle, $replacement, $val["tabs"]);
                } else {
                    $val["tabs"] = preg_replace("/(edit1--#--.*?)(;--)/", "$1,--PROPERTY_" . $propId . "--#--Галерея--$2", $val["tabs"]);
                }
                $newVal = serialize($val);
                $updateSql = "UPDATE b_user_option SET VALUE = '" . $DB->ForSql($newVal) . "' WHERE ID = " . (int)$row["ID"];
                $DB->Query($updateSql);
                $updatedCount++;
            }
        }
    }
    echo "Updated {$updatedCount} form_element_11 records in b_user_option\n";

    \CIBlock::CleanCache(11);
    \Bitrix\Main\Data\Cache::createInstance()->cleanDir("/iblock/11");
    echo "Cache cleared for IBLOCK 11\n";

} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}
