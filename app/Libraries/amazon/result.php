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
		$this->priceUrl = "https://www.amazon.com/s?k=" . $this->asin;
		$this->xpath = new XPATH($this->startUrl);
		$this->priceXpath = new XPATH($this->priceUrl);
		
	} 

	public function typeOfItem(){
		$htmlResponse = $this->xpath->html;
		$pageTitleQuery = "//title";
		$pageTitleXpath = $this->xpath->query($pageTitleQuery);
		$pageTitleXpath = $this->xpath->xpathToArray($pageTitleXpath);//Title string

		if ($htmlResponse !== null) {
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
		}else{
			return "Error";
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
		//Price LIST "//div[@data-asin='B00I7HACPQ']//span[@class='a-price']"
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
		$priceQuery = "//div[@data-asin='" . $this->asin . "']//span[@class='a-price']";
		$brandQuery = "//a[@id='bylineInfo']";
		$breadcrumbQuery = "//div[@id='wayfinding-breadcrumbs_container']//a";
		$listAsinQuery = "//li[@class='s-result-item  celwidget  ']/@data-asin|//div[@class[contains(.,'s-result-item')]]/@data-asin";	
		
		$spechTablesXpath = $this->xpath->query($spechTablesQuery);
		$titleXpath = $this->xpath->query($titleQuery);
		
		$imagesXpath = $this->xpath->query($imgQuery);
		$descriptionXpath = $this->xpath->query($descriptionQuery);
		$secondDescriptionXpath = $this->xpath->query($secondDescriptionQuery);
		$priceXpath = $this->priceXpath->query($priceQuery);
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

		/*/
		// Technical Info DATA
		/*/
		if (!$this->xpath->spechTables()) {

			$spechTables = $this->xpath->xpathToArray($spechTablesXpath);
			$spechTables = implode($spechTables);
			$spechTables = preg_replace('/\n+/', "", $spechTables);
			preg_match_all("/Peso del envío\s*[^\d]+(\d+\.*\,*\d*)\s*(\w+)/", $spechTables, $peso);
			preg_match_all("/Dimensiones\s*[^\d]+(\d+\.*\,*\d*)+\s*\w\s*(\d+\.*\,*\d*)+\s*\w\s*(\d+\.*\,*\d*)+\s*(\w*)/", $spechTables, $dimensiones);
			
			$weight = implode($peso[1])+0;
			$weightUnit = implode($peso[2]);
			$dimensions = array($dimensiones[1],$dimensiones[2], $dimensiones[3]);
			$dimensionsUnit = $dimensiones[4];
			is_array($dimensionsUnit) ? implode($dimensionsUnit) : $dimensionsUnit ;			
		}else{
			$result = $this->xpath->spechTables();
			//REGEX para tomar las medidas
			preg_match_all("/(\d+\.*\,*\d*)+\s*\w\s*(\d+\.*\,*\d*)+\s*\w\s*(\d+\.*\,*\d*)+\s*(\w*)/", $result[0], $dimensiones);
			if(is_array($dimensiones[0])){ //A veces el campo Dimensiones esta duplicado, este ciclo toma solo el primero
				foreach ($dimensiones as $key => $value) {
					array_unshift($dimensiones, $value[0]);
				}
			}
			$weight = 	$result[1]+0; 
			$weightUnit = $result[2];
			$dimensions = array($dimensiones[1],$dimensiones[2],$dimensiones[3]);
			$dimensionsUnit = $dimensiones[0];
		}if($weightUnit == "onzas" || $weightUnit == "ounces" || $weightUnit == "oz"){
			$weight = $weight * 0.0625;
		}if($dimensionsUnit == "inch" || $dimensionsUnit == "pulgadas" || $dimensionsUnit == "inches" ){
			for ($i=0; $i < sizeof($dimensions); $i++) { 
				$dimensions[$i] = round((floatval($dimensions[$i]) * 2.54), 0, PHP_ROUND_HALF_UP);
			}
		}if(is_float($weight)){
			$weight=intval($weight)+1;
		}
		
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

		if (count($images)>5){
			$images = array_slice($images, 0, 5);
		}
		//Convert image array to Mercadolibre format
		foreach ($images as $image) {
			$imageArr[] = array("source" => $image);
		}

		//Fixed Title for making a better category search
		$fixedTitle = substr($title,0,100);
		$categoryml = categoryML($fixedTitle);
		$categoryName =  $categoryml->category_name;
		$categoryID =  $categoryml->category_id;
		
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
		$product["images"] = $images;
		$product["imagesArr"] = $imageArr;
		$product["json_images"] = json_encode($imageArr);
		$product["categoryName"] = $categoryName;
		$product["categoryID"] = $categoryID;
		$product['weight'] = $weight;
		$product['dimensions'] = $dimensions;
		$product['weightUnit'] = $weightUnit;
		$product['dimensionsUnit'] = $dimensionsUnit;
		
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


