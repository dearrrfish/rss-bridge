<?php
class DuckDuckGoBridge extends BridgeAbstract{

	const MAINTAINER = "Astalaseven";
	const NAME = "DuckDuckGo";
	const URI = "https://duckduckgo.com/";
	const CACHE_TIMEOUT = 21600; // 6h
	const DESCRIPTION = "Returns most recent results from DuckDuckGo.";

    const PARAMETERS = array( array(
        'u'=>array(
            'name'=>'keyword',
            'required'=>true)
        ));

    public function collectData(){
        $html = getSimpleHTMLDOM(self::URI.'html/?q='.$this->getInput('u').'+sort:date')
            or returnServerError('Could not request DuckDuckGo.');

        foreach($html->find('div.results_links') as $element) {
                $item = array();
                $item['uri'] = $element->find('a', 0)->href;
                $item['title'] = $element->find('a', 1)->innertext;
                $item['content'] = $element->find('div.snippet', 0)->plaintext;
                $this->items[] = $item;
        }
    }
}
