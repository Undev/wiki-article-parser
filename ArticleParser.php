<?php
/**
 * Author: Denisov Denis
 * Email: denisovdenis@me.com
 * Date: 28.05.13
 * Time: 17:25
 */

$wgExtensionFunctions[] = 'wfSetupArticleParser';
$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,
    'name' => 'ArticleParser',
    'author' => '[http://www.facebook.com/denisovdenis Denisov Denis]',
    'url' => 'https://github.com/Undev/wiki-article-parser',
    'description' => 'Parse article for br tag',
    'version' => 0.2,
);

class ArticleParser
{
    function __construct()
    {
        global $wgHooks;

        $wgHooks['ArticleViewHeader'][] = $this;
    }

    public function onArticleViewHeader(&$article, &$outputDone, &$pcache)
    {
        $text = $article->getContent();

        $pattern = "/<br.*>/i";
        $replace = "\n{{tab red|Пожалуйста, не пользуйтесь тегом BR — double enter создаст новый абзац; для оформления списков есть разметка; не лишним будет взглянуть на [[Wiki FAQ]]}}\n";
        $text = preg_replace($pattern, $replace, $text);

        $outputPage = new OutputPage;
        $outputPage->addWikiText($text);

        RequestContext::getMain()->setOutput($outputPage);

        return true;
    }
}

function wfSetupArticleParser()
{
    global $wgArticleParser;

    $wgArticleParser = new ArticleParser;
}