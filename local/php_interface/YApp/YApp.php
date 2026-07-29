<?php
	
	if (file_exists(__DIR__ . '/../yapps_config.php')) {
		require_once __DIR__ . '/../yapps_config.php';
	} else {
		class YAppConfig {
			const API_DOMAIN = 'apps.yug-avto.ru';
			const GO_API_DOMAIN = 'apps.yug-avto.ru';
		}
	}

	class YApp extends YAppConfig {

        ////////////////////////////////////////////////////////////////
		// Contst  /////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		
		const MAIN_TEMPLATE = '/local/templates/yugavto_theme';

		const VUE_APPS = '/local/vue-apps';

		const IBLOCK_FORM_SETTINGS = 3;
		const IBLOCK_FORMS = 24;
		const IBLOCK_DEALERSHIPS = 4;
		const IBLOCK_BRANDS = 5;
		const IBLOCK_BODY_TYPES = 8;
		const IBLOCK_NEWS = 11;
		const IBLOCK_HISTORY = 12;
		const IBLOCK_OFFERS = 13;

		const IBLOCK_PAGES = 17;
		const IBLOCK_VACANCIES = 14;

		const IBLOCK_SEO = 19;

		const IBLOCK_STORIES = 6;
		
		
		////////////////////////////////////////////////////////////////
		// Init  ///////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
        
        public function _construct() {
            
        }

        ////////////////////////////////////////////////////////////////
		// Help  ///////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		
		public static function sp( $q, $hide = false, $title = false ) {
			
			echo '<noindex><pre '.(($hide)?'style="display:none;"':'').'>';
			if ( $title ) echo $title.'<br />-------------------------------<br />';
			print_r( $q );
			echo '</pre></noindex>';
        }
        
        public static function sd( $q, $hide = false, $title = false ) {
			
			echo '<noindex><pre '.(($hide)?'style="display:none;"':'').'>';
			if ( $title ) echo $title.'<br />-------------------------------<br />';
			var_dump( $q );
			echo '</pre></noindex>';
        }


        ////////////////////////////////////////////////////////////////
		// Safe  ///////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		
		public static function Safe( $data ) {
			
			return stripslashes( htmlspecialchars( strip_tags( trim( $data))));
		}
		
		public static function VRequest( $data ) {
			
			foreach ( $data as $k => $v ) $data[self::Safe($k)] = self::Safe($v);
			return $data;
		}


        ////////////////////////////////////////////////////////////////
		// Worlds  /////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		
		public static function getWorld( $q = 0, $flag = 'd' ) {
			
			$res = [
				'd' => ['день', 'дня', 'дней'],
				'h' => ['час', 'часа', 'часов'],
				'm' => ['минута', 'минуты', 'минут'],
				's' => ['секунда', 'секунды', 'секунд'],
				'a' => ['автомобиль', 'автомобиля', 'автомобилей'],
				'c' => ['город', 'города', 'городов'],
				'b' => ['бренд', 'бренда', 'брендов'],
				'v' => ['вакансия', 'вакансии', 'вакансий'],
				'n' => ['новый', 'новых', 'новых'],
				'dc' => ['дилерский центр', 'дилерских центра', 'дилерских центров'],
				'dealership_pr' => ['дилерском центре', 'дилерских центрах', 'дилерских центрах'],
				'dealer' => ['дилерский', 'дилерских', 'дилерских'],
				'center' => ['центр', 'центра', 'центров']
			];

			$t1 = [1];
			$t2 = [2,3,4];

			$t3 = [];
			for ( $i=11; $i<=5000; $i+=100 ) array_push( $t3, $i );
            
            for ( $i=20; $i<=5000; $i+=10 ) if ( !in_array($i+1, $t3) ) array_push( $t1, $i+1 );
			for ( $i=20; $i<=5000; $i+=10 ) foreach ( [2,3,4] as $k ) if ( $i % 100 != 10 ) array_push( $t2, $k+$i );
			
			$test = [$t1, $t2];
			
			if ( in_array( (int)$q, $test[0] ) ) return $res[$flag][0];
			if ( in_array( (int)$q, $test[1] ) ) return $res[$flag][1];
			return $res[$flag][2];
		}        
		
		public static function toPrepositional($str) {


			if (in_array( substr($str, -1), ['и','о','е','ё','э'])) return $str;
			if (in_array( substr($str, -3), ['ово','ево','ино','ыно'])) return $str;
		
			$custom_cities = [
				'Ростов-на-дону' => 'Ростове-на-дону',
				'Сочи' => 'Сочи'
			];
			if (isset($custom_cities[$str])) return $custom_cities[$str];
		
			$replace = array();
			$replace['2'][] = array('ия','ии');
			$replace['2'][] = array('ия','ии');
			$replace['2'][] = array('ий','ом');
			$replace['2'][] = array('ое','ом');
			$replace['2'][] = array('ая','ой');
			$replace['2'][] = array('ль','ле');
			$replace['1'][] = array('а','е');
			$replace['1'][] = array('о','е');
			$replace['1'][] = array('и','ах');
			$replace['1'][] = array('ы','ах');
			$replace['1'][] = array('ь','и');
		
			foreach ($replace as $length => $replacement) {
				$str_length = mb_strlen($str, 'UTF-8');
				$find = mb_substr($str, $str_length - $length, $str_length, 'UTF-8');
				foreach($replacement as $try) {
					if ( $find == $try[0] ) {
						$str = mb_substr($str, 0, $str_length - $length, 'UTF-8');
						$str .= $try['1'];
						return $str;
					}
				}
			}
			if ($find == 'е') {
				return $str;
			} else {
				return $str.'е';
			}
		
		}

		////////////////////////////////////////////////////////////////
		// Phone  //////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		
		public static function phoneIn( $phone ) {
			
			// +7 (111) 111-11-11 -> 71111111111
			
			$phone = preg_replace('/[^0-9]/', '', $phone);
			$phone = mb_substr($phone, 0, 11);
			
			if ( mb_strlen($phone) == 10 ) $phone = '7'.$phone;
			if ( mb_strlen($phone) == 7 ) $phone = '7861'.$phone;
			if ( $phone[0] == '8' ) $phone = '7'.mb_substr($phone, 1);
			
			return $phone;
		}
		
		public static function phoneOut( $str ) {
			
			// 71111111111 -> +7 (111) 111-11-11
			
			$str = self::phoneIn( $str );
			
			for ($k = 0; $k < mb_strlen((string)$str); $k++) $phone[] = mb_substr($str, $k, 1);
			return '+'.$phone[0].' ('.$phone[1].$phone[2].$phone[3].') '.$phone[4].$phone[5].$phone[6].'-'.$phone[7].$phone[8].'-'.$phone[9].$phone[10];
		}

        public static function phoneBase( $str ) {

            // 71111111111 -> +7 (111) 111-11-11

            $str = self::phoneIn( $str );

            for ($k = 0; $k < mb_strlen((string)$str); $k++) $phone[] = mb_substr($str, $k, 1);
            return '+'.$phone[0].' '.$phone[1].$phone[2].$phone[3].' '.$phone[4].$phone[5].$phone[6].' '.$phone[7].$phone[8].' '.$phone[9].$phone[10];
        }
		
		
		////////////////////////////////////////////////////////////////
		// Email  //////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		
		public static function findEmails( $text ) {
			
			preg_match_all( '/\b([a-z0-9._-]+@[a-z0-9.-]+)\b/i', $text, $res );
			return $res[0];
        }
        

        ////////////////////////////////////////////////////////////////
		// HTML ////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

        public static function minify($buffer) {
            $search = array(
                '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
                '/[^\S ]+\</s',  // strip whitespaces before tags, except space
                '/(\s)+/s'       // shorten multiple whitespace sequences
            );
            $replace = array(
                '>',
                '<',
                '\\1'
            );
            $res = preg_replace($search, $replace, $buffer);
            return $res;
        }


		////////////////////////////////////////////////////////////////
		// Timer ///////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		public static function getTimer( $start, $stop ) : array {

			$time = (int)$stop - (int)$start;

			$res['Days'] = intdiv($time, 24*60*60);
			$res['Hours'] = intdiv($time - $res['Days']*24*60*60, (60*60));
			$res['Minuts'] = intdiv($time - $res['Days']*24*60*60 - $res['Hours']*60*60, 60);
			$res['Seconds'] = $time - $res['Days']*24*60*60 - $res['Hours']*60*60 - $res['Minuts']*60;
			
			return $res;
		}

		public static function formatNumber( $q ) {

			return number_format((float)$q, 0, '', ' ');
		}

		public static function numFormat( $q ) {

			return number_format((float)$q, 0, '.', ' ');
		}




		////////////////////////////////////////////////////////////////
		// Meta ////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		public static function getCISMeta() {

			$query = $_GET;
			$arUrl = explode('/', parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])['path']);
			$query['token'] = '34b5ac8b71018c0bc7e5c050ed90b243';
			$query['site'] = $_SERVER['HTTP_HOST'];
			if ( $arUrl[2] ) $query['entity'] = $arUrl[2];
			if ( $arUrl[3] ) $query['brand'] = $arUrl[3];
			if ( $arUrl[4] ) $query['model'] = $arUrl[4];
			if ( $arUrl[5] ) $query['id'] = $arUrl[5];
			if ( $_SESSION['CITY'] ) $query['city'] = $_SESSION['CITY'];

			$url = 'https://'.self::API_DOMAIN.'/API/get/cis/meta/'.$query['entity'].'/?'.http_build_query($query);
			// static::sp( $url, true );

			$res = json_decode( file_get_contents($url), true );
			$res['url'] = $url;
			
			return $res;
		}

		public static function getSEOPath( $q ) {

			$res = explode('/', parse_url($q)['path']);
			if ( !$res[count($res)-1] ) unset($res[count($res)-1]);
			unset($res[0]);
			return '/'.implode('/', $res);
		}






		////////////////////////////////////////////////////////////////
		// Logs ////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		public static function LogRequest( $dir = __DIR__, $ip = false, $request = false, $server = false ) {

			if ( $ip ) {

				$ips = ( file_exists($dir.'/log_request/ips.json') ) ? json_decode(file_get_contents($dir.'/log_request/ips.json'), true) : [];
				if ( $ips[$_SERVER['REMOTE_ADDR']] ) 
					$ips[$_SERVER['REMOTE_ADDR']]++;
				else
					$ips[$_SERVER['REMOTE_ADDR']] = 1;

				if ( !file_exists($dir.'/log_request') ) mkdir($dir.'/log_request');
				file_put_contents( $dir.'/log_request/ips.json', json_encode($ips) );
			}

			if ( $request ) {

				if ( !file_exists($dir.'/log_request') ) mkdir($dir.'/log_request');
				if ( !file_exists($dir.'/log_request/'.date('Y')) ) mkdir($dir.'/log_request/'.date('Y'));
				if ( !file_exists($dir.'/log_request/'.date('Y').'/'.date('m')) ) mkdir($dir.'/log_request/'.date('Y').'/'.date('m'));
				if ( !file_exists($dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d')) ) mkdir($dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d'));
				if ( !file_exists($dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d').'/request') ) mkdir($dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d').'/request');

				file_put_contents( $dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d').'/request/'.$_SERVER['REMOTE_ADDR'].'__'.date('H').'-'.date('s').'-'.date('i').'.txt', print_r($_REQUEST, true) );
			}

			if ( $server ) {

				if ( !file_exists($dir.'/log_request') ) mkdir($dir.'/log_request');
				if ( !file_exists($dir.'/log_request/'.date('Y')) ) mkdir($dir.'/log_request/'.date('Y'));
				if ( !file_exists($dir.'/log_request/'.date('Y').'/'.date('m')) ) mkdir($dir.'/log_request/'.date('Y').'/'.date('m'));
				if ( !file_exists($dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d')) ) mkdir($dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d'));
				if ( !file_exists($dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d').'/server') ) mkdir($dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d').'/server');

				file_put_contents( $dir.'/log_request/'.date('Y').'/'.date('m').'/'.date('d').'/server/'.$_SERVER['REMOTE_ADDR'].'__'.date('H').'-'.date('s').'-'.date('i').'.txt', print_r($_SERVER, true) );
			}
		}

		public static function Log( $data = [], $dir = __DIR__, $folder = 'logs', $name = 'log', $format = 'json' ) {

			if ( !file_exists($dir.'/'.$folder) ) mkdir($dir.'/'.$folder);
			if ( !file_exists($dir.'/'.$folder.'/'.date('Y')) ) mkdir($dir.'/'.$folder.'/'.date('Y'));
			if ( !file_exists($dir.'/'.$folder.'/'.date('Y').'/'.date('m')) ) mkdir($dir.'/'.$folder.'/'.date('Y').'/'.date('m'));
			if ( !file_exists($dir.'/'.$folder.'/'.date('Y').'/'.date('m').'/'.date('d')) ) mkdir($dir.'/'.$folder.'/'.date('Y').'/'.date('m').'/'.date('d'));

			switch ( $format ) {
				case 'json': $res = json_encode($data); break;
				case 'txt': $res = print_r($data, true); break;
				case 'text': $res = print_r($data, true); break;
				default: $res = (string)$data;
			}

			file_put_contents( $dir.'/'.$folder.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$name.'.'.(($format=='json')?:'txt'), $res );
		}

		////////////////////////////////////////////////////////////////
		// Cookie //////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		public static function setCityCookie() {

			$c = json_decode($_COOKIE['SELECTED_CITY'], true) ?: [];
			$c = array_unique($c);
			if ( !empty($c) ) {
				if ( 
					in_array('maykop', $c) ||
					in_array('novorossiysk', $c) ||
					in_array('krasnodar', $c) ||
					in_array('yablonovskiy', $c) ||
					in_array('sochi', $c) ||
					in_array('stavropol', $c) ||
					in_array('null', $c) ||
					in_array(null, $c) ||
					in_array('rostov-na-donu', $c)
					)  {
					foreach ( explode(',', 'Краснодар,Яблоновский,Новороссийск,Майкоп') as $q ) $res[] = $q;
					setcookie('SELECTED_CITY', json_encode(array_unique($res)), time()+3600*24*14, '/');
					return 'Краснодар,Яблоновский,Новороссийск,Майкоп';
				} else {
					return implode(',', $c);
				}
			} else {
				foreach ( explode(',', 'Краснодар,Яблоновский,Новороссийск,Майкоп') as $q ) $res[] = $q;
				setcookie('SELECTED_CITY', json_encode(array_unique($res)), time()+3600*24*14, '/');
				return 'Краснодар,Яблоновский,Новороссийск,Майкоп';
			}
		}

		public static function getCityName( $q ) {

			switch ( $q ) {
				case 'maykop': $res = 'Майкоп'; break;
				case 'novorossiysk': $res = 'Новороссийск'; break;
				case 'krasnodar': $res = 'Краснодар'; break;
				case 'yablonovskiy': $res = 'Яблоновский'; break;
				case 'sochi': $res = 'Сочи'; break;
				case 'stavropol': $res = 'Ставрополь'; break;
				case 'rostov-na-donu': $res = 'Ростов-на-Дону'; break;
			}

			return $res;
		}

		public static function getCityAlias( $q ) {

			switch ( $q ) {
				case 'Майкоп': $res = 'maykop'; break;
				case 'Новороссийск': $res = 'novorossiysk'; break;
				case 'Краснодар': $res = 'krasnodar'; break;
				case 'Яблоновский': $res = 'yablonovskiy'; break;
				case 'Сочи': $res = 'sochi'; break;
				case 'Ставрополь': $res = 'stavropol'; break;
				case 'Ростов-на-Дону': $res = 'rostov-na-donu'; break;
			}

			return $res;
		}

		////////////////////////////////////////////////////////////////
		// Filters /////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		public static function makeFilterUrl( $GET = [], $params = [], $multiple = true ) {

			$baseUrl =  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].explode('?', $_SERVER['REQUEST_URI'])[0];
			if ( empty($params) ) return $baseUrl;
			foreach ( array_keys($params) as $kp ) {
				if ( !$params[$kp] ) {
					unset($GET[$kp]);
					continue;
				}
				$tmp = array_unique(array_diff(explode(',', $GET[$kp]),['']));
				$needle = array_search($params[$kp], $tmp);
				if ( $needle !== false ) {
					unset($tmp[$needle]);
				} else {
					$tmp[] = $params[$kp];
				}
				if ( empty($tmp) ) {
					unset($GET[$kp]);
					continue;
				}
				$GET[$kp] = implode(',', $tmp);
				if ( !$multiple ) $GET[$kp] = $params[$kp];
			}
			if ( !empty($GET) ) $baseUrl .= '?'.http_build_query($GET);

			return $baseUrl;
		}

		public static function httpGet($url) {
			$attempts = 6;
			$resp = false;
			for ($i = 0; $i < $attempts; $i++) {
				$ch = curl_init($url);
				curl_setopt_array($ch, [
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_TIMEOUT => 3,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_SSL_VERIFYHOST => false,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
				]);
				$resp = curl_exec($ch);
				$err = curl_errno($ch);
				curl_close($ch);
				
				if ($resp !== false && $err === 0) {
					break;
				}
				if ($i < $attempts - 1) {
					usleep(100000); // 100 мс
				}
			}
			return $resp;
		}

		public static function InArrValues($array, $needle){
			return array_filter($array, fn($v) => strpos($v, $needle) !== FALSE);
		}

		public static function getCleanAltText($title, $limit = 55, $maxLimit = 60) {
			$title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
			$title = trim(strip_tags($title));
			$title = preg_replace('/\s+/', ' ', $title);
			
			if (mb_strlen($title) <= $limit) {
				return $title;
			}
			
			$nextSpace = mb_strpos($title, ' ', $limit);
			if ($nextSpace !== false && $nextSpace <= $maxLimit) {
				return mb_substr($title, 0, $nextSpace);
			}
			
			$subLimit = mb_substr($title, 0, $limit);
			$lastSpace = mb_strrpos($subLimit, ' ');
			if ($lastSpace !== false) {
				return mb_substr($subLimit, 0, $lastSpace);
			}
			
			return $subLimit;
		}
	}





