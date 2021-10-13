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
public function dd()
		 {
			 echo '<pre>';
			 array_map(function($x) {var_dump($x);}, func_get_args());
			 die("Controller/Traits/Services/General.php - dd function");
		  }


###################################################################

//Return min and max date from array
public function getMinAndMaxDate($date_arr) {
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


return $minMax = [
		  "max" => date('d-m-Y',strtotime($max_date)), 
		  "min" => date('d-m-Y',strtotime($min_date))
		  ];
			
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

 public function generateHash($lenght = 10)
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
public function parse_json($data, $status_code = 200 )
{
    set_status_header($status_code, "");
    header("Content-type: application/json");

    echo json_encode($data);
    exit;
}

###################################################################



