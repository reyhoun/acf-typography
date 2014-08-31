<?php


		$json = file_get_contents('googlefonts.json');
		$fontArray = json_decode( $json);

		$files = "json.arr";  
		$myfile = fopen($files, 'wb');

		fwrite($myfile, '{ "kind": "webfonts#webfontList", "items": [');
		foreach ( $fontArray as $k => $v ) {
					$dataarray = '{ "kind": "webfonts#webfont", "family": "' .$k . '", "variants": [';
					fwrite($myfile, $dataarray);

						foreach ($v as $key => $value) {
 							foreach ($value as $key2 => $value2) {
								foreach ($value2 as $key3 => $value3) {
 
									if ($key == 'variants' ) {

										$dataarray = '"' .$value3 .'"';
										fwrite($myfile, $dataarray);
										
										    // if (!($value3 === end($value2))){
											        fwrite($myfile, ",");
											// }
											
											
									};


								}
							}
						}

					fwrite($myfile, "]}");
					if ($fontArray != end($v))
				 		fwrite($myfile, ",");

				}
		fwrite($myfile, "]}");
		
		print "Data Written hu";
		print $myfile;
		fclose($myfile);






?>
