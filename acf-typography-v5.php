<?php
class acf_field_typography extends acf_field {
	
	
	//=========================================================================================
	//=================== This function will setup the field type data ========================
	//=========================================================================================


	function __construct() {

		
		$this->name = 'typography';
		$this->label = __('Typography', 'acf-typography');
		$this->category = 'Choice';
		
		


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//======================== get json for extra seting ========================
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		// update json
		function json_update($API_KEY) {

			$filename = '../wp-content/plugins/acf-typography/gf.json';

			$lastdate = date ("Ymd", filemtime($filename));
			$now = date ("Ymd", time());
			$time = $now - $lastdate;

			if ($time > 2) {

				$json = file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=' . $API_KEY);

				$files = "../wp-content/plugins/acf-typography/gf.json";  
				$myfile = fopen($files, 'wb');
				fwrite($myfile, $json);
				fclose($myfile);

			}
		}


		// if $YOUR_API_KEY exist;
		if (defined('YOUR_API_KEY')) {
			json_update(YOUR_API_KEY);
		}


		//load json file for extra seting
		$dir = plugin_dir_url( __FILE__ );
		$json = file_get_contents("{$dir}gf.json");
		$fontArray = json_decode( $json);
		
		$font_familys = array();
		$valueset = array();
		foreach ( $fontArray as $k => $v ) {
			if (is_array($v))
			{
			    foreach ($v as $value)
			    {
			       foreach ($value as $key1 => $value1) {

			       		if($key1== "family"){
			       			$valueset = array($value1 => $value1);
			        		// array_push($font_familys, $valueset); 
			        		$font_familys = $font_familys + $valueset;
			        	}		
			       }
			    }
			}
		}
		// echo "<pre>";
		// var_dump( $font_familys);


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//======     defaults (array) Array of default settings which are       =====
	//====== merged into the field object. These are used later in settings =====
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


		$this->defaults = array(
			'show_font_familys'		=> 1,
			'show_font_weight'		=> 1,
			'show_backup_font'		=> 1,
			'show_text_align'		=> 1,
			'show_text_direction'	=> 1,
			'show_font_size'		=> 1,
			'show_line_height'		=> 1,
			'show_font_style'		=> 1,
			'show_preview_text'		=> 1,
			'show_color_picker'		=> 1,
			'show_letter_spacing'	=> 0,
			'font-family'		=> '',
			'font-weight'		=> '400',
            'backup-font'		=> 'Arial, Helvetica, sans-serif',
            'text_align'		=>	'left',
            'direction'			=> 'ltr',
			'font_size'			=> 20,
			'line_height'		=> 25,
			'letter_spacing'	=> 0,
			'font_style'		=> 'normal',
			'text_color'  		=> '#000000',
			'default_value'		=> '',//pak
			'new_lines'			=> '',
			'maxlength'			=> '',
			'placeholder'		=> '',
			'readonly'			=> 0,
			'disabled'			=> 0,
			'rows'				=> '',
			'font_familys'		=> $font_familys,
			'stylefont'	 		=> array( 
						'100'		=> '100',
						'300'		=> '300',
						'400'		=> '400',
						'600'		=> '600',
						'700'		=> '700',
						'800'		=> '800'
					),
			'backupfont'		=> array(
						'Arial, Helvetica, sans-serif'                          => 'Arial, Helvetica, sans-serif',
            			'"Arial Black", Gadget, sans-serif'                     => '"Arial Black", Gadget, sans-serif',
            			'"Bookman Old Style", serif'                            => '"Bookman Old Style", serif',
            			'"Comic Sans MS", cursive'                              => '"Comic Sans MS", cursive',
            			'Courier, monospace'                                    => 'Courier, monospace',
            			'Garamond, serif'                                       => 'Garamond, serif',
            			'Georgia, serif'                                        => 'Georgia, serif',
            			'Impact, Charcoal, sans-serif'                          => 'Impact, Charcoal, sans-serif',
            			'"Lucida Console", Monaco, monospace'                   => '"Lucida Console", Monaco, monospace',
            			'"Lucida Sans Unicode", "Lucida Grande", sans-serif'    => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
            			'"MS Sans Serif", Geneva, sans-serif'                   => '"MS Sans Serif", Geneva, sans-serif',
            			'"MS Serif", "New York", sans-serif'                    => '"MS Serif", "New York", sans-serif',
            			'"Palatino Linotype", "Book Antiqua", Palatino, serif'  => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
            			'Tahoma,Geneva, sans-serif'                             => 'Tahoma, Geneva, sans-serif',
            			'"Times New Roman", Times,serif'                        => '"Times New Roman", Times, serif',
            			'"Trebuchet MS", Helvetica, sans-serif'                 => '"Trebuchet MS", Helvetica, sans-serif',
            			'Verdana, Geneva, sans-serif'                           => 'Verdana, Geneva, sans-serif',
        			)
		);


		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('typography', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'acf-typography'),
		);
		
				
		// do not delete!
    	parent::__construct();
    	
	}
	



	//=========================================================================================
	//============================ extra settings for field ===================================
	//=========================================================================================

	function render_field_settings( $field ) {




		acf_render_field_setting( $field, array(
			'label'			=> __('Show Font Family ?','acf-typography'),
			'instructions'	=> __('When Font Family dont load, Font Weight & Preview Text also dont show ','acf-typography'),
			'type'			=> 'radio',
			'layout'		=> 'horizontal',
			'name'			=> 'show_font_familys',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Font Family','acf-typography'),
			'type'			=> 'select',
			'ui'			=> 1,
			'name'			=> 'font-family',
			'choices'		=>	$field['font_familys']
		));




		acf_render_field_setting( $field, array(
			'label'			=> __('Show Font Weight ?','acf-typography'),
			'type'			=> 'radio',
			'layout'		=>  'horizontal',
			'name'			=> 'show_font_weight',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Font Weight','acf-typography'),
			'type'			=> 'select',
			'ui'			=> 1,
			'name'			=> 'font-weight',
			'choices'		=>	$field['stylefont']
		));



		acf_render_field_setting( $field, array(
			'label'			=> __('Show Backup Font ?','acf-typography'),
			'type'			=> 'radio',
			'layout'		=>  'horizontal',
			'name'			=> 'show_backup_font',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));


		acf_render_field_setting( $field, array(
			'label'			=> __('Backup Font','acf-typography'),
			'type'			=> 'select',
			'ui'			=> 1,
			'name'			=> 'backup-font',
			'choices'		=>	$field['backupfont']
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Show Text Align ?','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'show_text_align',
			'choices'		=>	array(
									1	=>	__('Yes','acf-font-awesome'),
									0	=>	__('No','acf-font-awesome')
								)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Text Align','acf-typography'),
			'type'			=> 'select',
			'ui'			=> 1,
			'name'			=> 'text_align',
			'choices'		=>	array(
				'inherit',
			 	'left'		=> 'left',
			 	'right'		=> 'right', 
			 	'center'	=> 'center', 
			 	'justify'	=> 'justify', 
			 	'inital'	=> 'inital')
		));


		acf_render_field_setting( $field, array(
			'label'			=> __('Show Text direction ?','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'show_text_direction',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Text direction','acf-typography'),
			'type'			=> 'select',
			'ui'			=> 1,
			'name'			=> 'direction',
			'choices'		=>	array(  'ltr' => 'left to right',
								 		'rtl' => 'right to left',)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Show Font Size ?','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'show_font_size',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));


		acf_render_field_setting( $field, array(
			'label'			=> __('Font Size','acf-typography'),
			'type'			=> 'number',
			'name'			=> 'font_size',
			'append'		=> 'px',
		));



		acf_render_field_setting( $field, array(
			'label'			=> __('Show Line Height ?','acf-typography'), 
			'instructions'	=> __('When line height don t load line height is 150%','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'show_line_height',
			'choices'		=>	array(
									1	=>	__('Yes','acf-font-awesome'),
									0	=>	__('No','acf-font-awesome')
								)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Line Height','acf-typography'),
			'type'			=> 'number',
			'name'			=> 'line_height',
			'append'		=> 'px',
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Show Letter Spacing ?','acf-typography'), 
			'instructions'	=> __('','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'show_letter_spacing',
			'choices'		=>	array(
									1	=>	__('Yes','acf-font-awesome'),
									0	=>	__('No','acf-font-awesome')
								)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Letter Spacing','acf-typography'),
			'type'			=> 'number',
			'name'			=> 'letter_spacing',
			'append'		=> 'px',
		));


			acf_render_field_setting( $field, array(
			'label'			=> __('Show Color Picker ?','acf-typography'), 
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'show_color_picker',
			'choices'		=>	array(
									1	=>	__('Yes','acf-font-awesome'),
									0	=>	__('No','acf-font-awesome')
								)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Font Color','acf-typography'),
			'type'			=> 'text',
			'name'			=> 'text_color',
			'append'		=> 'hex',
		));




		acf_render_field_setting( $field, array(
			'label'			=> __('Show Font Style ?','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'show_font_style',
			'choices'		=>	array(
									1	=>	__('Yes','acf-font-awesome'),
									0	=>	__('No','acf-font-awesome')
								)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Font Style','acf-typography'),
			'type'			=> 'select',
			'ui'			=> 1,
			'name'			=> 'font_style',
			'choices'		=>	array(
			 		'normal'	=> 'normal',
			 		'italic'	=> 'italic',
			 		'oblique'	=> 'oblique',
			 	)
		));




		acf_render_field_setting( $field, array(
			'label'			=> __('Show Preview Text ?','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'show_preview_text',
			'choices'		=>	array(
									1	=>	__('Yes','acf-font-awesome'),
									0	=>	__('No','acf-font-awesome')
								)
		));


	}




	//=========================================================================================
	//============================== show seting in field =====================================
	//=========================================================================================

	function render_field( $field ) {
		// convert value to array
        $field['value'] = acf_force_type_array($field['value']);


        // add empty value (allows '' to be selected)
        if( empty($field['value']) ){

            $field['value'][''] = '';
            $field['value']['font-family']	 = 	$field['font-family'];
            $field['value']['font-weight']	 = 	$field['font-weight'];
            $field['value']['backupfont']	 = 	$field['backup-font'];
            $field['value']['text_align']	 =	$field['text_align'];
            $field['value']['font_size']	 =	$field['font_size'];
            $field['value']['text-color']	 =	$field['text_color'];
            $field['value']['letter_spacing']=  $field['letter_spacing'];
           
            if ($field['show_line_height']) {
            	$field['value']['line_height']	 =  $field['line_height'];
            } else {
            	$field['value']['line_height']	 =	'150%';
            }
            
            $field['value']['direction']	 =	$field['direction'];
            $field['value']['font_style']	 =	$field['font_style'];

        }

        $field_value = $field['value'];

		// echo "<style class='preview_style' id='". $field['key'] . "preview_style' ></style>";

		$style = array( 'NORMAL 400', 'SMALL 200', 'BOLD 800');
		$text_align =  array('inherit', 'left', 'right', 'center', 'justify', 'inital');
		$text_direction = array( 'ltr' => 'left to right',
								 'rtl' => 'right to left');

		$font_style = array(
			 		'normal'	=> 'normal',
			 		'italic'	=> 'italic',
			 		'oblique'	=> 'oblique');
		$s = 0;
		$e = '';

		$defaults_fonts = $field['backupfont'];

		$fontf = preg_replace('/\s+/', '+', $field_value['font-family']);


        // echo "<pre>";
        // print_r($field['value']);
        // echo "</pre>";

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//========================== show render field ==============================
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	echo "<div class='rey_main'>";

		echo "  <style class='preview_style' id='". $field['key'] . "preview_style' >
					@import url(http://fonts.googleapis.com/css?family=" . $fontf . ":" . $field_value['font-weight'] . ");
				</style>";

		echo '  <script>
						(function($){
							// $(".rey-color").wpColorPicker();
							// $(".js-select2").select2();
						})(jQuery);
				</script>';


		echo "<div class='clearfix'>";

			// Font Family selector
			if ($field['show_font_familys']){
				echo '<div class="acf-typography-subfield acf-typography-font-familys">';
					echo '<label class="acf-typography-field-label" for="'. $field['key'] .'">Font Family</label> ';
					echo '<input name="' . $field['name'] . '[font-family]" id="' . $field['key'] . 'attribute" class="select2-container font-familys" value="' . $field_value['font-family'] . '" />';
				echo '</div>';
			}


			// Font Weight selector
			if ($field['show_font_weight'] & $field['show_font_familys']) {
				echo '<div class="acf-typography-subfield acf-typography-font-weight">';
					echo  '<label class="acf-typography-field-label" for="'. $field['key'] .'">Font Weight</label>';
			 		echo '<input name="' . $field['name'] . '[font-weight]" id="' . $field['key'] . '" value="' . $field_value['font-weight'] . '" class="select2-container font-weight select2-weight" type="hidden" />';
			 		// echo '<input class="font-weight select2-weight">';
						
			 	echo '</div>';
			 }



				//Backup Font Family
				if ($field['show_backup_font']) {
					echo '<div class="acf-typography-subfield acf-typography-backup-font">';
						echo '<label class="acf-typography-field-label" for="'. $field['key'] .'">Backup Font Family</label>';
						echo '<select name="' . $field['name'] . '[backupfont]" class="js-select2">';
							foreach ( $defaults_fonts as $k => $v ) {
								echo '<option value="' . $k . '"' . selected($field_value['backupfont'], $k, false) . ' >' . $k . '</option>' ;
							}
						echo '</select>';
					echo '</div>';
				}


				// "Text Align";
				if ($field['show_text_align']) {
					echo '<div class="acf-typography-subfield acf-typography-text-align">';
						echo '<label class="acf-typography-field-label" for="'. $field['key'] .'">Text Align</label>';
						echo '<select name="' . $field['name'] . '[text_align]" id="' . $field['key'] . 'align" class="js-select2 alignF">';
							foreach ( $text_align as $k ) {
								echo '<option value="' . $k . '"' . selected($field_value['text_align'], $k, false) . ' >' . $k . '</option>' ;
							}
						echo '</select>';
					echo '</div>';
				}

			

			// "Text direction";
				if ($field['show_text_direction']) {
					echo '<div class="acf-typography-subfield acf-typography-direction">';
						echo '<label class="acf-typography-field-label" for="' . $field['key'] . '">Text Direction</label>';
						echo '<select name="' . $field['name'] . '[direction]" class="js-select2">';
							foreach ( $text_direction as $k => $v) {
								echo '<option value="' . $k . '"' . selected($field_value['direction'], $k, false) . ' >' . $v . '</option>' ;
							}
						echo '</select>';
					echo '</div>';
				}

			
				if ($field['show_font_style']){
					echo '<div class="acf-typography-subfield acf-typography-font-style">';
						echo '<label class="acf-typography-field-label" for="'. $field['key'] .'">Font Style</label>';

						echo '<select name="' . $field['name'] . '[font_style]" id="' . $field['key'] . '-font-style"  class="js-select2 font-style">';
							foreach ( $font_style as $k => $v) {
								echo '<option value="' . $k . '"' . selected($field_value['font_style'], $k, false) . ' >' . $v . '</option>' ;
							}
						echo '</select>';
					echo '</div>';
				}


				if ($field['show_font_size']) {
					echo '<div class="acf-typography-subfield acf-typography-font-size">';
						echo '<label class="acf-typography-field-label" for="' . $field['key'] . '">Font Size</label>';
						echo '
							<div class="acf-typography-field-font-size">
								<div class="acf-input-append">px</div>
								<div class="acf-input-wrap">
									<input class="sizeF" type="number" name="' . $field['name'] . '[font_size]" id="' . $field['key'] . 'size" value="' . $field_value['font_size'] . '" min="1" max="" step="any" placeholder="">
								</div>
							</div>
						';
					echo '</div>';
				}


				if ($field['show_line_height']) {
					echo '<div class="acf-typography-subfield acf-typography-font-line-height">';
						echo '<label class="acf-typography-field-label" for="' . $field['key'] . '">Line Height</label>';
						echo '
							<div class="acf-typography-field-line-height">
								<div class="acf-input-append">px</div>
								<div class="acf-input-wrap">
									<input class="lineF" type="number" name="' . $field['name'] . '[line_height]" id="' . $field['key'] . 'line" value="' . $field_value['line_height'] . '" min="1" max="" step="any" placeholder="">
								</div>
							</div>
						';
					echo '</div>';
				}

				if ($field['show_letter_spacing']) {
					echo '<div class="acf-typography-subfield acf-typography-font-line-height">';
						echo '<label class="acf-typography-field-label" for="' . $field['key'] . '">Letter Spacing</label>';
						echo '
							<div class="acf-typography-field-line-height">
								<div class="acf-input-append">px</div>
								<div class="acf-input-wrap">
									<input class="letter-spacing" type="number" name="' . $field['name'] . '[letter_spacing]" id="' . $field['key'] . '-letter-spacing" value="' . $field_value['letter_spacing'] . '" min="" max="" step="any" placeholder="">
								</div>
							</div>
						';
					echo '</div>';
				}

			

		echo '</div>';

		if ($field['show_color_picker']) {
			echo '<div class="acf-background-subfield-color acf-typography-color">';
				echo '<label class="acf-typography-field-label" for="' . $field['key'] . '">Text Color</label>';
				echo '
					<div class="acf-typography-field-line-height">
						<div class="acf-input-wrap">
                    		<input data-id="'. $field['id'] . '" name="' .  $field['name'] . '[text-color]" id="' .  $field['id'] . '-color" class="rey-color text-color" type="text" value="' . $field_value['text-color'] . '" data-default-color="#000" />
						</div>
					</div>
				';
			echo '</div>';
		}
		$css = '';
		$css = $this -> getCSS($field);

		if ($field['show_preview_text'] & $field['show_font_familys']) {
			echo '  <div class = "acf-typography-preview">
	    	   			<label class="acf-typography-field-label">Preview Text:</label>
        				<div class="preview_font ss" style="' . $css . '"></div>';

  						$di = plugin_dir_url( __FILE__ );
  						echo "<iframe class = 'acf-typography-preview-font' src='{$di}preview.php?css=" . $css . "&font=".$field['value']['font-family']."&wi=".$field['value']['font-weight']."'>";
  						echo "</iframe>";
  			echo '  </div>';
  		}

  	echo '</div>';


	}


	function getCSS($field) {
        $css = '';
        if (!empty($field['value'])) {
            foreach($field['value'] as $key=>$value) {
                if (!empty($value)) {
                    if ($key != "backupfont") {

                    	switch ($key) {
                    		case 'text_align':
                    			$css .= "text-align".":".$value.";";
                    			break;
                    		case 'font_size':
                    			$css .= "font-size".":".$value."px;";
                    			break;
                    		case 'letter_spacing':
                    			$css .= "letter-spacing".":".$value.";";
                    			break;
                    		case 'line_height':
                    			$css .= "line-height".":".$value."px;";
                    			break;
                    		case 'font_style':
                    			$css .= "font-style".":".$value.";";
                    			break;
                    		case 'text-color':
                    			$rgb=$this -> hex2rgb($value);
                    			$css .= "color".":". $rgb.";";
                    			break;
                    		
                    		default:
                    			$css .= $key.":".$value.";";
                    			break;
                    	}
                    }
                }
            }
        }
        return $css;
    }

    function hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
		    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
		    $r = hexdec(substr($hex,0,2));
		    $g = hexdec(substr($hex,2,2));
		    $b = hexdec(substr($hex,4,2));
		}
		$rgb = 'rgb('.$r.",". $g.",". $b.")";
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}
		



	//=========================================================================================
	//=====         This action is called in the admin_enqueue_scripts action            ======
	//=====               on the edit screen where your field is created.                ======
	//===== Use this action to add CSS + JavaScript to assist your render_field() action.======
	//=========================================================================================



	function input_admin_head() {
		
		$dir = plugin_dir_url( __FILE__ );

		// // register & include JS
		wp_register_script( 'acf-input-typography', "{$dir}js/input.js" );
		wp_enqueue_script('acf-input-typography');
		
		
		// register & include CSS  
		wp_register_style( 'acf-input-typography', "{$dir}css/input.css" ); 
		wp_enqueue_style('acf-input-typography');
		
		 wp_enqueue_media();
	}


	function input_admin_enqueue_scripts() {


	}
	
	
	//=========================================================================================
	//=====   This filter is used to perform validation on the value prior to saving.    ======
	//=====     All values are validated regardless of the field's required setting.     ======
	//=====              This allows you to validate and return messages                 ======
	//=====                  to the user if the value is not correct                     ======
	//=========================================================================================
	
	function validate_value( $valid, $value, $field, $input ){

	    if ($field['required']) {
	    
		    if (empty($value['font-family']) || empty($value['font-weight']) || empty($value['backupfont']) || empty($value['text_align'])
		    	 || empty($value['direction']) || empty($value['font_style']) || empty($value['font_size']) || empty($value['line_height'])
		    	 || empty($value['text-color'])) {
		    	$set = 0;
		    	$txt = __('The value is empty!! : ','acf-typography');
		    
		    	if( empty($value['font-family']) & $field['show_font_familys']){
		    		$txt .= __('font family, ','acf-typography');
		    		$set = 1;
		    	}
		    
		    	if( empty($value['font-weight']) & $field['show_font_weight']){
		    		$txt .= __('font weight, ','acf-typography');
		    		$set = 1;
		    	}
		   
	 	   		if( empty($value['backupfont']) & $field['show_backup_font']){
		    		$txt .= __('backupfont, ','acf-typography');
		    		$set = 1;
		    	}
		    
		    	if( empty($value['text_align']) & $field['show_text_align']){
		    		$txt .= __('text align, ','acf-typography');
		    		$set = 1;
		    	}
		    
		    	if( empty($value['direction']) & $field['show_text_direction']){
		    		$txt .= __('direction, ','acf-typography');
		    		$set = 1;
		    	}
		    
		    	if( empty($value['font_style']) & $field['show_font_style']){
		    		$txt .= __('font style, ','acf-typography');
		    		$set = 1;
		    	}
		    
		    	if( empty($value['font_size']) & $field['show_font_size']){
		    		$txt .= __('font size, ','acf-typography');
		    		$set = 1;
		    	}
		   
		    	if( empty($value['line_height']) & $field['show_line_height']){
		    		$txt .= __('line height, ','acf-typography');
		    		$set = 1;
		    	}

		    	if( empty($value['text-color']) & $field['show_color_picker']){
		    		$txt .= __('text color, ','acf-typography');
		    		$set = 1;
		    	}
		    	
		    	if ($set) {
		    		$valid = $txt;
		    	}
		    	
		    }
		}

	    return $valid;
	}
	
}


// create field
new acf_field_typography();
?>