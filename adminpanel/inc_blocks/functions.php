<?php 
defined('mcsystem') or die('Cəhdin yaxşı idi, sərf etdiyin vaxtı başqa şeyə sərf et!');
function defend_input($data){
	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
	$data = strip_tags($data);
  	return $data;
}
function fungenpass(){
	$number = 7;
	$arr = array('a','b','c','d','e','f',

                 'g','h','i','j','k','l',

                 'm','n','o','p','r','s',

                 't','u','v','x','y','z',

                 '1','2','3','4','5','6',

                 '7','8','9','0');
	$pass = "";
	for($i = 0; $i < $number; $i++){
		$index = rand(0, count($arr) - 1);
      	$pass .= $arr[$index];
	}
	return $pass;
}
function number2string($number) {
	static $dic = array(
		array(
			-2	=> 'iki',
			-1	=> 'bir',
			1	=> 'bir',
			2	=> 'iki',
			3	=> 'üç',
			4	=> 'dörd',
			5	=> 'beş',
			6	=> 'altı',
			7	=> 'yeddi',
			8	=> 'səkkiz',
			9	=> 'doqquz',
			10	=> 'on',
			11	=> 'on bir',
			12	=> 'on iki',
			13	=> 'on üç',
			14	=> 'on dörd' ,
			15	=> 'on beş',
			16	=> 'on altı',
			17	=> 'on yeddi',
			18	=> 'on səkkiz',
			19	=> 'on doqquz',
			20	=> 'iyirmi',
			30	=> 'otuz',
			40	=> 'qırx',
			50	=> 'əlli',
			60	=> 'altmış',
			70	=> 'yetmiş',
			80	=> 'səksən',
			90	=> 'doxsan',
			100	=> 'bir yüz',
			200	=> 'iki yüz',
			300	=> 'üç yüz',
			400	=> 'dörd yüz',
			500	=> 'beş yüz',
			600	=> 'altı yüz',
			700	=> 'yeddi yüz',
			800	=> 'səkkiz yüz',
			900	=> 'doqquz yüz'
		),
		
		array(
			array('', '', ''),
			array('min', 'min', 'min'),
			array('milyon', 'milyon', 'milyon'),
			array('milyard', 'milyard', 'milyard'),
			array('trilyon', 'trilyon', 'trilyon'),
			array('kvadrilyon', 'kvadrilyon', 'kvadrilyon')
		),
		
		array(
			2, 0, 1, 1, 1, 2
		)
	);
	$string = array();
	$number = str_pad($number, ceil(strlen($number)/3)*3, 0, STR_PAD_LEFT);
	$parts = array_reverse(str_split($number,3));
	foreach($parts as $i=>$part) {
		if($part>0) {
			$digits = array();
			if($part>99) {
				$digits[] = floor($part/100)*100;
			}
			if($mod1=$part%100) {
				$mod2 = $part%10;
				$flag = $i==1 && $mod1!=11 && $mod1!=12 && $mod2<3 ? -1 : 1;
				if($mod1<20 || !$mod2) {
					$digits[] = $flag*$mod1;
				} else {
					$digits[] = floor($mod1/10)*10;
					$digits[] = $flag*$mod2;
				}
			}
			$last = abs(end($digits));
			foreach($digits as $j=>$digit) {
				$digits[$j] = $dic[0][$digit];
			}
			$digits[] = $dic[1][$i][(($last%=100)>4 && $last<20) ? 2 : $dic[2][min($last%10,5)]];
			array_unshift($string, join(' ', $digits));
		}
	}
	return join(' ', $string);
}
?>