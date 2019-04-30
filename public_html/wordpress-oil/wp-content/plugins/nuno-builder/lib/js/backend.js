jQuery(document).ready(function ($) {

	$(document).on('loaded',function(e){


		if($('.icon_remove_button').length){
			$('.icon_remove_button').each(function(){

				$(this).click(function(e){

					var field = $(this).closest('.icon-pickerlist'),prev = field.find('.icon-selection-preview i'),input = field.find('.param_value');
					input.val('');
					prev.removeClass();
				})
			});


		}

		if($('.carousel-preview').length){

	    	var carouselPreview=$('.carousel-preview');

	   		$('input[name=pagination_size]').on('change',function(){
	   			$('.owl-page span',carouselPreview).css({'width':$(this).val()+'px','height':$(this).val()+'px'});
	   		}).trigger('change');

	   		$('[name=pagination_color]').wpColorPicker({
		        change:function(event,ui){
					$('.owl-page span',carouselPreview).css({'background-color':ui.color.toString()});
		        }
	    	}).on('change',function(){
	    		$('.owl-page span',carouselPreview).css({'background-color':$(this).val()});
	    	}).trigger('change');

	    	$('select[name=pagination_type]').live('change',function(){
	    		if($(this).val()=='bullet'){
	    			carouselPreview.closest('.field-wrap').show();
	    		}
	    		else{
	    			carouselPreview.closest('.field-wrap').hide();
	    		}
	    	}).trigger('change');

		 }


    	if($('[name=icon_size]').length){
    		var icon_size=$('[name=icon_size]');
    		var icon_prev=$('.icon-pickerlist .icon-selection-preview i');

    		if(icon_prev.length){
	    		icon_size.on('change',function(){
	    			icon_prev.css('font-size',$(this).val()+'px');
	    		})
	    		.trigger('change');
    		}


    	}

    	if($('[name=pagination]').length){

    		var paginationSelect=$('[name=pagination]');
    		var pagination_type=$('[name=pagination_type]');
    		var pagination_image=$('[name=pagination_image]');

    		paginationSelect.on('change',function(){
    			if($(this).val()==1){
    				if(pagination_type.val()=='image'){
	   					pagination_image.closest('.field-wrap').show();
    				}
    				else{
	   					pagination_image.closest('.field-wrap').hide();
    				}
    			}
    			else{
   					pagination_image.closest('.field-wrap').hide();
    			}
    		}).trigger('change');
    	}
	});

});
