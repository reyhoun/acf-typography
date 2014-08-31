(function($){
	

	function initialize_field( $el ) {
		
		//$el.doStuff();
		
	}
	
	
	if( typeof acf.add_action !== 'undefined' ) {
	

		
		acf.add_action('ready append', function( $el ){
			

//====================================================================================

			$('.js-select2').select2();

		
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//============ Run preview in first time ==================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			preview($('#attribute').val(),$('#value').val());

			$('#preview_font').css('font-size', $('#size').val() + 'px');

			$('#preview_font').css('line-height', $('#line').val()+ 'px');

			$('#preview_font').css('text-align', $('#align').val());




		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//=============== Initializing variables ==================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			var font_family_index = 0;
			var name_font;
			var arr = $.ajax({
			  url: 'http://localhost/wordpress/wp-content/plugins/acf-typography/gf.json',
			  dataType: 'json',
			  async: false,
			});

			var data_array = arr.responseJSON;

			var i_item = 0 ; 



		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//========= Font Family list by attribute ===============
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

   			$('#attribute').select2( {

    			   query: function (query) {

    			       var data = {results: []}, i;


					  		 for (i in  data_array["items"]) {
					  		 	
					  		 	var Big1 = data_array["items"][i]["family"].toLowerCase();
					  		 	var Big2 = query.term.toLowerCase();

					  		 	if(Big1.indexOf(Big2) > -1){

    			          			 data.results.push({id: data_array["items"][i]["family"], text: data_array["items"][i]["family"], data: i});
    			          		};
    			       		}



    			       // for (i in  data_array["items"]) {

    			       //     data.results.push({id: data_array["items"][i]["family"], text: data_array["items"][i]["family"], data: i});

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

   			$('#attribute').ready( function(e) {

       			$('#value').select2({

        			   query: function (query) {


        			   			for (i in  data_array["items"]) {
					
        			    		   if (data_array["items"][i]["family"] == $('#attribute').val()) {
			
        			    		   		var data = {results: []}, i;
			
        			       				for (e in  data_array["items"][i]["variants"]) {
					
        			       		 		  	 data.results.push({id: data_array["items"][i]["variants"][e] , text: data_array["items"][i]["variants"][e]});
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
   			$('#attribute').on('change', function(e) {

   					preview(data_array["items"][e.added['data']]["family"],data_array["items"][e.added['data']]["variants"][0]);
   			
   					font_family_index = e.added['data'];

    			   $('#value').select2({

     			      query: function (query) {

     			          var data = {results: []}, i;
	
     			          		for (i in  data_array["items"][e.added['data']]["variants"]) {

     			          		    data.results.push({id: data_array["items"][e.added['data']]["variants"][i] , text: data_array["items"][e.added['data']]["variants"][i]});

     			          		}

     			          query.callback(data);
     			          // name_font = data_array["items"][e.added['data']]["variants"][i];
		
     			      },

     			      initSelection : function (element, callback) {


      			      var data = {id: data_array["items"][e.added['data']]["variants"][0] , text: data_array["items"][e.added['data']]["variants"][0]};
      			      $('#value').val(data_array["items"][e.added['data']]["variants"][0]); 
      			      callback(data);
      			      // preview($('#attribute').val());
		
      				  }

      			 });

   			});

		
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================= Font style change =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			$('#value').on('change',function(e){

				preview(data_array["items"][font_family_index]["family"],e.added['id']);

			});



		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================== Font size change =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			$('#size').on('input',function(){

				$('#preview_font').css('font-size', $(this).val() + 'px');

			});


		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================== Font line change =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			$('#line').on('input',function(){

				$('#preview_font').css('line-height', $(this).val()+ 'px');

			});


		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================= Font align change =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			$('#align').on('change',function(){

				$('#preview_font').css('text-align', $(this).val());

			});



		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//================== Preview function =====================
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

       		 function preview(name , stl) {
        	
       		 	if ($('#preview_style').length) {
        	
        			var css = 	'@import url(http://fonts.googleapis.com/css?family=' + name.split(' ').join('+') + ':' + stl + '); #preview_font { font-family: ' + name + '; }';
        			$('#preview_style').html(css);
        		}

        	}



//====================================================================================



			// search $el for fields of type 'typography'
			acf.get_fields({ type : 'typography'}, $el).each(function(){
				
				initialize_field( $(this) );
				
			});
			
		});
		
		
	} else {
		
		
		$(document).live('acf/setup_fields', function(e, postbox){
			
			$(postbox).find('.field[data-field_type="typography"]').each(function(){
				
				initialize_field( $(this) );
				
			});
		
		});
	
	
	}


})(jQuery);
