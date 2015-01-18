<?php
prob20();
function prob15()
{
	$a = array();
	$len = 20;
	for ($i=0; $i < $len; $i++) {
		$a[] = array(); 
		for ($j=0; $j < $len; $j++) { 
			$a[$i][] = 0;
		}
	}

	for ($i=0; $i < $len; $i++) { 
		$a[$i][$len] = 1;
		$a[$len][$i] = 1;
	}

	$result = sum2Point( 0, 0, $len, $a ) ;
	var_dump($result);
}


function sum2Point($x, $y, $len, &$a)
{

	$s1 = 0;
	if($a[$x+1][$y] > 0)
	{
		$s1 = $a[$x+1][$y]; 
	}
	else
	{
		$s1 = sum2Point($x+1, $y, $len, $a);
	}

	$s2 = 0;
	if($a[$x][$y+1] > 0)
	{
		$s2 = $a[$x][$y+1]; 
	}
	else
	{
		$s2 = sum2Point($x, $y+1, $len, $a);
	}
	$sum = $s1 + $s2;
	$a[$x][$y] = $sum;
	return $sum;
}

function prob17()
{
	$s10_19 = 3 + 6 + 6 + 8 + 8 + 7 + 7 + 9 + 8 + 8;
	$s1_9 = 3 + 3 + 5 + 4 + 4 + 3 + 5 + 5 + 4;
	$s20_90 = 6 + 6 + 5 + 5 + 5 + 7 + 6 + 6;
	$and = 3;
	$hundred = 7;
	$num_and = 900 - 9;
	$num_hundred = 900;
	$num_hd_s1_9 = 100;
	$s_1_99 = $s1_9 + $s10_19 + $s20_90*10 + $s1_9 * 8;

	$S_1_99 = $s_1_99 * 10;
	$S_and = $and * $num_and;
	$S_hundred = $hundred * $num_hundred + $s1_9 * 100;
	$S1000 = 11;

	$S = $S1000 + $S_1_99 + $S_hundred + $S_and;

	var_dump($S);
}

function prob18()
{
	$str ="75
95 64
17 47 82
18 35 87 10
20 04 82 47 65
19 01 23 75 03 34
88 02 77 73 07 63 67
99 65 04 28 06 16 70 92
41 41 26 56 83 40 80 70 33
41 48 72 33 47 32 37 16 94 29
53 71 44 65 25 43 91 52 97 51 14
70 11 33 28 77 73 17 78 39 68 17 57
91 71 52 38 17 14 91 43 58 50 27 29 48
63 66 04 68 89 53 67 30 73 16 69 87 40 31
04 62 98 27 23 09 70 98 73 93 38 53 60 04 23";

$matrix = convertStrToMatrix($str);
$maxIndex = count($matrix) - 2; //line 2 tu duoi len
//var_dump($maxIndex); die();
for ($i = $maxIndex; $i >=0 ; $i--) { 
	$len = count($matrix[$i]);
	for($j = 0; $j< $len; $j++ )
	{
		$matrix[$i][$j] = maxTriangle($matrix[$i][$j], $matrix[$i+1][$j], $matrix[$i+1][$j+1]);
	}
	//var_dump($matrix[$i]); die();
}

var_dump($matrix[0][0]);

}

function maxTriangle( $top, $left, $right )
{
	$s_left =  $top + $left;
	$s_right = $top + $right;
	return $s_left > $s_right ? $s_left : $s_right;
}

function convertStrToMatrix($str)
{
	$lines = split("\n", $str);
	$matrix = array();
	foreach ($lines as $line) {
		$nums = split(" ", $line);
		$nums = array_map(function($x){return intval($x);}, $nums);
		$matrix[] = $nums;
	}
	return $matrix;
}

function prob19()
{
	$year = 1900;
	$monthsInfo = array(array('name'=>"jan", 'days'=>"31"),
						array('name'=>"feb", 'days'=>"28"),
						array('name'=>"mar", 'days'=>"31"),
						array('name'=>"apr", 'days'=>"30"),
						array('name'=>"may", 'days'=>"31"),
						array('name'=>"jun", 'days'=>"30"),
						array('name'=>"jul", 'days'=>"31"),
						array('name'=>"aug", 'days'=>"31"),
						array('name'=>"sep", 'days'=>"30"),
						array('name'=>"oct", 'days'=>"31"),
						array('name'=>"nov", 'days'=>"30"),
						array('name'=>"dec", 'days'=>"31"));

	$numSunday = 0;
	$sundayInfo = array();
	$temp = array('d'=>7, 'm'=>0, 'y'=>1900);
	while(true)
	{
		$day = $temp['d'] + 7;
		if($day > $monthsInfo[ $temp['m'] ]['days'])
		{
			$nextDayIndex = $day - $monthsInfo[ $temp['m'] ]['days'];
			$nextMonthIndex = $temp['m'] == 11 ? 0 : $temp['m'] + 1;
			if( $nextMonthIndex == 0 )
			{
				$nextYearIndex = $temp['y'] + 1;
				if($nextYearIndex % 4 == 0)
				{
					$days = "29";
					if($nextYearIndex % 100 == 0 && $nextYearIndex % 400 != 0)
					{
						$days = "28";
					}
				}
				else
				{
					$days = "28";
				}
				$monthsInfo[1]['days'] = $days;
			}
			else
			{
				$nextYearIndex = $temp['y'];
			}

			if($nextDayIndex == 1)
			{
				$numSunday++;
				$addStr = $monthsInfo[ $nextMonthIndex ]['name'].'_'.$nextDayIndex.'_'.$nextYearIndex;
				$sundayInfo[] = $addStr;
				var_dump($addStr);
			}

			if($nextYearIndex == 2001)
			{
				break;
			}

			$temp['d'] = $nextDayIndex;
			$temp['m'] = $nextMonthIndex;
			$temp['y'] = $nextYearIndex;
		}
		else
		{
			$temp['d'] = $day;
		}
	}
	var_dump($numSunday);
}

