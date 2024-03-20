<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<div class="random_container">
    <h2><?= GetMessage("HEADING") ?></h2>
    <small><?= GetMessage("TIP") ?></small>
    <? foreach ($arResult["ITEMS"] as $arItem) : ?>
        <p class="random_item">
            <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>">
                <b><? echo $arItem["NAME"] ?></b>
            </a>
        </p>
        <!-- <pre>
           <?// var_dump($arItem); ?>
        </pre> -->
    <? endforeach; ?>
</div>