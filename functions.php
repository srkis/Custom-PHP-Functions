<!--
***********************************************
* Author: Srdjan Stojanovic                   *
* Author URL: https:srdjan.icodes.rocks       *
* Email: stojanovicsrdjan27@gmail.com         *
* THANK YOU FOR INTERESTING FOR MY CODE:)     *
*                                             *
********************************************* *
-->


//Die dump function - Laravel style
function dd() {
      echo '<pre>';
      array_map(function($x) {var_dump($x);}, func_get_args());
      die("Controller/Traits/Services/General.php - dd function");
 }


###################################################################

//Return min and max date from array
function getMinAndMaxDate($date_arr) {
	 if(is_array($date_arr) && count($date_arr) > 0 ) {

		  for ($i = 0; $i < count($date_arr); $i++) {
		      if ($i == 0) {

			    $max_date = date('Y-m-d H:i:s', strtotime($date_arr[$i]));
			    $min_date = date('Y-m-d H:i:s', strtotime($date_arr[$i]));
			  }
			  else if ($i != 0) {
			      $new_date = date('Y-m-d H:i:s', strtotime($date_arr[$i]));
			      if ($new_date > $max_date) {
				  $max_date = $new_date;
			      } else if ($new_date < $min_date) {
				  $min_date = $new_date;
			      }
			  }
		      }


	return array( "max" => date('d-m-Y',strtotime($max_date)), "min" => date('d-m-Y',strtotime($min_date)) );
	}
}

###################################################################

//Get the language used by the client browser:

function get_client_language($availableLanguages, $default='en'){
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		$langs=explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);

		foreach ($langs as $value){
			$choice=substr($value,0,2);
			if(in_array($choice, $availableLanguages)){
				return $choice;
			}
		}
	} 
	return $default;
}

###################################################################

//Create random hash. Default length is 10.

 function generateHash($lenght = 10)
  {
      $hashChars = 'qwertyuioasdfghjkl12234567890AQWSEDRFTGYHUJIKOLPZ';
      $charLenght = strlen($hashChars);
      $randHash = '';
      for($i = 0; $i < $lenght; $i++){
          $randHash.= $hashChars[rand(0, $charLenght -1)];
      }
      return $randHash;
  }

###################################################################

//Create json from array
function parse_json($data, $status_code = 200 )
{
    set_status_header($status_code, "");
    header("Content-type: application/json");

    echo json_encode($data);
    exit;
}

###################################################################

// Get post from xml rss feed


function getRSS($link){
	$rss = file_get_contents($link);

	$xml = simplexml_load_string($rss);

	$posts = array();
	foreach($xml->channel->item as $item){
		$posts[] = array(
		'image' => (string)$item->image,
		'title' => (string)$item->title,
		'description' => (string)$item->description,
		'pubDate' => (string)$item->pubDate,
		'link' => (string)$item->link
		);
	}
	return $posts;

###################################################################
Function that return string between characters. For this example i use this "< >" signs in string

function getStringsBetweenChars($str, $startDelimiter, $endDelimiter) {
		$contents = array();
		$startDelimiterLength = strlen($startDelimiter);
		$endDelimiterLength = strlen($endDelimiter);
		$startFrom = $contentStart = $contentEnd = 0;
		while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
			$contentStart += $startDelimiterLength;
			$contentEnd = strpos($str, $endDelimiter, $contentStart);
			if (false === $contentEnd) {
				break;
			}
			$contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
			$startFrom = $contentEnd + $endDelimiterLength;
		}

		return $contents;
	}

Usage: 

$text = 'Lorem Ipsum is simply <This string will be returned> Lorem Ipsum is simply <Again, this will be returned as second element of array>.';
$new = getStringsBetweenChars($text, '<', '>');

print_r($new);

array(2) {
  [0]=>
  string(56) "This string will be returned"
  [1]=>
  string(106) "Again, this will be returned as second element of array"
}


###################################################################

Check if difference in 2 mutidimensional arrays

function check_diff_multi($array1, $array2) {
		$result = array();

	foreach($array1 as $key => $val) {
		for($i = 0; $i < count($array2); $i++){
		    if(isset($array2[$i][$key])){
			if(is_array($val) && $array2[$i][$key]){
		          $result[$key] = $this->check_diff_multi($val, $array2[$i][$key]);
			}
			} else {
			   $result[$key] = $val;
			}
		}

	}
          return $result;
}


###################################################################

	// First delete all files from the folder, then remove folder	
	 function deleteFilesFromDirectory($target) {
		if(is_dir($target)){
			$files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

			foreach( $files as $file ){
				delete_files( $file );
			}

			rmdir( $target );
		} elseif(is_file($target)) {
			unlink( $target );
		}
	}

###################################################################

