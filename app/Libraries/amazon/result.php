<?php

namespace App\Amazon;
//require_once 'xpath.php';
//require '../vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;


class CREATE{

	public $startUrl;
	public $xpath; 
	public $asin;
	public $tr;

	public function __construct($asin){
		$this->tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
		$this->tr->setSource(); // Detect language automatically
		$this->tr->setTarget('es'); // Translate to Spanish

		
	
		$this->asin = $asin;
		$this->startUrl = "https://www.amazon.com/-/es/dp/" . $this->asin;
		$this->xpath = new XPATH($this->startUrl);
		
	} 

	public function typeOfItem(){

		$pageTitleQuery = "//title";
		$pageTitleXpath = $this->xpath->query($pageTitleQuery);
		$pageTitleXpath = $this->xpath->xpathToArray($pageTitleXpath);//Title string

		if(strpos($pageTitleXpath[0], "Music") == false){
			return self::createItem();
		} 
		// If Product is CD || Vinyl
		if(strpos($pageTitleXpath[0], "Music") == true){ 

			$currentFormatQuery = "(//li[@class='swatchElement selected']/span//a)[1]";
			$currentFormatXpath = $this->xpath->query($currentFormatQuery);
			$currentFormat = $this->xpath->title($currentFormatXpath);
			
			if (strpos($currentFormat, "CD") !== false) {
				self::createItemMusic("CD");
			}
			if (strpos($currentFormat, "Vinilo") !== false) {
				self::createItemMusic("Vinilo");					
			}

		}
			//Current CD || Vinyl selected "//li[@class='swatchElement selected']/span[text()]"
			//"(//li[@class='swatchElement unselected']/span//a[contains(.,'Vinilos')]/@href)"
			/*if 
			$currentFormatQuery = "(//li[@class='swatchElement selected']/span//a)[1]";
			$otherFormat = 
			$currentFormatXpath = $xpath->query($currentFormatQuery);
			$currentFormat = $xpath->title($currentFormatXpath);//Title string

			print_r($currentFormat);
			*/
	}

	public function createItem(){

		//Images Amazon $x("//script[contains(.,'ImageBlockATF')]")
		//Title Amazon "//span[@id='productTitle']"
		//Description Amazon "//div[@id='feature-bullets']/ul/li/span"
		//Secondary Description Amazon "//div[@id='productDescription']//p"
		//Price Amazon "//span[@id='priceblock_ourprice']"
		//Price Amazon "//span[@id='priceblock_saleprice']"
		//Brand Amazon "//a[@id='bylineInfo']"
		//BREADCRUMB Amazon "//div[@id='wayfinding-breadcrumbs_container']//a"
		//Get ASIN list items of search reslt Amazon "//li[@class='s-result-item  celwidget  ']/@data-asin|//div[@class[contains(.,'s-result-item')]]/@data-asin"
		// $x("//div[@id[contains(.,'descriptionAndDetails')]]")
		// ************* XPATH QUERIES *************
		
		$spechTablesQuery = "//div[@id[contains(.,'descriptionAndDetails')]]";
		$titleQuery = "//span[@id='productTitle']";
		$imgQuery = "//script[contains(.,'ImageBlockATF')]";
		$descriptionQuery = "//div[@id='feature-bullets']/ul/li/span[not(contains(.,'Asegúrate de que esto coincide'))]";
		$secondDescriptionQuery = "//div[@id='productDescription']//p";
		$priceQuery = "//span[@id='priceblock_saleprice']|//span[@id='priceblock_ourprice']";
		$brandQuery = "//a[@id='bylineInfo']";
		$breadcrumbQuery = "//div[@id='wayfinding-breadcrumbs_container']//a";
		$listAsinQuery = "//li[@class='s-result-item  celwidget  ']/@data-asin|//div[@class[contains(.,'s-result-item')]]/@data-asin";	
		
		$spechTablesXpath = $this->xpath->query($spechTablesQuery);
		$titleXpath = $this->xpath->query($titleQuery);
		
		$imagesXpath = $this->xpath->query($imgQuery);
		$descriptionXpath = $this->xpath->query($descriptionQuery);
		$secondDescriptionXpath = $this->xpath->query($secondDescriptionQuery);
		$priceXpath = $this->xpath->query($priceQuery);
		$brandXpath = $this->xpath->query($brandQuery);
		$breadcrumbXpath = $this->xpath->query($breadcrumbQuery);
		$listAsinXpath = $this->xpath->query($listAsinQuery);


		
		// ************* RESULTS *************
		
		//$tr->setSource('en'); // Translate from English
		
		$title = $this->xpath->title($titleXpath);//Title string
		$title = str_replace("&","",$title);
		$title = $this->tr->translate($title); // Translate title
		$images = $this->xpath->images($imagesXpath);//Images (array)
		$price = $this->xpath->price($priceXpath);//Price string
		$brand = $this->xpath->title($brandXpath);//Brand string
		$breadcrumb = $this->xpath->xpathToArray($breadcrumbXpath);//Bcrumb string

		//SPECH DATA
//		$spechTables = $this->xpath->spechTables();
		if (!$this->xpath->spechTables()) {
			$spechTables = $this->xpath->xpathToArray($spechTablesXpath);
		}else{
			$spechTables = $this->xpath->spechTables();
		}
		
		//$spechTables = $this->xpath->xpathToArray($spechTablesXpath); 
		
		
		//Configuracion de la descripcion/////////////////////////////////////
		if(sizeof($descriptionXpath) > 0){
			$description = $this->xpath->description($descriptionXpath);//Description string with \n
			$descriptionArr[] = $description;
		}if(sizeof($secondDescriptionXpath) > 0) {
			$secondDescription = $this->xpath->description($secondDescriptionXpath);//Description string with \n
			$descriptionArr[] = $secondDescription;	
		}if(sizeof($descriptionXpath) > 0 || sizeof($secondDescriptionXpath) > 0) {
			$descriptionArr = implode("\n",$descriptionArr);
			$descriptionArr = $this->tr->translate($descriptionArr); 	
		}if(sizeof($descriptionXpath) == 0 && sizeof($secondDescriptionXpath) == 0) {
			$descriptionArr = $title;
		}

		//Configuracion del titulo/////////////////////////////////////
		if (strlen($title) > 150) {
			$title = substr($title,0,150);
		}
		
		//Convert image array to Mercadolibre format
		foreach($images as $image){
			$imageArr[] = array("source" => $image);
		}

		//Fixed Title for making a better category search

		$fixedTitle = substr($title,0,60);
		$categoryml = categoryML($brand . $title  . "-" . end($breadcrumb));
		$categoryName =  $categoryml->name;
		$categoryID =  $categoryml->id;
		
		// echo "<pre>";
		// print_r($fixedTitle);
		// echo "<br>-------------------------------<br>";
		// print_r($images);
		// echo "<br>-------------------------------<br>";
		// echo $descriptionArr;
		// echo "<br>-------------------------------<br>";
		// print_r($price);
		// echo "<br>-------------------------------<br>";
		// print_r($brand);
		// echo "<br>-------------------------------<br>";
		// print_r($title);
		// echo "<br>-------------------------------<br>";
		// print_r($breadcrumb);
		// echo "<br>-------------------------------<br>";
		// print_r($categoryml);

		
			$product["sku"] = $this->asin;
			$product["title"] = $fixedTitle;
			$product["description"] = $descriptionArr;
			$product["price"] = $price;
			$product["brand"] = $brand;
			$product["images"] = $imageArr;
			$product["json_images"] = json_encode($imageArr);
			$product["categoryName"] = $categoryName;
			$product["categoryID"] = $categoryID;
			$product['spechTables'] = $spechTables;

		return $product;

	}

