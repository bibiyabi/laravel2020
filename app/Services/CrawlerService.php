<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $path
     * @return Crawler
     */
    public function getOriginalData(string $path): Crawler
    {
        $content = $this->client->get($path)->getBody()->getContents();
        $crawler = new Crawler();
        $crawler->addHtmlContent($content);

        return $crawler;
    }

    public function getName(Crawler $node)
    {
        $result = $node->filterXPath('//div[@class="TODAY_CONTENT"]/h3')->text();
        $result = mb_substr($result, 2, 3);

        return $result;
    }

    public function getOverall(Crawler $node)
    {
        $result = $node->filterXPath('//span[@class="txt_green"]')->text();
        $result = mb_substr($result, 4, 5);

        return $result;
    }

    public function getTodayFortune(Crawler $node)
    {
        $result = array();

        $name = $node->filterXPath('//div[@class="TODAY_CONTENT"]/h3')->text();
        $result['name'] = $this->getFilterString(mb_substr($name, 2, 3));
//
        for ($i = 0; $i < 8; $i++){
            if ($i % 2 != 1){
                $title = $node->filterXPath('//div[@class="TODAY_CONTENT"]/p')->eq($i)->text();
                $result[$i] = mb_substr($title, 4, 5);
            }else{
                $result[$i] = $this->getFilterString($node->filterXPath('//div[@class="TODAY_CONTENT"]/p')->eq($i)->text());
            }
        }

        return $result;
    }

    public function getFilterString(string $target): string
    {
        $target = str_replace("\r", "", $target);
        $target = str_replace("\n", "", $target);
        $target = str_replace("\t", "", $target);
        $target = str_replace("\r\n", "", $target);
        $target = preg_replace("/\s+/", " ", $target);
        $target = preg_replace("/<[ ]+/si", "<", $target);
        $target = preg_replace("/<\!--.*?-->/si", "", $target);
        $target = preg_replace("/<(\!.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?html.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?head.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?meta.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?body.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?link.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?form.*?)>/si", "", $target);
        $target = preg_replace("/cookie/si", "COOKIE", $target);
        $target = preg_replace("/<(applet.*?)>(.*?)<(\/applet.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?applet.*?)>/si", "", $target);
        $target = preg_replace("/<(style.*?)>(.*?)<(\/style.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?style.*?)>/si", "", $target);
        $target = preg_replace("/<(title.*?)>(.*?)<(\/title.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?title.*?)>/si", "", $target);
        $target = preg_replace("/<(object.*?)>(.*?)<(\/object.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?objec.*?)>/si", "", $target);
        $target = preg_replace("/<(noframes.*?)>(.*?)<(\/noframes.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?noframes.*?)>/si", "", $target);
        $target = preg_replace("/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?i?frame.*?)>/si", "", $target);
        $target = preg_replace("/<(script.*?)>(.*?)<(\/script.*?)>/si", "", $target);
        $target = preg_replace("/<(\/?script.*?)>/si", "", $target);
        $target = preg_replace("/javascript/si", "Javascript", $target);
        $target = preg_replace("/vbscript/si", "Vbscript", $target);
        $target = preg_replace("/on([a-z]+)\s*=/si", "On\\1=", $target);
        $target = preg_replace("/&#/si", "&＃", $target);

        $pat = "/<(\/?)(script|i?frame|style|html|body|li|i|map|title|img|".
            "link|span|u|font|table|tr|b|marquee|td|strong|div|a|meta|\?|\%)([^>]*?)>/isU";
        $target = preg_replace($pat, "", $target);

        return trim($target);
    }

}