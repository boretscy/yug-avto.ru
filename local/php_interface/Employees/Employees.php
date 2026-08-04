<?php
    class Employees {

        public static function getUser( $str = null ) {

            $res = ['status'=>false, 'description'=>'Что-то пошло не так'];
            
            if ( $str ) {
                
                $url = 'https://portal.yug-avto.ru/service/employees/api/?search='.$str;
                $res = json_decode(
                    file_get_contents($url),
                    true
                );
                if ($res) $res['status'] = true;
            }
            return $res;
        }

        public static function selectDesign( $user = [] ) {
            
            $user['DESIGN'] = 'all';
            $test = [
                ['str'=>'олдинг', 'design'=>'all'],
                ['str'=>'ксперт', 'design'=>'expert'],
                ['str'=>'xpert', 'design'=>'expert'],
            ];
            if ( !empty($user) ) {
                foreach ( $test as $t ) {
                    if ( !empty(YApp::InArrValues($user, $t['str'])) ) {
                        $user['DESIGN'] = $t['design'];
                        return $user;
                    }
                }
            }
            return $user;
        }

        public static function makeSite( $user = [] ) {

            $user['SITE'] = 'https://yug-avto.ru/';
            $test = [
                ['str'=>'олдинг', 'url'=>'https://yug-avto.ru/'],
                ['str'=>'ксперт', 'url'=>'https://yug-avto-expert.ru/'],
                ['str'=>'xpert', 'url'=>'https://yug-avto-expert.ru/'],
            ];
            if ( !empty($user) ) {
                foreach ( $test as $t ) {
                    if ( !empty(YApp::InArrValues($user, $t['str'])) ) {
                        $user['SITE'] = $t['url'];
                        return $user;
                    }
                }
            }
            return $user;
        }

        public static function makeSocial( $user = [] ) {
            
            $url = 'https://yug-avto.ru/employees/'.$user['UF_FULL_NAME'].' ('.$user['ID'].')/';

            if ( !empty($user) ) {
                $user['WHATSAPP'] = 'https://api.whatsapp.com/send?text='.$user['UF_FULL_NAME'].', '.$user['WORK_POSITION'].', '.$user['WORK_COMPANY'].' '.str_replace(' ', '%2520', $url);
                $user['TELEGRAM'] = 'https://t.me/share/url?url='.str_replace(' ', '%2520', $url).'&text='.$user['UF_FULL_NAME'].', '.$user['WORK_POSITION'].', '.$user['WORK_COMPANY'];                
                $user['MAX'] = 'max://share?text='.$user['UF_FULL_NAME'].', '.$user['WORK_POSITION'].', '.$user['WORK_COMPANY'].' '.str_replace(' ', '%2520', $url);
                // $user['WHATSAPP'] = 'https://api.whatsapp.com/send?text='.$user['LAST_NAME'].' '.$user['NAME'].', '.$user['WORK_POSITION'].', '.$user['WORK_COMPANY'].' https://yug-avto.ru/';
                // $user['TELEGRAM'] = 'https://t.me/share/url?url=https://yug-avto.ru/&text='.$user['LAST_NAME'].' '.$user['NAME'].', '.$user['WORK_POSITION'].', '.$user['WORK_COMPANY'];

                return $user;
            }
            return $user;
        }

        public static function makeVCard( $user = [], $filename = 'export.vcf' ) {

            $res = 'BEGIN:VCARD'.PHP_EOL;
            $res .= 'VERSION:3.0'.PHP_EOL;
            $res .= 'FN:'.$user['UF_FULL_NAME'].PHP_EOL;
            $res .= 'N:'.$user['LAST_NAME'].';'.$user['NAME'].';'.$user['SECOND_NAME'].PHP_EOL;
            $res .= 'ORG:'.$user['WORK_COMPANY'].PHP_EOL;
            $res .= 'TITLE:'.$user['WORK_POSITION'].PHP_EOL;
            $res .= 'URL:https://yug-avto.ru/'.PHP_EOL;
            $res .= 'EMAIL;TYPE=INTERNET:'.$user['EMAIL'].PHP_EOL;
            $res .= 'TEL:'.YApp::phoneOut($user['PERSONAL_MOBILE']).PHP_EOL;
            $res .= 'TEL:'.YApp::phoneOut($user['WORK_PHONE']).PHP_EOL;
            $res .= 'END:VCARD';
            file_put_contents('vcards/'.$filename, $res);

            return false;
        }
    }
?>