function getPrimeFactors($num, $store) // vd : 3^2 * 2^2 -> array(3=>2, 2=>2)
{
	$prime = 2;
	$maxPrime = $num ;
	$result = array(); // vd : 3^2 * 2^2 -> array(3=>2, 2=>2)
	while( $prime <= $maxPrime )
	{
		$count = 0;
		while( true )
		{
			$temp = $num / $prime;
			$tempRound = floor($temp);
			if($temp - $tempRound != 0)
			{
				break;	
			}
			$num = $num / $prime;
			$count ++;
			if(array_key_exists(strval($num), $store))
			{
				$result[strval($prime)] = $count;
				$storeNum = $store[strval($num)];
				foreach ($result as $factor => $pow) {
					if(array_key_exists($factor, $storeNum))
					{
						$result[$factor] = $pow + $storeNum[$factor];
					}
				}
				//var_dump(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>");
				//echo "storeNUM ";var_dump($storeNum);
				//echo "result ";var_dump($result);
				$result = $result + $storeNum;
				//echo "Merge"; var_dump($result);
				return $result;
			}
		}
		if($count > 0 )
		{
			$result[strval($prime)] = $count;
		}
		$prime = gmp_intval( gmp_nextprime($prime) );
	}
	return $result;
}

function _arrayPrimeFactorToString( $arr )
{
	$result = array();
	foreach ($arr as $prime => $pow) {
		$result[] = $pow == 1 ? $prime : $prime."^".$pow;
	}
	return implode(" * ", $result);
}

function prob20()
{
	// $pol1 = _numberToPolynomial(22);
	// $pol2 = _numberToPolynomial(345);
	// var_dump($pol1);
	// var_dump($pol2);
	// var_dump(_multiPolynomials($pol1, $pol2));
	// var_dump(_numberToPolynomial(22*345));
	// die();

	$store = array();
	//var_dump(array_diff(array('2'=>1, '3'=>2), array('2'=>2))); die();
	for($i = 2; $i<= 100; $i++)
	{
		$store[strval($i)] = getPrimeFactors($i, $store);
	}
	//var_dump($store);
	//giai thua phan tich ra thua so nguyen to
	//num is 2-> 100
	$factorials = array();
	foreach ($store as $num => $factors) {
		foreach ($factorials as $factor => $pow) {
			if(array_key_exists($factor, $store[$num]))
			{
				$factorials[$factor] = $pow + $store[$num][$factor];
			}
		}
		$factorials = $factorials + $store[$num];
	}
	var_dump($factorials);
	$sum = 0;
	var_dump(_convertPrimaryFactorsToPolynomial($factorials));
	//var_dump(pow(2, 97));
}

function _convertPrimaryFactorsToPolynomial($factors)
{
	$temp = array();
	$first = true;
	foreach ($factors as $factor => $pow) {
		if($pow > 9)
		{
			$len2 = $pow / 9;
			$mod2 = $pow - $len2 * 9;
			$pol2 = _numberToPolynomial(pow($factor, 9));
			$temp2 = $pol2;
			for ($i=2; $i <= $len2; $i++) { 
				$temp2 = _multiPolynomials($temp2, $pol2);
			}

			if($mod2 > 0)
			{
				$temp2 = _multiPolynomials($temp2, _numberToPolynomial(pow($factor, $mod2)));	
			}
			if($first){
				$temp = $temp2;
				$first = false;
			}
			else
			{
				$temp = _multiPolynomials($temp, $temp2);
			}
			continue;
		}
		$factor = pow($factor, $pow);

		if($first){
			$temp = _numberToPolynomial($factor);
			$first = false;
		}
		else
		{
			//var_dump($temp); var_dump(_numberToPolynomial($factor));
			$temp = _multiPolynomials($temp, _numberToPolynomial($factor));
			//var_dump($temp); die();
		}
	}
	$sumDigits = 0;
	foreach ($temp as $pow => $digit) {
		$sumDigits += $digit;
	}
	return $sumDigits;
}


function _numberToPolynomial($number)
{
	$numberStr = strval($number);
	$len = strlen($numberStr);
	$result = array();
	for ($i=0; $i <= $len -1; $i++) { 
		$result[strval($len -1 -$i)] = intval($numberStr[$i]);
	}
	return $result;
}

function _multiPolynomials($pol1, $pol2)
{
	$result = array();
	foreach ($pol1 as $pow1 => $num1) {
		foreach ($pol2 as $pow2 => $num2) {
			$powSum = $pow1+$pow2;
			$numSum = $num1 * $num2;
			//_debug(array($powSum, $numSum));
			if($numSum >=10)
			{
				$numSum  = strval($numSum)[1];

				_add(strval($powSum + 1), intval(strval($numSum)[0]), $result);
			}
			_add(strval($powSum), intval($numSum), $result);
		}
	}
	return $result;
}

function _add($powSumStr, $numSum, &$result)
{
	if(array_key_exists($powSumStr, $result))
	{
		$newSum = $result[$powSumStr] + $numSum;
		if( $newSum >= 10 )
		{
			$newSum = intval(strval($newSum)[1]);
			_add(strval($powSumStr + 1), intval(strval($newSum)[0]), $result);
		}
		$result[$powSumStr] = $newSum;
	}
	else
	{
		$result[$powSumStr] = $numSum;	
	}
}

function _debug($params)
{
	var_dump("-----------BEGIN------------\n");
	$str = '';
	foreach ($params as $param) {
		$str.= $param.' _ ';
	}
	var_dump("-----------END------------\n");
}