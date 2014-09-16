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
		$valueset = array();
		foreach ( $fontArray as $k => $v ) {
			if (is_array($v))
			{
			    foreach ($v as $value)
			    {
			       foreach ($value as $key1 => $value1) {

			       		if($key1== 'family'){
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
			'font-family'		=> '',
			'font-weight'		=> '400',
            'backup-font'		=> 'Arial, Helvetica, sans-serif',
            'text_align'		=>	'left',
            'direction'			=> 'ltr',
			'font_size'			=> 20,
			'line_height'		=> 25,
			'font_style'		=> 'normal',
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
			'prepend'		=> 'px',
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
			'prepend'		=> 'px',
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
           
            if ($field['show_line_height']) {
            	$field['value']['line_height']	 =  $field['line_height'];
            } else {
            	$field['value']['line_height']	 =	'150%';
            }
            
            $field['value']['direction']	 =	$field['direction'];
            $field['value']['font_style']	 =	$field['font_style'];

        }

        $field_value = $field['value'];

		echo "<style id='". $field['key'] . "preview_style' ></style>";

		$style = array( 'NORMAL 400', 'SMALL 200', 'BOLD 800');
		$text_align =  array('inherit', 'left', 'right', 'center', 'justify', 'inital');
		$text_direction = array( 'ltr' => 'left to right',
								 'rtl' => 'right to left');

		$font_style = array(
			 		'normal'	=> 'normal',
			 		'italic'	=> 'italic');
		$s = 0;
		$e = '';

		$defaults_fonts = $field['backupfont'];







	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//============================== CSS style ==================================
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		echo '
		<style>
			.field_type-typography .select2-container {
				width: 40%;
				margin-left: 45px;
				margin-right: 11px;

			}
			#' . $field['key'] . 'preview_font {
				font-size: 20px;
				text-align: center;
				padding: 20px;
			}			
		</style>
		';



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//========================== show render field ==============================
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		// echo $field['key'];

		echo "<div>";

			if ($field['show_font_familys']) 
				echo '<div class = "select2-container"> Font Family</div> ';

			if ($field['show_font_weight'] & $field['show_font_familys'])
				echo  '<div class = "select2-container"> Font Weight & Style </div>';
			echo "<div>";

				// Font Family selector
				if ($field['show_font_familys']) {

					echo '<input name="' . $field['name'] . '[font-family]" id="' . $field['key'] . 'attribute" class = "select2-container" value="' . $field_value['font-family'] . '" />';
				}
				


				// Font Weight & Style selector
				if ($field['show_font_weight'] & $field['show_font_familys']) {
				 	echo '<input name="' . $field['name'] . '[font-weight]" id="' . $field['key'] . '" value="' . $field_value['font-weight'] . '" class = "select2-container" type="hidden" style="width:300px"/>';
				 }

			echo "</div>";



			if ($field['show_backup_font'])
				echo '<div class = "select2-container"> Backup Font Family </div>';

			if ($field['show_text_align'])
				echo '<div class = "select2-container"> Text Align </div>';
			echo "<div>";

				//Backup Font Family
				if ($field['show_backup_font']) {
					echo '<select name="' . $field['name'] . '[backupfont]" class = "'. $field['key'] .'js-select2">';
						foreach ( $defaults_fonts as $k => $v ) {
							echo '<option value="' . $k . '"' . selected($field_value['backupfont'], $k, false) . ' >' . $k . '</option>' ;
						}
					echo '</select>';
				}


				// "Text Align";
				if ($field['show_text_align']) {
					echo '<select name="' . $field['name'] . '[text_align]" id="' . $field['key'] . 'align" class = "'. $field['key'] .'js-select2">';
						foreach ( $text_align as $k ) {
							echo '<option value="' . $k . '"' . selected($field_value['text_align'], $k, false) . ' >' . $k . '</option>' ;
						}
					echo '</select>';
				}


			echo "</div>";



			if ($field['show_text_direction'])
				echo "<div class = 'select2-container'>direction </div>";

				echo "<div class = 'select2-container'> ";

				if ($field['show_font_size'])
						echo "<div>Font Size</div>";
				if ($field['show_line_height'])	
						echo "<div> Line Height</div>";

					 echo "</div>";
			

			// "Text direction";
				if ($field['show_text_direction']) {
					echo '<select name="' . $field['name'] . '[direction]" class = "'. $field['key'] .'js-select2">';
						foreach ( $text_direction as $k => $v) {
							echo '<option value="' . $k . '"' . selected($field_value['direction'], $k, false) . ' >' . $v . '</option>' ;
						}
					echo '</select>';
				}

			

			echo "<div class = 'select2-container'>";

				if ($field['show_font_size']) {
					echo '<input type="number"  min="1"  name="' . $field['name'] . '[font_size]" type="text" id="' . $field['key'] . 'size" value="' . $field_value['font_size'] . '" >';
				}
				if ($field['show_line_height']) {
					//echo 'Line Height';
					echo '<input type="number"  min="1"  name="' . $field['name'] . '[line_height]" type="text" id="' . $field['key'] . 'line" class = ""  value="' . $field_value['line_height'] . '" >' ;
				}


			echo "</div>";


			if ($field['show_font_style'])
				echo '<div class = "select2-container"> Font Style </div>';
			echo "<div>";
			// "Font Style";
					if ($field['show_font_style']) {
						echo '<select name="' . $field['name'] . '[font_style]" class = "'. $field['key'] .'js-select2">';
							foreach ( $font_style as $k => $v) {
								echo '<option value="' . $k . '"' . selected($field_value['font_style'], $k, false) . ' >' . $v . '</option>' ;
							}
						echo '</select>';
					}
			echo "</div>";

		echo "</div>";


		if ($field['show_preview_text'] & $field['show_font_familys']) {
			echo '  
	    	   		<label>Preview Text:</label>
        				<div id="' . $field['key'] . 'preview_font">Reyhoun is Awesome :) <br /> 1 2 3 4 5 6 7 8 9 0 A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z</div>
  				 ';
  		}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//============================= javascript ==================================
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  		echo "
			<script>
				(function($){


			$('.". $field['key'] ."js-select2').select2();


		
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//============ Run preview in first time ==================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			preview($('#" . $field['key'] . "attribute').val(),$('#" . $field['key'] . "').val());

			$('#". $field['key'] . "preview_font').css('font-size', $('#" . $field['key'] . "size').val() + 'px');

			$('#". $field['key'] . "preview_font').css('line-height', $('#" . $field['key'] . "line').val()+ 'px');

			$('#". $field['key'] . "preview_font').css('text-align', $('#" . $field['key'] . "align').val());




		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//=============== Initializing variables ==================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			var font_family_index = 0;
			var name_font;
			var arr = $.ajax({
			  url: '../wp-content/plugins/acf-typography/gf.json',
			  dataType: 'json',
			  async: false,
			});

			var data_array = arr.responseJSON;

			var i_item = 0 ; 



		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//========= Font Family list by attribute ===============
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

   			$('#" . $field['key'] . "attribute').select2( {

    			   query: function (query) {

    			       var data = {results: []}, i;


					  		 for (i in  data_array['items']) {
					  		 	
					  		 	var Big1 = data_array['items'][i]['family'].toLowerCase();
					  		 	var Big2 = query.term.toLowerCase();

					  		 	if(Big1.indexOf(Big2) > -1){

    			          			 data.results.push({id: data_array['items'][i]['family'], text: data_array['items'][i]['family'], data: i});
    			          		};
    			       		}



    			       // for (i in  data_array['items']) {

    			       //     data.results.push({id: data_array['items'][i]['family'], text: data_array['items'][i]['family'], data: i});

    			       // }
    			       query.callback(data);
    			   },

    			   initSelection : function (element, callback) {

    			   		var elementText = $(element).val();

    			        var data = {id: elementText, text: elementText};
    			        callback(data);
    			    }

   			});


		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//=============== First loade Font Weight =================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

   			$('#" . $field['key'] . "attribute').ready( function(e) {

       			$('#" . $field['key'] . "').select2({

        			   query: function (query) {


        			   			for (i in  data_array['items']) {
					
        			    		   if (data_array['items'][i]['family'] == $('#" . $field['key'] . "attribute').val()) {
			
        			    		   		var data = {results: []}, i;
			
        			       				for (e in  data_array['items'][i]['variants']) {
					
        			       		 		  	 if (data_array['items'][i]['variants'][e] == 'regular') {

        			       						data.results.push({id: '400' , text: '400'});
        			       					} 
        			       					else{
        			       						data.results.push({id: data_array['items'][i]['variants'][e] , text: data_array['items'][i]['variants'][e]});
        			       					};
        			       				}
        			       				// console.log(i);
        			       				font_family_index = i;
        			    		   };
        			   			}
			
        			       query.callback(data);

        			   },

        			   // results: function (data, page) {
        				    //Used to determine whether or not there are more results available,
        				    //and if requests for more data should be sent in the infinite scrolling
        				    
        				    // return { results: data.Results, more: more };
        				// }


        			   initSelection : function (element, callback) {

        			    	var elementText = $(element).val();
        			    	var data = {id: elementText, text: elementText};
        			    	callback(data);
        				}
       			});
   			});



		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//=========== Loade Font Weight by attribute ==============
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

   			// var font_family_index = 0;
   			$('#" . $field['key'] . "attribute').on('change', function(e) {

   					preview(data_array['items'][e.added['data']]['family'],data_array['items'][e.added['data']]['variants'][0]);
   			
   					font_family_index = e.added['data'];

    			   $('#" . $field['key'] . "').select2({

     			      query: function (query) {

     			          var data = {results: []}, i;
	
     			          		for (i in  data_array['items'][e.added['data']]['variants']) {

     			          		    if (data_array['items'][e.added['data']]['variants'][i] == 'regular') {

        			       						data.results.push({id: '400' , text: '400'});
        			       					} 
        			       					else{
        			       						data.results.push({id: data_array['items'][e.added['data']]['variants'][i] , text: data_array['items'][e.added['data']]['variants'][i]});
        			       					};

     			          		}

     			          query.callback(data);
     			          // name_font = data_array['items'][e.added['data']]['variants'][i];
		
     			      },

     			      initSelection : function (element, callback) {


      			      var data = {id: data_array['items'][e.added['data']]['variants'][0] , text: data_array['items'][e.added['data']]['variants'][0]};
      			      $('#" . $field['key'] . "').val(data_array['items'][e.added['data']]['variants'][0]); 
      			      callback(data);
      			      // preview($('#" . $field['key'] . "attribute').val());
		
      				  }

      			 });

   			});

		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================= Font style change =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			$('#" . $field['key'] . "').on('change',function(e){

				preview(data_array['items'][font_family_index]['family'],e.added['id']);

			});



		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================== Font size change =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			$('#" . $field['key'] . "size').on('input',function(){

				$('#". $field['key'] . "preview_font').css('font-size', $(this).val() + 'px');

			});


		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================== Font line change =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			$('#" . $field['key'] . "line').on('input',function(){

				$('#". $field['key'] . "preview_font').css('line-height', $(this).val()+ 'px');

			});


		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================= Font align change =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			$('#" . $field['key'] . "align').on('change',function(){

				$('#". $field['key'] . "preview_font').css('text-align', $(this).val());

			});



		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================== Preview function =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

       		 function preview(name , stl) {
        	
       		 	if ($('#". $field['key'] . "preview_style').length) {
        	
        			var css = 	'@import url(http://fonts.googleapis.com/css?family=' + name.split(' ').join('+') + ':' + stl + '); #". $field['key'] . "preview_font { font-family: ' + name + '; }';
        			$('#". $field['key'] . "preview_style').html(css);
        		}

        	}




				})(jQuery);
			</script> ";




	}
		



	//=========================================================================================
	//=====         This action is called in the admin_enqueue_scripts action            ======
	//=====               on the edit screen where your field is created.                ======
	//===== Use this action to add CSS + JavaScript to assist your render_field() action.======
	//=========================================================================================



	function input_admin_enqueue_scripts() {
		
		$dir = plugin_dir_url( __FILE__ );

		// // register & include JS
		// wp_register_script( 'acf-input-typography', "{$dir}js/input.js" );
		// wp_enqueue_script('acf-input-typography');
		
		
		// // register & include CSS  
		// wp_register_style( 'acf-input-typography', "{$dir}css/input.css" ); 
		// wp_enqueue_style('acf-input-typography');
		
	}
	
}


// create field
new acf_field_typography();
?>