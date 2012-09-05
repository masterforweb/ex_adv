<?php





  class adv_comp {

  	function space($id) {

  		$items = Table('adv_items')->where('space_id', $id)->where('adv_active')->result_array();

     	if (!$items)
  			return null;

        /*выбираем текущий элеменt*/
        foreach ($items as $item) {
  				$url = SITE.URI;
          if ($item['adv_alias'] == '')  //сквозной элемент
	  				$arr[] = $item;
  				else {
  					if (mb_strpos($item['adv_alias'], ';') !== FALSE) { //несколько значений фмльтра
  						$sarr = explode(';', $item['adv_alias']);
  						foreach ($sarr as $c) {
  							if (mb_strpos($url, trim($c)) !== FALSE){
  								$arr[] = $item;
  								break;
                }  
  						}

  					}
  					elseif (mb_strpos($url, $item['adv_alias']) !== FALSE) 
              $arr[] = $item;
             
  				}	

  			if (is_array($arr)) { //получаем текущий элемент
  				$count = sizeof($arr)-1;
  				$curr = rand(0, $count);
  				$result = $arr[$curr]; 
  			}	

  		}

 		  

      if ($result['item_code'] !== '')
  			return $result['item_code']; //возвращаем код
  		elseif($result['adv_file'] == 'swf') 
  		    return $this->swf($result);
      else
          return $this->img($result); //возвращаем оформленный код графического файл


  		return null;	

  	}


  	function img ($item) {

      return '<a href="'.$item['adv_link'].'" alt="'.$item['adv_alt'].'" target="_blank"><img src="http://www.argumenti.ru/images/partners/'.$item['item_id'].'.'.$item['adv_file'].'" width="'.$item['adv_width'].'" height="'.$item['adv_height'].'"></a>';

  	}

    function swf ($item) {
          
      $file = 'http://www.argumenti.ru/images/partners/'.$item['item_id'].'.'.$item['adv_file'];
      return "<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0 width=".$item['adv_width']." height=".$item['adv_height']."><param name=movie value='".$file."'><param name=quality value=high><embed src='".$file."' quality=high pluginspage=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash type=application/x-shockwave-flash width=".$item['adv_width']." height=".$item['adv_height']."></embed></object>";
      
    }



    


  }