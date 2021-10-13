//Die dump function - Laravel style
public function dd()
		 {
			 echo '<pre>';
			 array_map(function($x) {var_dump($x);}, func_get_args());
			 die("Controller/Traits/Services/General.php - dd function");
		  }


###################################################################

//Return min and max date from array
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

         echo date('d-m-Y',strtotime($max_date));
         echo date('d-m-Y',strtotime($min_date));
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



