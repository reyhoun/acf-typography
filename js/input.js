(function($){
	$(".rey-color").wpColorPicker();
	$(".js-select2").select2();

	/*
	 * Initializing variables
	 */
	var font_family_index = 0;
	var arr = $.ajax({
	  url: phpVar.dir + "/gf.json",
	  dataType: "json",
	  async: false,
	});

	var data_array = arr.responseJSON;

	/*
	 * Font Family list by attribute
	 */
	$(".font-familys").each(function(){
	    $(this).select2( {
		   query: function (query) {
		       var data = {results: []}, i;
			  		 for (i in  data_array.items) {
			  		 	var Big1 = data_array.items[i].family.toLowerCase();
			  		 	var Big2 = query.term.toLowerCase();

			  		 	if(Big1.indexOf(Big2) > -1){

		          			 data.results.push({id: data_array.items[i].family, text: data_array.items[i].family, data: i});
		          		}
		       		}
		       query.callback(data);
		   },
		   initSelection : function (element, callback) {
		   		var elementText = $(element).val();

		        var data = {id: elementText, text: elementText};
		        callback(data);
		    }
		});
	});

	/*
	 * First loade Font Weight
	 */	
	$(".select2-weight").each(function(){
		var name_font = "";
		name_font = $(this).closest(":has(.clearfix .acf-typography-font-familys .font-familys)").find(".font-familys.select2-offscreen").val();
		var list = [];

		for (i in  data_array.items) {
			if (data_array.items[i].family == name_font) {
				for (e in  data_array.items[i].variants) {
				    if (data_array.items[i].variants[e] == "regular") {
			       		list.push({id: "400" , text: "400"});
				    } else {
				       	list.push({id: data_array.items[i].variants[e] , text: data_array.items[i].variants[e]});
				    }
				}
			}
		}

		$(this).select2({
		  	data: list,
			placeholder: '400', 
		});

		$(this).select2('data', {id: $(this).val(), text: $(this).val()});
	});

	/*
	 * Loade Font Weight by attribute.
	 */
	$(".font-familys.select2-offscreen").each(function(){
	    $(this).on("change", function(e) {
			preview(data_array.items[e.added.data].family,"400",$(this));		
			font_family_index = e.added.data;

		    $(this).closest(":has(.clearfix .acf-typography-font-weight .font-weight)").find(".font-weight").select2({
		        query: function (query) {
		            var data = {results: []}, i;
	          		for (i in  data_array.items[e.added.data].variants) {
	          		    if (data_array.items[e.added.data].variants[i] == "regular") {
       						data.results.push({id: "400" , text: "400"});
       					} else{
       						data.results.push({id: data_array.items[e.added.data].variants[i] , text: data_array.items[e.added.data].variants[i]});
       					}
	          		}

		            query.callback(data);
		        },

		        initSelection : function (element, callback) {
			        //-----------------------------------------------------------------------
			        // if (data_array.items[e.added.data].variants[0] == "regular")
			        //	var data = {id: "400" , text: "400"};
				    // else
				    // 	var data = {id: data_array.items[e.added.data].variants[0] , text: data_array.items[e.added.data].variants[0]};
			        // $(this).closest(":has(.clearfix .acf-typography-font-weight .font-weight)").find(".font-weight").val(data_array.items[e.added.data].variants[0]);
			        //-----------------------------------------------------------------------

			        var data = {id: "400" , text: "400"};
			        $(this).closest(":has(.clearfix .acf-typography-font-weight .font-weight)").find(".font-weight").val("400");

			        callback(data);			      		
			    }
		    });
		});
	});

	/*
	* Font style change.
	*/
	$(".font-weight").each(function(){
		$(this).on("change",function(e){
			preview($(this).closest(":has(.clearfix .acf-typography-font-familys .font-familys)").find(".font-familys.select2-offscreen").val(),e.added.id,$(this));
		});
	});

	/*
	 * Font size change.
	 */
	$(".sizeF").each(function(){
        $(this).on("input",function(){
        	$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").css("font-size", $(this).val() + "px");

        	var name = $(this).closest(":has(.clearfix .acf-typography-font-familys .font-familys)").find(".font-familys.select2-offscreen").val();
			var stl = $(this).closest(":has(.clearfix .acf-typography-font-weight .font-weight)").find(".font-weight.select2-offscreen").val();
			var css = $(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").attr('style');
			$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find("iframe").attr( "src", phpVar.dir + "preview.php?css="+css+"&font="+name+"&wi="+stl);
		});
	});

	/*
	 * Font line change.
	 */
	$(".lineF").each(function(){
        $(this).on("input",function(){
			$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").css("line-height", $(this).val()+ "px");

			var name = $(this).closest(":has(.clearfix .acf-typography-font-familys .font-familys)").find(".font-familys.select2-offscreen").val();
			var stl = $(this).closest(":has(.clearfix .acf-typography-font-weight .font-weight)").find(".font-weight.select2-offscreen").val();
			var css = $(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").attr('style');
			$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find("iframe").attr( "src", phpVar.dir + "preview.php?css="+css+"&font="+name+"&wi="+stl);
		});
	});

	/*
	 * Letter Spacing change.
	 */
	$(".letter-spacing").each(function(){
        $(this).on("input",function(){

			$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".ss").css("letter-spacing", $(this).val()+ "px");

			var name = $(this).closest(":has(.clearfix .acf-typography-font-familys .font-familys)").find(".font-familys.select2-offscreen").val();
			var stl = $(this).closest(":has(.clearfix .acf-typography-font-weight .font-weight)").find(".font-weight.select2-offscreen").val();
			var css = $(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").attr('style');
			$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find("iframe").attr( "src", phpVar.dir + "preview.php?css="+css+"&font="+name+"&wi="+stl);
		});
	});

	/*
	 * Font Style change.
	 */
	$(".font-style").each(function(){
        $(this).on("change",function(){

			$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").css("font-style", $(this).val());

			var name = $(this).closest(":has(.clearfix .acf-typography-font-familys .font-familys)").find(".font-familys.select2-offscreen").val();
			var stl = $(this).closest(":has(.clearfix .acf-typography-font-weight .font-weight)").find(".font-weight.select2-offscreen").val();
			var css = $(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").attr('style');
			$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find("iframe").attr( "src", phpVar.dir + "preview.php?css="+css+"&font="+name+"&wi="+stl);
		});
	});

	/*
	 * Font align change.
	 */
	$(".alignF").each(function(){
        $(this).on("change",function(){

			$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").css("text-align", $(this).val());

			var name = $(this).closest(":has(.clearfix .acf-typography-font-familys .font-familys)").find(".font-familys.select2-offscreen").val();
			var stl = $(this).closest(":has(.clearfix .acf-typography-font-weight .font-weight)").find(".font-weight.select2-offscreen").val();
			var css = $(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").attr('style');
			$(this).closest(":has(.rey_main .acf-typography-preview .preview_font)").find("iframe").attr( "src", phpVar.dir + "preview.php?css="+css+"&font="+name+"&wi="+stl);
		});
	});
	
	/*
	 * Preview function.
	 */
		 function preview(name , stl, thisF) {
		 	if (thisF.closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").length) {
			thisF.closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").css("font-family", name);
			
			var css = thisF.closest(":has(.rey_main .acf-typography-preview .preview_font)").find(".preview_font").attr('style');
			thisF.closest(":has(.rey_main .acf-typography-preview .preview_font)").find("iframe").attr( "src", phpVar.dir + "preview.php?css="+css+"&font="+name+"&wi="+stl);
		}
	}
})(jQuery);