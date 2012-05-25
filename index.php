<?php 
	$query_string = $_GET["p"];
	$query = explode(" ", $query_string);
	$prefix = $query[0];
	unset($query[0]);
	$query = urlencode(implode(" ", $query));
	
	$keywords = array(
		
		'wo' 	=>	"http://www.wolframalpha.com/input/?i=%s", 
		'so' 	=>	"http://stackoverflow.com/search?q=%s",
		'p' 	=>	"https://pinboard.in/search/?query=%s+&mine=Search+Mine",
		'wi' 	=>	"http://www.wikipedia.org/search-redirect.php?language=en&search=%s",
		'y' 	=>	"http://youtube.com/results?search_query=%s",
		'imdb' 	=> 	"http://imdb.com/find?s=all&q=%s",
		'rt' 	=>	"http://www.rottentomatoes.com/search/?search=%s",
		'e'		=>	"http://search.ebay.com/search/search.dll?satitle=%s",
		'down'	=>	"http://downforeveryoneorjustme.com/%s",
		'a'		=>	"http://www.amazon.com/s/field-keywords=%s",
		'w'		=>	"http://www.myweather.com/",
		'gh'    =>  "https://github.com/search?q=%s&repo=&langOverride=&start_value=1&type=Repositories&language=",
		
		'_default' => "https://startpage.com/do/search?q=%s"
	);
	
	$target = "";
	if (isset($keywords[$prefix])) {
		$target = $keywords[$prefix];
	} else {
		$query = urlencode($query_string);
		$target = $keywords['_default'];
	}

	header("Location: ". sprintf($target, $query));
?>