function createZip() {
	 // Get real path for our folder
	 $rootPath = realpath(/path/to/your/writable/folder); // get files from the folder

	 $zip_file = 'yourname.zip';
	 // Initialize archive object
	 $zip = new ZipArchive();
	 $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
	// Create recursive directory iterator
 	/** @var SplFileInfo[] $files */
	$files = new RecursiveIteratorIterator(
    	  new RecursiveDirectoryIterator($rootPath),
          RecursiveIteratorIterator::LEAVES_ONLY
	);

	foreach ($files as $name => $file) {
	  // Skip directories (they would be added automatically)
	  if (!$file->isDir()) {
	      // Get real and relative path for current file
	     $filePath = $file->getRealPath();
	     $relativePath = substr($filePath, strlen($rootPath) + 1);
        	// Add current file to archive
	     $zip->addFile($filePath, $relativePath);
	  }
	}
         // Zip archive will be created only after closing object
	 $zip->close();

	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=$zip_file");
	header("Content-Type: application/zip");
	header("Content-Transfer-Encoding: binary");

	// Read the file
	readfile($zip_file);

	//unlink($zip_file);  // remove zip if you dont need it anymore

	exit();
    }
    
  ###################################################################
  
    // Format Date
  function formatDate($date){
  	return date('F j, Y, g:i a', strtotime($date));
 }
 
 ###################################################################
  // Return shorten text with $limit characters and dots at end 
  
  function textShorten($text, $limit = 400){
  $text = $text. " ";
  $text = substr($text, 0, $limit);
  $text = substr($text, 0, strrpos($text, ' '));
  $text = $text.".....";
  return $text;
 }
 
 ###################################################################
 
   //Validate request ($_POST, $_GET)
   
  function validation($data){
  $data = trim($data);
  $data = stripcslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }  
 
 ###################################################################
 
   // Return 'time ago'
  function timeAgo($timestamp){

     $timeAgo = strtotime($timestamp);
     $currentTime = time();
     $timeDiff = $currentTime - $timeAgo;
     $seconds = $timeDiff;
     $minutes = round($seconds / 60);  // value of 60 is seconds
     $hours = round($seconds / 3600); //value of 3600 is 60 * 60
     $days = round($seconds / 86400); // 86400 = 24 *60 * 60
     $weeks = round($seconds / 604800); // 7 * 24 * 60 *60
     $months = round($seconds / 2629440);  // ((365+365+365+365) / 5 /12) * 24*60*60
     $year = round($seconds / 31553280);  //((365+365+365+365+365)/5 *24 *60 *60

    if($seconds <= 60){
        return "Just now";
    }
    else if($minutes <=60)
    {
        if($minutes == 1)
        {
            return "One minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    else if($hours <=24)
    {
        if($hours == 1)
        {
            return "an hour ago";
        }
        else{
            return "$hours hrs ago";
        }
    }
    else if($days <=7)
    {
        if($hours == 1)
        {
            return "yesterday";
        }
        else{
            return "$days days ago";
        }
    }
    else if($weeks <=4.3) // 4.3 = 52/12
    {
        if($weeks == 1)
        {
            return "a week ago";
        }
        else{
            return "$weeks weeks ago";
        }
    }

    else if($months <= 12)
    {
        if($months == 1)
        {
            return "a month ago";
        }
        else{
            return "$months months ago";
        }
    }

    else
    {
        if($year == 1)
        {
            return "one year ago";
        }
        else{
            return "$year years ago";
        }
    }

 } 
 
 ###################################################################
 
 function cleanInput($input) {

  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );

    $output = preg_replace($search, '', $input);
    return $output;
  }
 
 Use cleanInput function with sanitize function
 
 function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = mysql_real_escape_string($input);
    }
    return $output;
}

	//Example
	$bad_string = "Hi! <script src='http://www.evilsite.com/bad_script.js'></script> It's a good day!";
 	$good_string = sanitize($bad_string);
  	// $good_string returns "Hi! It\'s a good day!"

  	// Also use for getting POST/GET variables
  	$_POST = sanitize($_POST);
 	$_GET  = sanitize($_GET);
 
    
   ###################################################################
    
    function validate_email($email) {
	  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	     return false;
	   }else{
		return $email;
		}

	}
	
###################################################################

Search multidimensional array, find values and count it. Return @int count value

function searhCountArrayValues($array, $value){
array_walk_recursive($array, function ($i) use (&$count) {
	$count += (int) ($i === $value);
  });
 	return $count;
}


###################################################################
Format dateTime function
//input value: 2019-02-27 14:29:34
// returned value : 27 Feb, 02:29 PM
public function formatDateTime($dateTime)
{
  $yrdata = strtotime($dateTime);
  return $date = date('d M, h:i A', $yrdata);
}

###################################################################
 // Function to get the client ip address
    public function getUserIp() {

        $ipaddress = '';
	    if (array_key_exists('HTTP_CLIENT_IP', $_SERVER))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (array_key_exists('HTTP_X_FORWARDED_FOR',$_SERVER))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(array_key_exists('HTTP_X_FORWARDED',$_SERVER))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(array_key_exists('HTTP_FORWARDED', $_SERVER))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(array_key_exists('REMOTE_ADDR', $_SERVER))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

###################################################################

define("DEFAULT_HASH", "data_HASH!@#$%^&");

function encryptData($dataToEncrypt) {

        $encrypted_string = openssl_encrypt($dataToEncrypt,"AES-128-ECB", DEFAULT_HASH);
        return $encrypted_string;

    }

###################################################################
   
   function decryptData($dataToDecrypt) {

        $decrypted_string = openssl_decrypt($dataToDecrypt,"AES-128-ECB", DEFAULT_HASH);
        return $decrypted_string;
    }
    
    
    
