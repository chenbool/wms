<?
/*
 * Barcode Encoder tool
 * (C) 2008, Eric Stern
 * http://www.firehed.net, http://www.eric-stern.com
 *
 * This code may be re-used or re-distributed in any application, commercial
 * or non-commercial, free of charge provided that this credit remains intact.
 *
 */


class Barcode {
	protected static $code39 = array(
	'0' => 'bwbwwwbbbwbbbwbw','1' => 'bbbwbwwwbwbwbbbw',
	'2' => 'bwbbbwwwbwbwbbbw','3' => 'bbbwbbbwwwbwbwbw',
	'4' => 'bwbwwwbbbwbwbbbw','5' => 'bbbwbwwwbbbwbwbw',
	'6' => 'bwbbbwwwbbbwbwbw','7' => 'bwbwwwbwbbbwbbbw',
	'8' => 'bbbwbwwwbwbbbwbw','9' => 'bwbbbwwwbwbbbwbw',
	'A' => 'bbbwbwbwwwbwbbbw','B' => 'bwbbbwbwwwbwbbbw',
	'C' => 'bbbwbbbwbwwwbwbw','D' => 'bwbwbbbwwwbwbbbw',
	'E' => 'bbbwbwbbbwwwbwbw','F' => 'bwbbbwbbbwwwbwbw',
	'G' => 'bwbwbwwwbbbwbbbw','H' => 'bbbwbwbwwwbbbwbw',
	'I' => 'bwbbbwbwwwbbbwbw','J' => 'bwbwbbbwwwbbbwbw',
	'K' => 'bbbwbwbwbwwwbbbw','L' => 'bwbbbwbwbwwwbbbw',
	'M' => 'bbbwbbbwbwbwwwbw','N' => 'bwbwbbbwbwwwbbbw',
	'O' => 'bbbwbwbbbwbwwwbw','P' => 'bwbbbwbbbwbwwwbw',
	'Q' => 'bwbwbwbbbwwwbbbw','R' => 'bbbwbwbwbbbwwwbw',
	'S' => 'bwbbbwbwbbbwwwbw','T' => 'bwbwbbbwbbbwwwbw',
	'U' => 'bbbwwwbwbwbwbbbw','V' => 'bwwwbbbwbwbwbbbw',
	'W' => 'bbbwwwbbbwbwbwbw','X' => 'bwwwbwbbbwbwbbbw',
	'Y' => 'bbbwwwbwbbbwbwbw','Z' => 'bwwwbbbwbbbwbwbw',
	'-' => 'bwwwbwbwbbbwbbbw','.' => 'bbbwwwbwbwbbbwbw',
	' ' => 'bwwwbbbwbwbbbwbw','*' => 'bwwwbwbbbwbbbwbw',
	'$' => 'bwwwbwwwbwwwbwbw','/' => 'bwwwbwwwbwbwwwbw',
	'+' => 'bwwwbwbwwwbwwwbw','%' => 'bwbwwwbwwwbwwwbw');


	public static function code39($text, $height = 50, $widthScale = 1) {
		if (!preg_match('/^[A-Z0-9-. $+\/%]+$/i', $text)) {
			throw new Exception('Invalid text input.');
		}
		
		$text = '*' . strtoupper($text) . '*'; // *UPPERCASE TEXT*
		$length = strlen($text);

		$barcode = imageCreate($length * 16 * $widthScale, $height);

		$bg = imagecolorallocate($barcode, 255, 255, 0); //sets background to yellow
		imagecolortransparent($barcode, $bg); //makes that yellow transparent
		$black = imagecolorallocate($barcode, 0, 0, 0); //defines a color for black

		$chars = str_split($text);

		$colors = '';

		foreach ($chars as $char) {
			$colors .= self::$code39[$char];
		}

		foreach (str_split($colors) as $i => $color) {
			if ($color == 'b') {
				// imageLine($barcode, $i, 0, $i, $height-13, $black);
				imageFilledRectangle($barcode, $widthScale * $i, 0, $widthScale * ($i+1) -1 , $height-13, $black);
			}
		}

		//16px per bar-set, halved, minus 6px per char, halved (5*length)
		// $textcenter = $length * 5 * $widthScale;
		$textcenter = ($length * 8 * $widthScale) - ($length * 3);
		
		imageString($barcode, 2, $textcenter, $height-13, $text, $black);

		header('Content-type: image/png');
		imagePNG($barcode);
		imageDestroy($barcode);
		exit;
	} // function code39
	
} // class barcode
