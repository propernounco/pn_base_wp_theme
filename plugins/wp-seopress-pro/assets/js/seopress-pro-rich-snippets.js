//Schemas tabs
jQuery(document).ready(function($){
    if ($('#seopress-schemas-tabs').length) {
        $("#seopress-schemas-tabs .hidden").removeClass('hidden');
        $("#seopress-schemas-tabs").tabs();
    }

    var sc_a = '.wrap-rich-snippets-articles';
    var sc_b = '.wrap-rich-snippets-local-business';
    var sc_f = '.wrap-rich-snippets-faq';
    var sc_c = '.wrap-rich-snippets-courses';
    var sc_r = '.wrap-rich-snippets-recipes';
    var sc_j = '.wrap-rich-snippets-jobs';
    var sc_v = '.wrap-rich-snippets-videos';
    var sc_e = '.wrap-rich-snippets-events';
    var sc_p = '.wrap-rich-snippets-products';
    var sc_s = '.wrap-rich-snippets-services';
    var sc_re = '.wrap-rich-snippets-review';
    var sc_cu = '.wrap-rich-snippets-custom';
    var sc_ad = '.wrap-rich-snippets-type .advice';

    //Schemas post type
    $('#seopress-your-schema select.dyn').change(function(e) {
        e.preventDefault();

        var select = $(this).val();

        if (select == 'manual_global') {
            $(this).next('input.manual_global').show();
            $(this).closest('p').find('input.manual_global').show();
            $(this).closest('p').find('select.cf').hide();
            $(this).closest('p').find('select.tax').hide();
        } else if (select == 'manual_img_global') {
            $(this).next('input.manual_img_global').show();
            $(this).closest('p').find('input.manual_img_library_global').hide();
            $(this).closest('p').find('select.cf').hide();
            $(this).closest('p').find('select.tax').hide();
        } else if (select == 'manual_img_library_global') {
            $(this).next('input.manual_img_global').hide();
            $(this).closest('p').find('input.manual_img_library_global').show();
            $(this).closest('p').find('select.cf').hide();
            $(this).closest('p').find('select.tax').hide();
        } else if (select == 'manual_date_global') {
            $(this).next('input.manual_date_global').show();
            $(this).closest('p').find('select.cf').hide();
            $(this).closest('p').find('select.tax').hide();
        } else if (select == 'manual_time_global') {
            $(this).next('input.manual_time_global').show();
            $(this).closest('p').find('select.cf').hide();
            $(this).closest('p').find('select.tax').hide();
        } else if (select == 'manual_rating_global') {
            $(this).next('input.manual_rating_global').show();
            $(this).closest('p').find('select.cf').hide();
            $(this).closest('p').find('select.tax').hide();
        } else if (select == 'custom_fields') {
            $(this).closest('p').find('input').hide();
            $(this).closest('p').find('input.manual_img_global').hide();
            $(this).closest('p').find('input.manual_img_library_global').hide();
            $(this).closest('p').find('input.manual_date_global').hide();
            $(this).closest('p').find('input.manual_time_global').hide();
            $(this).closest('p').find('input.manual_rating_global').hide();
            $(this).closest('p').find('select.tax').hide();
            $(this).closest('p').find('select.cf').show();
        } else if (select == 'custom_taxonomy') {
            $(this).closest('p').find('input').hide();
            $(this).closest('p').find('input.manual_img_global').hide();
            $(this).closest('p').find('input.manual_img_library_global').hide();
            $(this).closest('p').find('input.manual_date_global').hide();
            $(this).closest('p').find('input.manual_time_global').hide();
            $(this).closest('p').find('input.manual_rating_global').hide();
            $(this).closest('p').find('select.cf').hide();
            $(this).closest('p').find('select.tax').show();
        } else if (select == 'manual_custom_global') {
            $(this).closest('p').find('textarea.manual_custom_global').show();
            $(this).closest('p').find('select.cf').hide();
        } else {
            $(this).closest('p').find('select.cf').hide();
            $(this).closest('p').find('select.tax').hide();
            $(this).closest('p').find('input').hide();
            $(this).closest('p').find('input').hide();
            $(this).closest('p').find('textarea').hide();
        }
    }).trigger('change');

    //Rich Snippets Select
	if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'none') {
        $(sc_ad).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'articles') {
        $(sc_ad).hide();
        $(sc_a).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'localbusiness') {
        $(sc_ad).hide();
        $(sc_b).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'faq') {
        $(sc_ad).hide();
        $(sc_f).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'courses') {
        $(sc_ad).hide();
        $(sc_c).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'recipes') {
        $(sc_ad).hide();
        $(sc_r).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'jobs') {
        $(sc_ad).hide();
        $(sc_j).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'videos') {
        $(sc_ad).hide();
        $(sc_v).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'events') {
        $(sc_ad).hide();
        $(sc_e).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'products') {
        $(sc_ad).hide();
        $(sc_p).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'services') {
        $(sc_ad).hide();
        $(sc_s).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'review') {
        $(sc_ad).hide();
        $(sc_re).show();
    } else if ($("#seopress_pro_rich_snippets_type option:selected").val() == 'custom') {
        $(sc_ad).hide();
        $(sc_cu).show();
    }
    
	$('#seopress_pro_rich_snippets_type').change(function() {
		var seopress_rs_type = $('#seopress_pro_rich_snippets_type').val();
	    if (seopress_rs_type == 'none') {
	    	$(sc_ad).show();
	    	$(sc_a+','+sc_b+','+sc_f+','+sc_c+','+sc_r+','+sc_j+','+sc_v+','+sc_e+','+sc_p+','+sc_s+','+sc_re+','+sc_cu).hide();
	    }
	    if (seopress_rs_type == 'articles') {
            $(sc_a).show();
	    	$(sc_ad+','+sc_b+','+sc_f+','+sc_c+','+sc_r+','+sc_j+','+sc_v+','+sc_e+','+sc_p+','+sc_s+','+sc_re+','+sc_cu).hide();
	    }	    
	    if (seopress_rs_type == 'localbusiness') {
            $(sc_b).show();
	    	$(sc_ad+','+sc_a+','+sc_f+','+sc_c+','+sc_r+','+sc_j+','+sc_v+','+sc_e+','+sc_p+','+sc_s+','+sc_re+','+sc_cu).hide();
	    }
	    if (seopress_rs_type == 'faq') {
            $(sc_f).show();
	    	$(sc_ad+','+sc_a+','+sc_b+','+sc_c+','+sc_r+','+sc_j+','+sc_v+','+sc_e+','+sc_p+','+sc_s+','+sc_re+','+sc_cu).hide();
	    }
	    if (seopress_rs_type == 'courses') {
            $(sc_c).show();
	    	$(sc_ad+','+sc_a+','+sc_b+','+sc_f+','+sc_r+','+sc_j+','+sc_v+','+sc_e+','+sc_p+','+sc_s+','+sc_re+','+sc_cu).hide();
	    }
	    if (seopress_rs_type == 'recipes') {
            $(sc_r).show();
	    	$(sc_ad+','+sc_a+','+sc_b+','+sc_f+','+sc_c+','+sc_j+','+sc_v+','+sc_e+','+sc_p+','+sc_s+','+sc_re+','+sc_cu).hide();
	    }
	    if (seopress_rs_type == 'jobs') {
            $(sc_j).show();
	    	$(sc_ad+','+sc_a+','+sc_b+','+sc_f+','+sc_c+','+sc_r+','+sc_v+','+sc_e+','+sc_p+','+sc_s+','+sc_re+','+sc_cu).hide();
	    }
	    if (seopress_rs_type == 'videos') {
            $(sc_v).show();
	    	$(sc_ad+','+sc_a+','+sc_b+','+sc_f+','+sc_c+','+sc_r+','+sc_j+','+sc_e+','+sc_p+','+sc_s+','+sc_re+','+sc_cu).hide();
	    }
	    if (seopress_rs_type == 'events') {
            $(sc_e).show();
	    	$(sc_ad+','+sc_a+','+sc_b+','+sc_f+','+sc_c+','+sc_r+','+sc_j+','+sc_v+','+sc_p+','+sc_s+','+sc_re+','+sc_cu).hide();
	    }
	    if (seopress_rs_type == 'products') {
            $(sc_p).show();
            $(sc_ad+','+sc_a+','+sc_b+','+sc_f+','+sc_c+','+sc_r+','+sc_j+','+sc_v+','+sc_e+','+sc_s+','+sc_re+','+sc_cu).hide();
        }
        if (seopress_rs_type == 'services') {
            $(sc_s).show();
	    	$(sc_ad+','+sc_a+','+sc_b+','+sc_f+','+sc_c+','+sc_r+','+sc_j+','+sc_v+','+sc_e+','+sc_p+','+sc_re+','+sc_cu).hide();
	    }
        if (seopress_rs_type == 'review') {
            $(sc_re).show();
	    	$(sc_ad+','+sc_a+','+sc_b+','+sc_f+','+sc_c+','+sc_r+','+sc_j+','+sc_v+','+sc_e+','+sc_p+','+sc_s+','+sc_cu).hide();
        }
        if (seopress_rs_type == 'custom') {
            $(sc_cu).show();
	    	$(sc_ad+','+sc_a+','+sc_b+','+sc_f+','+sc_c+','+sc_r+','+sc_j+','+sc_v+','+sc_e+','+sc_p+','+sc_s+','+sc_re).hide();
        }
	});

    //Rich Snippets Counters - Articles - Headline
	$("#seopress_rich_snippets_articles_counters").after("<div id=\"seopress_rich_snippets_articles_counters_val\">/ 110</div>");
    
    if ($("#seopress_rich_snippets_articles_counters").length != 0) {
        $("#seopress_rich_snippets_articles_counters").text($("#seopress_pro_rich_snippets_article_title").val().length);
    	if($('#seopress_pro_rich_snippets_article_title').val().length > 110){   
            $('#seopress_rich_snippets_articles_counters').css('color', 'red');
        }
        $("#seopress_pro_rich_snippets_article_title").keyup(function(event) {
        	$('#seopress_rich_snippets_articles_counters').css('color', 'inherit');
         	if($(this).val().length > 110){
                $('#seopress_rich_snippets_articles_counters').css('color', 'red');
            }
         	$("#seopress_rich_snippets_articles_counters").text($("#seopress_pro_rich_snippets_article_title").val().length);
         	if($(this).val().length > 0){
         		$(".snippet-title-custom").text(event.target.value);
                $(".snippet-title").css('display', 'none');
                $(".snippet-title-custom").css('display', 'block');
                $(".snippet-title-default").css('display', 'none');
         	} else if($(this).val().length == 0) {
         		$(".snippet-title-default").css('display', 'block');
                $(".snippet-title-custom").css('display', 'none');
                $(".snippet-title").css('display', 'none');
         	};
        });
    }

    //Rich Snippets Counters - Courses - Description
	$("#seopress_rich_snippets_courses_counters").after("<div id=\"seopress_rich_snippets_courses_counters_val\">/ 60</div>");
    
    if ($("#seopress_rich_snippets_courses_counters").length != 0) {
        $("#seopress_rich_snippets_courses_counters").text($("#seopress_pro_rich_snippets_courses_desc").val().length);
    	if($('#seopress_pro_rich_snippets_courses_desc').val().length > 60){   
            $('#seopress_rich_snippets_courses_counters').css('color', 'red');
        }
        $("#seopress_pro_rich_snippets_courses_desc").keyup(function(event) {
        	$('#seopress_rich_snippets_courses_counters').css('color', 'inherit');
         	if($(this).val().length > 60){
                $('#seopress_rich_snippets_courses_counters').css('color', 'red');
            }
         	$("#seopress_rich_snippets_courses_counters").text($("#seopress_pro_rich_snippets_courses_desc").val().length);
         	if($(this).val().length > 0){
         		$(".snippet-title-custom").text(event.target.value);
                $(".snippet-title").css('display', 'none');
                $(".snippet-title-custom").css('display', 'block');
                $(".snippet-title-default").css('display', 'none');
         	} else if($(this).val().length == 0) {
         		$(".snippet-title-default").css('display', 'block');
                $(".snippet-title-custom").css('display', 'none');
                $(".snippet-title").css('display', 'none');
         	};
        });
    }

    //Date picker
	$('.seopress-date-picker').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(input, inst) {
            $('#ui-datepicker-div').removeClass('ui-date-picker').addClass('seopress-ui-datepicker');
        }
    });
    
    //Employment Type
    $('#seopress-tag-employment-1, #seopress-tag-employment-2, #seopress-tag-employment-3, #seopress-tag-employment-4, #seopress-tag-employment-5, #seopress-tag-employment-6, #seopress-tag-employment-7, #seopress-tag-employment-8').click(function() {

        var e = $(this).closest('.seopress_pro_rich_snippets_jobs_employment_type_p').find('.seopress_pro_rich_snippets_jobs_employment_type');
        if(e.val().length == 0){
            e.val(jQuery(this).text());
        } else {
            str = e.val();
            str = str.replace(/,\s*$/, '');
            e.val(str+','+$(this).text());
        }
    });

    //FAQ
    var template = $('#wrap-faq .faq:last').clone();

    //accordion
    var stop = false;
    $("#wrap-faq .faq h3").click(function(event) {
        if (stop) {
            event.stopImmediatePropagation();
            event.preventDefault();
            stop = false;
        }
    });
    function seopress_call_faq_accordion() {
        $( "#wrap-faq .faq" ).accordion({
            collapsible: true,
            active: false,
            heightStyle:"panel",
        });
    }
    seopress_call_faq_accordion();

    //define counter
    var sectionsCount = $('#wrap-faq').attr('data-count');

    //add new section
    $('#add-faq').click(function() {

        //increment
        sectionsCount++;

        //loop through each input
        var section = template.clone().find(':input').each(function(){
            //Stock input id
            var input_id = this.id;
            
            //Stock input name
            var input_name = this.name;

            //set id to store the updated section number
            var newId = this.id.replace(/^(\w+)\[.*?\]/, '$1['+sectionsCount+']');

            //Update input name
            $(this).attr('name', input_name.replace(/^(\w+)\[.*?\]/, '$1['+sectionsCount+']'));
            
            //update for label
            $(this).prev().attr('for', input_id.replace(/^(\w+)\[.*?\]/, '$1['+sectionsCount+']'));
            $(this).prev().attr('id', input_name.replace(/^(\w+)\[.*?\]/, '$1['+sectionsCount+']'));
            

            //update id
            this.id = newId;

        }).end()

        //inject new section
        .appendTo('#wrap-faq');
        seopress_call_faq_accordion();
        $( "#wrap-faq .faq" ).accordion('destroy');
        seopress_call_faq_accordion();
        
        return false;
    });

    //remove section
    $('#wrap-faq').on('click', '.remove-faq', function() {
        //fade out section
        $(this).fadeOut(300, function(){
            $(this).parent().parent().parent().parent().remove();
            return false;
        });
        return false;
    });
});