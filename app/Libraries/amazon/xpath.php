<?php
namespace App\Amazon;

use tidy;
class XPATH{

	public $dom, $xpath;

	public function __construct($url){
		$this->html = $this->_curl($url);
		$this->dom = new \DOMDocument();
		@$this->dom->loadHTML($this->html);
		$this->xpath = new \DOMXpath($this->dom);
	}


	public function spechTables(){
		$regexp = '/\n+/';
		$htmlNoSpaces = preg_replace($regexp, "", $this->html);
		$regexp = '/<table\b[^>]*>(.*?)<\/table>/';
		preg_match_all($regexp, $htmlNoSpaces, $matches);
		foreach($matches as $key => $value){
			foreach($value as $table){
				//if (strpos($table,'productDetails')) {
					$array[] = $table;
			//	}
			}
		}
		if (isset($array)) {
			$html = implode($array);
			$head = "<!DOCTYPE html> <html><head><title></title></head><body>";
			$foot = "</body></html>";
			$html = $head . $html . $foot;
			//$processed = HTMLAWED::htmLawed($html);

			$tidy = new Tidy();
			$tidy->parseString($html);
			$tidy->cleanRepair();
			// $html = $tidy->value;
			//$html = preg_replace('/\n+/', " ", $html);
			//$html = preg_replace('/[\\\]/', "", $html);
			$dom = new \DOMDocument();
			$dom->preserveWhiteSpace = FALSE;
			$dom->formatOutput = true;
			$dom->saveHTML();
			
			@$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
			
			$xpath = new \DOMXpath($dom);
			//("//tr[contains(.,'envío')]//td");
			// innermost(//*[contains(normalize-space(.), "some text")])
			// (//table[contains(normalize-space(.),'Peso del env')])[1]

			// $peso = $xpath->query("(//table)"); 
			// $peso = $this::xpathToArray($peso);
			//Peso del envío\s*[^\d]+(\d+\.*\,*\d*)\s*[\w]+
			//preg_match_all("/envío\s*\n*(\d+\.*\,*\d*)\s*\n*(\w+)/", $html, $match);
			// Dimensiones del producto\s*[^\d]+[^\<]+
			preg_match_all("/Peso del envío\s*[^\d]+(\d+\.*\,*\d*)\s*(\w+)/", $html, $peso);
			preg_match_all("/Dimensiones\s*[^\d]+([^\<]+)/", $html, $dimensiones);
			$result  = array(implode(array_unique($dimensiones[1])), implode(array_unique($peso[1])), implode(array_unique($peso[2])));
			
			if (implode($result)) {
				return $result;
			}else{
				return 0;
			}
			//return array_unique($peso[1]);
		}else{
			return;
		}
	}
		


	public function query($q){
		$result = $this->xpath->query($q);
		return $result;
	}

	public function xpathToArray($results){
		if (sizeof($results)>0) {
			foreach ($results as $result) {
				$result = trim($result->nodeValue);
				$array[] = $result;
			}
			return $array;	
		}else{
			$array[] = 0;
			return $array;
		}
		// print_r(sizeof());
		
	}

	public function preview($results){
		echo "<pre>";
		print_r($results);
		$array = self::xpathToArray($results);
		print_r($array);
	}	

	public function images($results){
		$array = self::xpathToArray($results);
		$regexImg = '/(?<=hiRes":")([^\"]+)/';
		preg_match_all($regexImg, $array[0], $matches);
		$matches = ($matches[0]);
		return $matches;
	}

	public function musicImages($results){
		$array = self::xpathToArray($results);
		$regexImg = '/(?<=large":")([^\"]+)/';
		preg_match_all($regexImg, $array[0], $matches);
		$matches = ($matches[0]);
		return $matches;
	}

	public function title($results){
		$array = self::xpathToArray($results);
		$regex = '/De|de\s{5,}\r*/';
		$regexSpaces = '/\s{5,}\r*/';
		$str = preg_replace($regex, "", $array[0]);
		$str = preg_replace($regexSpaces, " ", $str);
		return $str;
	}

	public function description($results){
		$array = self::xpathToArray($results);
		return implode("\n",$array);
	}

	public function breadcrumb($results){
		$array = self::xpathToArray($results);
		return implode("-",$array);
	}

	public function price($results){
		if(self::xpathToArray($results)){
			$array = self::xpathToArray($results);
			$regex = '/(\d+\.*\d+)/';
			preg_match_all($regex, ($array[0]), $matches);
			return floatval(implode(".",$matches[0]));
		}else{
			return "0.0";
		}
	}

	private function _curl($url){
		$ch = curl_init();
		curl_setopt_array($ch, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_FOLLOWLOCATION => 1,
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "user-agent: Mozilla/5.0 (Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36" // Here we add the header
		  ),
		));
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		 if($httpcode == "404"){
		 	return 'error';
		 	exit;
		 }
		if (!$result) {
			echo "<pre>";
			echo "<br/>CURL error number: ". curl_errno($ch);
			echo "<br>";
			echo "<br/>CURL error: ". curl_error($ch). " on URL: " . $url;
			echo "<br>";
			var_dump(curl_getinfo($ch));
			var_dump(curl_error($ch));
			exit;
		}
		curl_close($ch);
		return $result;
	}
}

function categoryML($title){
	$categoryUrl = 'https://api.mercadolibre.com/sites/MCO/category_predictor/predict?title='.$title;
	$categoryUrl = preg_replace("/\s+|\&/", "%20", $categoryUrl);
	// Get cURL resource
	$curl = curl_init();
	curl_setopt_array($curl, array(
			  CURLOPT_URL => $categoryUrl,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "user-agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36"
	    ),
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
	$resp = json_decode($resp);
	return $resp;
}
