<?php
/**
 * Author: Denisov Denis
 * Email: denisovdenis@me.com
 * Date: 28.05.13
 * Time: 17:25
 */

$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,
    'name' => 'ArticleParser',
    'author' => '[http://www.facebook.com/denisovdenis Denisov Denis]',
    'url' => 'https://github.com/Undev/wiki-article-parser',
    'description' => 'Parse article for br tag',
    'version' => 0.1,
);

$wgHooks['ArticleSave'][] = 'brRemove';

function brRemove(&$article, &$user, $text)
{
    $msg = '(пожалуйста, не пользуйтесь тегом BR — double enter создаст новый абзац; для оформления списков есть разметка; не лишним будет взглянуть на [[Wiki FAQ]])';
    $pattern = '/(<br.*>)/i';
    $text = preg_replace($pattern, $msg, $text);

    return true;
}