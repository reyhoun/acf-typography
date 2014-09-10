<?php
class acf_field_typography extends acf_field {
	
	
	//=========================================================================================
	//=================== This function will setup the field type data ========================
	//=========================================================================================


	function __construct() {

		$YOUR_API_KEY = null ;
		
		$this->name = 'typography';
		$this->label = __('Typography', 'acf-typography');
		$this->category = 'Choice';
		
		


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//======================== get json for extra seting ========================
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		// update json
		function json_update() {

			$filename = '../wp-content/plugins/acf-typography/gf.json';

			$lastdate = date ("Ymd", filemtime($filename));
			$now = date ("Ymd", time());
			$time = $now - $lastdate;

			if ($time == 3) {

				$json = file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=' . $YOUR_API_KEY);

				$files = "../wp-content/plugins/acf-typography/gf.json";  
				$myfile = fopen($files, 'wb');
				fwrite($myfile, $json);
				fclose($myfile);

			}
		}


		// if $YOUR_API_KEY exist;
		if ($YOUR_API_KEY) {
			json_update();
		}


		//load json file for extra seting
		$dir = plugin_dir_url( __FILE__ );
		$json = file_get_contents("{$dir}gf.json");
		$fontArray = json_decode( $json);
		
		$font_familys = array();
		foreach ( $fontArray as $k => $v ) {
			if (is_array($v))
			{
			    foreach ($v as $value)
			    {
			       foreach ($value as $key1 => $value1) {
			       	if($key1== 'family')
			        	array_push($font_familys, $value1); 
			       }
			    }
			}
		}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//======     defaults (array) Array of default settings which are       =====
	//====== merged into the field object. These are used later in settings =====
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


		$this->defaults = array(
			'font_size'		=> 20,
			'line_height'	=> 25,
			'default_value'	=> '',
			'new_lines'		=> '',
			'maxlength'		=> '',
			'placeholder'	=> '',
			'readonly'		=> 0,
			'disabled'		=> 0,
			'rows'			=> '',
			'line_height'	=> 25,
			'font_familys'	=> $font_familys,
			'stylefont'	 	=> array( '300','400', '600','700','800'),
			'backupfont'	=> array(
            	"Arial, Helvetica, sans-serif"                          => "Arial, Helvetica, sans-serif",
            	"'Arial Black', Gadget, sans-serif"                     => "'Arial Black', Gadget, sans-serif",
            	"'Bookman Old Style', serif"                            => "'Bookman Old Style', serif",
            	"'Comic Sans MS', cursive"                              => "'Comic Sans MS', cursive",
            	"Courier, monospace"                                    => "Courier, monospace",
            	"Garamond, serif"                                       => "Garamond, serif",
            	"Georgia, serif"                                        => "Georgia, serif",
            	"Impact, Charcoal, sans-serif"                          => "Impact, Charcoal, sans-serif",
            	"'Lucida Console', Monaco, monospace"                   => "'Lucida Console', Monaco, monospace",
            	"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"    => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
            	"'MS Sans Serif', Geneva, sans-serif"                   => "'MS Sans Serif', Geneva, sans-serif",
            	"'MS Serif', 'New York', sans-serif"                    => "'MS Serif', 'New York', sans-serif",
            	"'Palatino Linotype', 'Book Antiqua', Palatino, serif"  => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
            	"Tahoma,Geneva, sans-serif"                             => "Tahoma, Geneva, sans-serif",
            	"'Times New Roman', Times,serif"                        => "'Times New Roman', Times, serif",
            	"'Trebuchet MS', Helvetica, sans-serif"                 => "'Trebuchet MS', Helvetica, sans-serif",
            	"Verdana, Geneva, sans-serif"                           => "Verdana, Geneva, sans-serif",
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
			'label'			=> __('Font Family ?','acf-typography'),
			'type'			=> 'radio',
			'layout'		=> 'horizontal',
			'name'			=> 'font_familys_?',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Font Family','acf-typography'),
			'type'			=> 'select',
			'name'			=> 'default_font_familys',
			'choices'		=>	$field['font_familys']
		));




		acf_render_field_setting( $field, array(
			'label'			=> __('Style Font ?','acf-typography'),
			'type'			=> 'radio',
			'layout'		=>  'horizontal',
			'name'			=> 'stylefont_?',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Style Font','acf-typography'),
			'type'			=> 'select',
			'name'			=> 'default_stylefont',
			'choices'		=>	$field['stylefont']
		));



		acf_render_field_setting( $field, array(
			'label'			=> __('Backup Font ?','acf-typography'),
			'type'			=> 'radio',
			'layout'		=>  'horizontal',
			'name'			=> 'backupfont_?',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));


		acf_render_field_setting( $field, array(
			'label'			=> __('Backup Font','acf-typography'),
			'type'			=> 'select',
			'name'			=> 'default_backupfont',
			'choices'		=>	$field['backupfont']
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Text Align ?','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'text_align_?',
			'choices'		=>	array(
									1	=>	__('Yes','acf-font-awesome'),
									0	=>	__('No','acf-font-awesome')
								)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Text Align','acf-typography'),
			'type'			=> 'select',
			'name'			=> 'default_text_align',
			'choices'		=>	array('inherit', 'left', 'right', 'center', 'justify', 'inital')
		));


		acf_render_field_setting( $field, array(
			'label'			=> __('Text direction ?','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'text_direction_?',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Text direction','acf-typography'),
			'type'			=> 'select',
			'name'			=> 'default_text_align',
			'choices'		=>	array( 'rtl' => 'right to left',
								   'ltr' => 'left to right',)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Font Size ?','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'font_size_?',
			'choices'		=>	array(
								1	=>	__('Yes','acf-font-awesome'),
								0	=>	__('No','acf-font-awesome')
							)
		));


		acf_render_field_setting( $field, array(
			'label'			=> __('Font Size','acf-typography'),
			'type'			=> 'number',
			'name'			=> 'font_size',
			'prepend'		=> 'px',
		));



		acf_render_field_setting( $field, array(
			'label'			=> __('Line Height ?','acf-typography'),
			'type'			=> 'radio',
			'layout'  		=>  'horizontal',
			'name'			=> 'line_height_?',
			'choices'		=>	array(
									1	=>	__('Yes','acf-font-awesome'),
									0	=>	__('No','acf-font-awesome')
								)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Line Height','acf-typography'),
			'type'			=> 'number',
			'name'			=> 'line_height',
			'prepend'		=> 'px',
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
            $field['value']['font-family']	 = 	'';
            $field['value']['font-weight']	 = 	'';
            $field['value']['backupfont']	 = 	'Tahoma,Geneva, sans-serif';
            $field['value']['text_align']	 =	'left';
            $field['value']['font_size']	 =	'20';
            $field['value']['line_height']	 =	'25';
            $field['value']['direction']	 =	'ltr';
        }

        $field_value = $field['value'];

		echo "<style id='preview_style' ></style>";

		$style = array( 'NORMAL 400', 'SMALL 200', 'BOLD 800');
		$text_align =  array('inherit', 'left', 'right', 'center', 'justify', 'inital');
		$text_direction = array( 'ltr' => 'left to right',
								 'rtl' => 'right to left');
		$s = 0;
		$e = '';

		$defaults_fonts = $field['backupfont'];




	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//========================== show render field ==============================
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


		echo "<div>";

			echo '<div class = "select2-container"> Font Family</div>  <div class = "select2-container"> Font Weight & Style </div>';
			echo "<div>";

				// Font Family selector
				echo '<input name="' . $field['name'] . '[font-family]" id="attribute" class = "select2-container" value="' . $field_value['font-family'] . '" />';


				// Font Weight & Style selector
				 echo '<input name="' . $field['name'] . '[font-weight]" id="value" value="' . $field_value['font-weight'] . '" class = "select2-container" type="hidden" style="width:300px"/>';

			echo "</div>";




			echo '<div class = "select2-container"> Backup Font Family </div>  <div class = "select2-container"> Text Align </div>';
			echo "<div>";

				//Backup Font Family
				echo '<select name="' . $field['name'] . '[backupfont]" class = "js-select2">';
					foreach ( $defaults_fonts as $k => $v ) {
						echo '<option value="' . $k . '"' . selected($field_value['backupfont'], $k, false) . ' >' . $k . '</option>' ;
					}
				echo '</select>';


				// "Text Align";
				echo '<select name="' . $field['name'] . '[text_align]" id="align" class = "js-select2">';
					foreach ( $text_align as $k ) {
						echo '<option value="' . $k . '"' . selected($field_value['text_align'], $k, false) . ' >' . $k . '</option>' ;
					}
				echo '</select>';

			echo "</div>";




			echo "<div class = 'select2-container'>direction </div>  <div class = 'select2-container'> Font Size - Line Height </div>";
			

			// "Text direction";
				echo '<select name="' . $field['name'] . '[direction]" class = "js-select2">';
					foreach ( $text_direction as $k => $v) {
						echo '<option value="' . $k . '"' . selected($field_value['direction'], $k, false) . ' >' . $v . '</option>' ;
					}
				echo '</select>';

			

			echo "<div class = 'select2-container'>";

			//echo 'Font Size';
				echo '<input type="number"  min="1"  name="' . $field['name'] . '[font_size]" type="text" id="size" value="' . $field_value['font_size'] . '" >';
				//echo 'Line Height';
				echo '<input type="number"  min="1"  name="' . $field['name'] . '[line_height]" type="text" id="line" class = ""  value="' . $field_value['line_height'] . '" >' ;
			echo "</div>";


		echo "</div>";


		echo '  
	       		<label>Preview Text:</label>
        			<div id="preview_font">Reyhoun is Awesome :) <br /> 1 2 3 4 5 6 7 8 9 0 A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z</div>
  				</div>';
	}
		



	//=========================================================================================
	//=====         This action is called in the admin_enqueue_scripts action            ======
	//=====               on the edit screen where your field is created.                ======
	//===== Use this action to add CSS + JavaScript to assist your render_field() action.======
	//=========================================================================================



	function input_admin_enqueue_scripts() {
		
		$dir = plugin_dir_url( __FILE__ );

		// register & include JS
		wp_register_script( 'acf-input-typography', "{$dir}js/input.js" );
		wp_enqueue_script('acf-input-typography');
		
		
		// register & include CSS  
		wp_register_style( 'acf-input-typography', "{$dir}css/input.css" ); 
		wp_enqueue_style('acf-input-typography');
		
	}
	
}


// create field
new acf_field_typography();
?>