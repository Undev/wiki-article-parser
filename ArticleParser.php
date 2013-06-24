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
    'version' => 0.3,
);

class ArticleParser
{

    private $text;

    function __construct()
    {
        global $wgHooks;

        $wgHooks['ArticleViewHeader'][] = $this;
        $wgHooks['OutputPageParserOutput'][] = $this;

    }

    public function onArticleViewHeader(&$article, &$outputDone, &$pcache)
    {
        $text = $article->getContent();

        $pattern = "/<br.*>/i";
        $replace = "\n{{tab red|Пожалуйста, не пользуйтесь тегом BR — double enter создаст новый абзац; для оформления списков есть разметка; не лишним будет взглянуть на [[Wiki FAQ]]}}\n";

        $outputPage = RequestContext::getMain()->getOutput();
        $this->text = preg_replace($pattern, $replace, $text);
        $this->text = $outputPage->parse($this->text);

        return true;
    }

    public function onOutputPageParserOutput( OutputPage &$out, ParserOutput $parseroutput )
    {
        $parseroutput->setText($this->text);

        return true;
    }

}

function wfSetupArticleParser()
{
    global $wgArticleParser;

    $wgArticleParser = new ArticleParser;
}