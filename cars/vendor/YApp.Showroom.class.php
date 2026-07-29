<?php 

    class YAppShowroom {

        ////////////////////////////////////////////////////////////////
		// Help  ///////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		
		public static function sp( $q, $hide = false, $title = false ) {
			
			echo '<pre '.(($hide)?'style="display:none;"':'').'>';
			if ( $title ) echo $title.'<br />-------------------------------<br />';
			print_r( $q );
			echo '</pre>';
        }
        public static function sd( $q, $hide = false, $title = false ) {
			
			echo '<pre '.(($hide)?'style="display:none;"':'').'>';
			if ( $title ) echo $title.'<br />-------------------------------<br />';
			var_dump( $q );
			echo '</pre>';
        }

		public static function getWorld( $q = 0, $flag = 'd' ) {
			
			$res = [
				'day' => ['день', 'дня', 'дней'],
				'hour' => ['час', 'часа', 'часов'],
				'mminute' => ['минута', 'минуты', 'минут'],
				'second' => ['секунда', 'секунды', 'секунд'],
				'auto' => ['автомобиль', 'автомобиля', 'автомобилей'],
				'hot' => ['горячее предложение', 'горячих предложения', 'горячих предложений'],
                'offer' => ['предложение', 'предложения', 'предложений'],
                'record' => ['запись', 'записи', 'записей'],
                'feedback' => ['отзыв', 'отзыва', 'отзывов'],
                'option' => ['опция', 'опции', 'опций'],
			];
			
			$t1 = [1];
			$t2 = [2,3,4];
            
            for ( $i=20; $i<=5000; $i+=10 ) array_push( $t1, $i+1 );
			for ( $i=20; $i<=5000; $i+=10 ) foreach ( [2,3,4] as $k ) if ( $i % 100 != 10 ) array_push( $t2, $k+$i );
			
			$test = [$t1, $t2];
			
			if ( in_array( (int)$q, $test[0] ) ) return $res[$flag][0];
			if ( in_array( (int)$q, $test[1] ) ) return $res[$flag][1];
			return $res[$flag][2];
		}

		public static function makePagination( $q, $current, $perpage ) {

			$res['total'] = intdiv( $q, $perpage );
			if ( $res['total'] < $q/$perpage ) $res['total']++;

			$res['current'] = $current;

			if ( $res['total'] > 7 ) {

				if ( $current > 1 ) {
					$res['items'][] = ['text'=>'<<', 'page'=>1];
					$res['items'][] = ['text'=>'<', 'page'=>$current-1];
				}

				if ( $current > 4 && $current < $res['total']-3 ) {

					$res['items'][] = ['text'=>'..', 'page'=>false];
					for ( $i = $current-3; $i <= $current+3; $i++) $res['items'][] = ['text'=>$i, 'page'=>$i, 'current'=>($i==$current)];
					$res['items'][] = ['text'=>'..', 'page'=>false];

				} elseif ( $current >= $res['total']-3 ) {

					$res['items'][] = ['text'=>'..', 'page'=>false];
					for ( $i = $res['total']-7; $i <= $res['total']; $i++) $res['items'][] = ['text'=>$i, 'page'=>$i, 'current'=>($i==$current)];
					
				} else {

					for ( $i = 1; $i <= 7; $i++) $res['items'][] = ['text'=>$i, 'page'=>$i, 'current'=>($i==$current)];
				}

				if ( $current < $res['total']-3 ) {
					$res['items'][] = ['text'=>'>', 'page'=>$current+1];
					$res['items'][] = ['text'=>'>>', 'page'=>$res['total']];
				}

			} else {

				for ( $i = 1; $i <= $res['total']; $i++) $res['items'][] = ['text'=>$i, 'page'=>$i, 'current'=>($i==$current)];
			}
			// if ( $current > 1 ) {
			// 	$res['items'][] = ['text'=>'<<', 'page'=>1];
			// 	$res['items'][] = ['text'=>'<', 'page'=>$current-1];
			// }
			// if ( $curren > 4 && $res['total'] > 7 ) {
			// 	$res['items'][] = ['text'=>'..', 'page'=>false];
			// 	for ( $i = $current-3; $i <= $current+3; $i++)
			// } 

			return $res;
		}


		public function phoneIn( $phone ) {
			
			// +7 (111) 111-11-11 -> 71111111111
			
			$phone = preg_replace('/[^0-9]/', '', $phone);
			$phone = mb_substr($phone, 0, 11);
			
			if ( mb_strlen($phone) == 10 ) $phone = '7'.$phone;
			if ( mb_strlen($phone) == 7 ) $phone = '7861'.$phone;
			if ( $phone[0] == '8' ) $phone = '7'.mb_substr($phone, 1);
			
			return $phone;
		}
		public function phoneOut( $str ) {
			
			// 71111111111 -> +7 (111) 111-11-11
			
			$str = self::phoneIn( $str );
			
			for ($k = 0; $k < mb_strlen((string)$str); $k++) $phone[] = mb_substr($str, $k, 1);
			return '+'.$phone[0].' ('.$phone[1].$phone[2].$phone[3].') '.$phone[4].$phone[5].$phone[6].'-'.$phone[7].$phone[8].'-'.$phone[9].$phone[10];
		}


		////////////////////////////////////////////////////////////////
		// Init  ///////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		
		public function __construct( $conf = [] ) {
            
			$this->Conf = $conf;
        }
		public function Conf() {
			
			return $this->Conf;
		}

        ////////////////////////////////////////////////////////////////
		// Route  //////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

        public function makeFilter(
			$q = CURRENT_URL,
			$GET = []
		) {
			$raw = array_slice(explode('/', $q), $this->Conf['nestLevel']+3);
			$res = [];

			// Костыль для omoda-КРАСНОДАР
			$u = explode('-', $raw[0]);
			if ( !!$u[1] && $u[1] == 'krasnodar' ) {
				$raw[0] = $u[1];
				$raw = array_merge(
					array_slice( $raw, 0, 1 ),
					[ $u[0] ],
					array_slice( $raw, 1 )
				);
			}

			foreach ( $raw as $k => $i ) {

				$item = $this->getEntityFilter($i);
				switch ( $k ) {

					case 0: 
						if ( explode('-', $i)[0] == 'page' ) {
							$res['page'] = (int)explode('-', $i)[1];
						} else {
							$push = ( $item ) ?: ['brand'=>$i];
							foreach ( $push as $pk => $pi ) $res[$pk] = $pi;
						}
						break;
					case 1:
						if ( explode('-', $i)[0] == 'page' ) {
							$res['page'] = (int)explode('-', $i)[1];
						} else {
							$push = ( $item ) ?: [(($res['city'])?'brand':'model')=>$i];
							foreach ( $push as $pk => $pi ) $res[$pk] = $pi;
						}
						break;
					case 2: 
						if ( explode('-', $i)[0] == 'page' ) {
							$res['page'] = (int)explode('-', $i)[1];
						} else {
							$push = ( $item ) ?: [(($res['city'])?'model':'vehicle')=>$i];
							foreach ( $push as $pk => $pi ) $res[$pk] = $pi;
						}
						break;
					case 3: 
						if ( explode('-', $i)[0] == 'page' ) {
							$res['page'] = (int)explode('-', $i)[1];
						} else {
							$push = [];
							if ( $res['city'] ) $push = ( $item ) ?: ['vehicle'=>$i];
							foreach ( $push as $pk => $pi ) $res[$pk] = $pi;
						}
						break;
					default: break;
				}
			}

			foreach ( $GET as $pk => $pi ) $res[$pk] = $pi;
			foreach ( $res as $k => $i ) if ( !$i ) unset( $res[$k] );
			if ( !$res['page'] ) $res['page'] = 1;
			if ( $res['city'] ) {
				foreach ( explode(',', $res['city']) as $q ) $cookie[] = $q;
				setcookie('SELECTED_CITY', json_encode($cookie), time()+3600*24*14, '/');
			}

			$res['site'] = $_SERVER['HTTP_HOST'];
			if ( !empty($this->Conf['Api']['Params']) ) $res = array_merge($res, $this->Conf['Api']['Params']);

            return $res;
        }
		public function __makeFilter(
			$q = CURRENT_URL,
			$GET = []
		) {
			$raw = array_slice(explode('/', $q), $this->Conf['nestLevel']+3);
			$res = [];

			// Костыль для omoda-КРАСНОДАР
			YApp::sp($raw, true, 'in');
			$u = explode('-', $raw[0]);
			YApp::sp( $u, true, 'u');
			if ( !!$u[1] && $u[1] == 'krasnodar' ) {
				$raw[0] = $u[1];
				$raw = array_merge(
					array_slice( $raw, 0, 1 ),
					[ $u[0] ],
					array_slice( $raw, 1 )
				);
			}
			YApp::sp($raw, true, 'out');

			foreach ( $raw as $k => $i ) {

				$item = $this->getEntityFilter($i);
				switch ( $k ) {

					case 0: 
						$arr = explode('-', $i);
						if ( $arr[0] == 'page' ) {
							$res['page'] = (int)explode('-', $i)[1];
						} else {
							$push = ( $item ) ?: ['brand'=>$i];
							foreach ( $push as $pk => $pi ) $res[$pk] = $pi;
						}
						break;
					case 1:
						if ( explode('-', $i)[0] == 'page' ) {
							$res['page'] = (int)explode('-', $i)[1];
						} else {
							$push = ( $item ) ?: [(($res['city'])?'brand':'model')=>$i];
							foreach ( $push as $pk => $pi ) $res[$pk] = $pi;
						}
						break;
					case 2: 
						if ( explode('-', $i)[0] == 'page' ) {
							$res['page'] = (int)explode('-', $i)[1];
						} else {
							$push = ( $item ) ?: [(($res['city'])?'model':'vehicle')=>$i];
							foreach ( $push as $pk => $pi ) $res[$pk] = $pi;
						}
						break;
					case 3: 
						if ( explode('-', $i)[0] == 'page' ) {
							$res['page'] = (int)explode('-', $i)[1];
						} else {
							$push = [];
							if ( $res['city'] ) $push = ( $item ) ?: ['vehicle'=>$i];
							foreach ( $push as $pk => $pi ) $res[$pk] = $pi;
						}
						break;
					default: break;
				}
			}

			foreach ( $GET as $pk => $pi ) $res[$pk] = $pi;
			foreach ( $res as $k => $i ) if ( !$i ) unset( $res[$k] );
			if ( !$res['page'] ) $res['page'] = 1;
			if ( $res['city'] ) {
				foreach ( explode(',', $res['city']) as $q ) $cookie[] = $q;
				setcookie('SELECTED_CITY', json_encode($cookie), time()+3600*24*14, '/');
			}

			$res['site'] = $_SERVER['HTTP_HOST'];

            return $res;
        }


		private function getEntityFilter( $q ) {

			switch ( $q ) {

				case 'maykop': $res['city'] = 'Майкоп'; break;
				case 'novorossiysk': $res['city'] = 'Новороссийск'; break;
				case 'krasnodar': $res['city'] = 'Краснодар'; break;
				case 'yablonovskiy': $res['city'] = 'Яблоновский'; break;
				case 'sochi': $res['city'] = 'Сочи'; break;
				case 'stavropol': $res['city'] = 'Ставрополь'; break;
				case 'rostov-na-donu': $res['city'] = 'Ростов-на-Дону'; break;

				case 'min-probeg':
				case 'min-nalog':
				case 'one-owner':
				case 'under-warranty':
				case 'original-pts':
					$res['compilation'] = $q;
					break;

				default:
					$arQ = explode('-', $q);
					switch ( $arQ[0] ) {
						case 'body': 
						case 'drive':
						case 'transmission':
						case 'color':
						case 'engine':
							$res[$arQ[0]] = $arQ[1];
							break;
						case 'price':
						case 'volume':
						case 'power':
						case 'year':
							$res[$arQ[0]] = $arQ[1].','.$arQ[2];
							break;
						default: $res = false; break;
					}
					break;
			}

			return $res;
		}
		public function getCityAlias( $q ) {

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
		public function getCityName( $q ) {

			$res = false;
			
			switch ( $q ) {
				case 'maykop': $res = 'Майкоп'; break;
				case 'novorossiysk': $res = 'Новороссийск'; break;
				case 'krasnodar': $res = 'Краснодар'; break;
				case 'yablonovskiy': $res = 'Яблоновский'; break;
				case 'sochi': $res = 'Сочи'; break;
				case 'Стstavropolврополь': $res = 'Ставрополь'; break;
				case 'rostov-na-donu': $res = 'Ростов-на-Дону'; break;
			}

			return $res;
		}

		public function makeFilterBreadcrumbs( $filter, $f ) {
			
			$city = false;
			if ( !empty($filter['city']) && !is_array($filter['city']) ) {
				$res[] = $city = [
					'link' => $this->Conf['baseUrl'].'/'.$this->getCityAlias($filter['city'][0]).'/',
					'text' => $filter['city']
				];
			}

			if ( $filter['brand'] && count(explode(',', $filter['brand']))==1 ) {
				
				$tmp['link'] = ( $city ) ? $city['link'].$filter['brand'].'/' : $this->Conf['baseUrl'].'/'.$filter['brand'].'/';
				
				foreach ( $f['dropLists']['brands'] as $i ) {
					if ( $i['code'] == $filter['brand'] ) {
						$tmp['text'] = $i['name'];
						break;
					}
				}
				$res[] = $brand = $tmp;
				if ( $filter['model'] && count(explode(',', $filter['model']))==1 ) {
					$tmp['link'] = $brand['link'].$filter['model'].'/';
					foreach ($f['dropLists']['models'] as $i ) {
						if ( $i['code'] == $filter['model'] ) {
							$tmp['text'] = $i['name'];
							break;
						}
					}
					$res[] = $tmp;
				}
			}

			if ( !empty($res) ) $res[count($res)-1]['link'] = '';

			return $res;
		}

		public function makeVehicleBreadcrumbs( $v ) {

			$res[] = [
				'link' => $this->Conf['baseUrl'].'/'.$v['brand']['code'].'/',
				'text' => $v['brand']['name'],
			];

			$res[] = [
				'link' => $this->Conf['baseUrl'].'/'.$v['brand']['code'].'/'.$v['model']['code'].'/',
				'text' => $v['model']['name'],
			];

			$res[] = [
				'link' => '',
				'text' => $v['brand']['name'].' '.$v['model']['name'].' '.(($v['equipment'])?:''),
			];

			return $res;
		}

		// public function setCityCookie() {

		// 	$c = ( json_decode($_COOKIE['SELECTED_CITY'], true) ) ?: [];
		// 	if ( !empty($c) ) {
		// 		foreach ( $c as $q ) $res[] = $this->getCityName($q);
		// 		return implode(',', $res);
		// 	} else {
		// 		foreach ( explode(',', 'Краснодар,Яблоновский,Новороссийск') as $q ) $res[] = $this->getCityAlias($q);
		// 		setcookie('SELECTED_CITY', json_encode($res), time()+3600*24*14, '/');
		// 		return 'Краснодар,Яблоновский,Новороссийск';
		// 	}
		// }
		// public function setCityCookie() {

		// 	$c = json_decode($_COOKIE['SELECTED_CITY'], true) ?: [];
		// 	$c = array_unique($c);
		// 	if ( !empty($c) ) {
		// 		if ( 
		// 			in_array('maykop', $c) ||
		// 			in_array('novorossiysk', $c) ||
		// 			in_array('krasnodar', $c) ||
		// 			in_array('yablonovskiy', $c) ||
		// 			in_array('sochi', $c) ||
		// 			in_array('stavropol', $c) ||
		// 			in_array('rostov-na-donu', $c)
		// 			)  {
		// 			foreach ( explode(',', 'Краснодар,Яблоновский,Новороссийск,Майкоп') as $q ) $res[] = $q;
		// 			setcookie('SELECTED_CITY', json_encode(array_unique($res)), time()+3600*24*14, '/');
		// 			return 'Краснодар,Яблоновский,Новороссийск,Майкоп';
		// 		} else {
		// 			return implode(',', $c);
		// 		}
		// 	} else {
		// 		foreach ( explode(',', 'Краснодар,Яблоновский,Новороссийск,Майкоп') as $q ) $res[] = $q;
		// 		setcookie('SELECTED_CITY', json_encode(array_unique($res)), time()+3600*24*14, '/');
		// 		return 'Краснодар,Яблоновский,Новороссийск,Майкоп';
		// 	}
		// }
		public function getCityCookie() {

			$res = json_decode($_COOKIE['SELECTED_CITY'], true) ?: [];
			$res = array_unique($res);
			if ( empty($res) ) foreach ( explode(',', 'Краснодар,Яблоновский,Новороссийск,Майкоп') as $q ) $res[] = $q;
			return $res;
		}

		public static function httpGet($url) {
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
			curl_close($ch);
			return $resp;
		}

		public function makeApiUrl( $arQ = [], $entity = 'vehicles' ) {

			switch ( $entity ) {
				case 'filter': 
				case 'brands': 
					unset($arQ['page']); break;
				default: break;
			}

			$type = $this->Conf['Api']['mode'];
			$baseURL = $this->Conf['Api']['baseURL'];

			// Convert old range params to Go API format
			foreach ( ['price','volume','power','year'] as $p ) {
				if ( isset($arQ[$p]) ) {
					$parts = explode(',', $arQ[$p]);
					if ( count($parts) == 2 ) {
						$arQ[$p.'_from'] = $parts[0];
						$arQ[$p.'_to'] = $parts[1];
					}
					unset($arQ[$p]);
				}
			}

			// Convert comma-separated multi-value filter parameters to array format for Go API
			foreach ( ['engine', 'color', 'body', 'drive', 'transmission', 'brand', 'model', 'dealership'] as $p ) {
				if ( isset($arQ[$p]) && is_string($arQ[$p]) && strpos($arQ[$p], ',') !== false ) {
					$arQ[$p] = explode(',', $arQ[$p]);
				}
			}

			if ( $entity == 'vehicle' ) {
				$url = $baseURL.'/vehicle/'.$arQ['vehicle'].'?type='.$type.'&token='.$this->Conf['Api']['token'];
			} else {
				unset($arQ['vehicle'], $arQ['mode'], $arQ['site']);
				$params = array_merge(
					['type' => $type, 'token' => $this->Conf['Api']['token']],
					$arQ,
					$this->Conf['Api']['Params']
				);
				$url = $baseURL.'/'.$entity.'?'.http_build_query($params);
			}
			return $url;

		}

		public function makeFilterUrl( $filter, $params = [], $page = false, $expand = false ) {

			unset($filter['mode']);
			unset($filter['!brand']);
			if ( $params['clear'] ) {
				$params = [];
				foreach ( $filter as $k => $i ) if ( $k != 'perpage' && $k != 'sort' ) unset($filter[$k]);
			}

			if ( array_key_exists('mode', $params) ) return $this->Conf['assetsUrl'].'/'.$params['mode'].'/';

			unset($filter['site'], $filter['city']);

			foreach ( array_keys($params) as $p ) {
				if ( !$params[$p] ) unset($filter[$p]);
				if ( $filter[$p] ) {
					switch ( $p ) {
						case 'price': 
						case 'power':
						case 'volume':
						case 'year':
						case 'sort':
						case 'perpage':
							if ( $params[$p] ) $filter[$p] = $params[$p];
							break;

						default:
							$tmp = explode(',', $filter[$p]);
							$needle = array_search($params[$p], $tmp);
							if ( $needle !== false ) {
								unset($tmp[$needle]);
								if ( $filter['brand'] ) unset($filter['model']);
							} else {
								$tmp[] = $params[$p];
							}
							sort($tmp);
							if (empty($tmp)) {
								unset($filter[$p]);
							} else {
								$filter[$p] = implode(',', $tmp);
							}
							break;
					}
				} else {
					if ( $params[$p] ) $filter[$p] = $params[$p];
				}
				
			}

			$res = $this->Conf['baseUrl'].'/';
			if ( $filter['city'] && count(explode(',', $filter['city']))==1 ) {
				// 
				$res .= $this->getCityAlias($filter['city']).'/';
				unset($filter['city']);
			}
			if ( $filter['brand'] && count(explode(',', $filter['brand']))==1 ) {
				$res .= $filter['brand'].'/';
				if ( $filter['model']  && count(explode(',', $filter['model']))==1 ) {
					$res .= $filter['model'].'/';
					unset($filter['model']);
				}
				unset($filter['brand']);
			}
			unset($filter['page']);
			if ( $page ) $filter['page'] = $page;

			if ( !$filter['brand'] || !$filter['model'] ) {

				foreach ( array_keys($filter) as $p ) {
					switch ( $p ) {
						case 'body': 
						case 'drive':
						case 'transmission':
						case 'engine':
						case 'page':
						case 'color':
							if ( count(explode(',', $filter[$p])) == 1 ) {
								if ($filter[$p]) $res .= $p.'-'.$filter[$p].'/';
								unset($filter[$p]);
								break;
							}
							break;
					}
				}
			}

			if ( !$filter['city'] ) unset($filter['city']);
			if ( $filter['dealership'] ) unset($filter['!dealership']);
			if ( $expand ) $filter['filter'] = 'expand';

			if ( $params['clear'] ) foreach ( $filter as $k => $i ) if ( $k != 'perpage' || $k != 'sort' ) unset($filter[$k]);

			if ( !empty($filter) ) {
				$res .= '?'.http_build_query(
					array_merge(
						$filter
					)
				);
			}
			
			return $res;
		}



		public function getTagName( $items, $code, $params = ['select_fields'=>['code']] ) {

			foreach ( $items as $item ) {
				foreach ( $params['select_fields'] as $field ) if ( $item[$field] == $code ) return $item['name'];
			}
			return ''; 
		}



        ////////////////////////////////////////////////////////////////
		// HTML Layouts  ///////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		public function renderTitle( $data ) {

		}

    }