	public function createItemMusic($format){

		//Images Amazon $x("//script[contains(.,'ImageBlockATF')]")
		//Title Amazon "//div[@id='title_feature_div']"
		//Author Amazon "//span[@class='author notFaded']"
		//Description "//div[@id='productDescription']"
		//Price Amazon "//div[@id='buyNewSection']//span[contains(.,'$')]"

		// ************* XPATH QUERIES *************
		
		$titleQuery = "//div[@id='title_feature_div']";
		$authorQuery  = "//span[@class='author notFaded']";
		$imgQuery = "//script[contains(.,'ImageBlockATF')]";
		$descriptionQuery = "(//div[@id='productDescription']/p)[1]";
		$priceQuery = "//div[@id='buyNewSection']//span[contains(.,'$')]";
		
		$titleXpath = $this->xpath->query($titleQuery);
		$authorXpath = $this->xpath->query($authorQuery);
		$imagesXpath = $this->xpath->query($imgQuery);
		$descriptionXpath = $this->xpath->query($descriptionQuery);
		$priceXpath = $this->xpath->query($priceQuery);

		// ************* RESULTS ************* 
		
		



			$title = $this->xpath->title($titleXpath);//Title string
			$title = str_replace("&","",$title);
			$author = $this->xpath->title($authorXpath);//Brand string
			$images = $this->xpath->musicImages($imagesXpath);//Images (array)
			$description = $this->xpath->description($descriptionXpath);//Description string with \n
			$description = $this->tr->translate($description); 	
			$price = $this->xpath->price($priceXpath);//Price string
			$format = $format;

			echo "<pre>";
			print_r($title . " " . $format);
			echo "<br>-------------------------------<br>";
			print_r($images);
			echo "<br>-------------------------------<br>";
			echo $description;
			echo "<br>-------------------------------<br>";
			print_r($price);
			echo "<br>-------------------------------<br>";
			print_r($author);
			echo "<br>-------------------------------<br>";

			$categoryml = categoryML($title." cd");
			print_r($categoryml->name);

		}
	}		


