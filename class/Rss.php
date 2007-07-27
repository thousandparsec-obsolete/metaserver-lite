<?php


// ?? check this library !!! 

include("feedcreator.class.php"); 



class RSS {

	private function createRss($title, $link, $description)
	{
		$rss = new UniversalFeedCreator();
	   $rss->useCached();
	   $rss->title = $title;
	   $rss->description = $description;
	   $rss->link = $link;
	   $rss->syndicationURL = $link; 
		
	}
	
	/**
		
		get game desc from database
		get longer desc and title something like: "new game, check it... nr of users... adress..."
		
		??? seperate page for every new game ????? or metaserver main page ?? 
		
		
	*/
	
	public function newGameRss($name, $link)
	{
		$description = "new game: ".$name;  
		$title = "new game: ".$name;  
		
		$this->createRss($title, $link, $description);
		
	}
	
}


?>