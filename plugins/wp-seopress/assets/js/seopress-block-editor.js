//Retrieve title / meta-desc from source code
jQuery(document).ready(function($) {



const { subscribe, select } = wp.data;
let hasSaved = false;

    subscribe( () => {
        var isSavingPost = wp.data.select('core/editor').isSavingPost();
        var isAutosavingPost = wp.data.select('core/editor').isAutosavingPost();
      
        if (isSavingPost && !isAutosavingPost && !hasSaved) {
        
            $.ajax({
                method : 'GET',
                url : seopressAjaxRealPreview.seopress_real_preview,
                data: {
                    action: 'seopress_do_real_preview',
                    post_id: $('#seopress-tabs').attr('data_id'),
                    tax_name: $('#seopress-tabs').attr('data_tax'),
                    origin: $('#seopress-tabs').attr('data_origin'),
                    post_type: $('#seopress_launch_analysis').attr('data_post_type'),
                    seopress_analysis_target_kw: $('#seopress_analysis_target_kw_meta').val(),
                    _ajax_nonce: seopressAjaxRealPreview.seopress_nonce,
                },
                beforeSend: function() {
                    $(".analysis-score p span").fadeIn().text(seopressAjaxRealPreview.i18n.progress),
                    $(".analysis-score p").addClass('loading')
                },
                success : function( s ) {
                    typeof s.data.og_title ==="undefined" ? og_title = "" : og_title = s.data.og_title.values;
                    typeof s.data.og_desc ==="undefined" ? og_desc = "" : og_desc = s.data.og_desc.values;
                    typeof s.data.og_img ==="undefined" ? og_img = "" : og_img = s.data.og_img.values;
                    typeof s.data.og_url ==="undefined" ? og_url = "" : og_url = s.data.og_url.host;
                    typeof s.data.og_site_name ==="undefined" ? og_site_name = "" : og_site_name = s.data.og_site_name.values;
                    typeof s.data.tw_title ==="undefined" ? tw_title = "" : tw_title = s.data.tw_title.values;
                    typeof s.data.tw_desc ==="undefined" ? tw_desc = "" : tw_desc = s.data.tw_desc.values;
                    typeof s.data.tw_img ==="undefined" ? tw_img = "" : tw_img = s.data.tw_img.values;
    
                    var data_arr = {og_title : og_title,
                        og_desc : og_desc,
                        og_img : og_img, 
                        og_url : og_url,
                        og_site_name : og_site_name,
                        tw_title : tw_title,
                        tw_desc : tw_desc,
                        tw_img : tw_img
                    };
    
                    for (var key in data_arr) {
                        if (data_arr.length) {
                            if (data_arr[key].length > 1) {
                                key = data_arr[key].slice(-1)[0];
                            } else {
                                key = data_arr[key][0];
                            }
                        }
                    }

                    $( '#seopress_cpt .google-snippet-preview .snippet-title' ).html(s.data.title),
                    $( '#seopress_cpt .google-snippet-preview .snippet-title-default' ).html(s.data.title),
                    $( '#seopress_titles_title_meta' ).attr("placeholder", s.data.title),
                    $( '#seopress_cpt .google-snippet-preview .snippet-description' ).html(s.data.meta_desc),
                    $( '#seopress_cpt .google-snippet-preview .snippet-description-default' ).html(s.data.meta_desc),
                    $( '#seopress_titles_desc_meta' ).attr("placeholder", s.data.meta_desc),
                    
                    $( '#seopress_cpt #seopress_social_fb_title_meta' ).attr("placeholder", data_arr.og_title),
                    $( '#seopress_cpt .facebook-snippet-preview .snippet-fb-title').html(data_arr.og_title),
                    $( '#seopress_cpt .facebook-snippet-preview .snippet-fb-title-default').html(data_arr.og_title),
                    
                    $( '#seopress_cpt #seopress_social_fb_desc_meta' ).attr("placeholder", data_arr.og_desc),
                    $( '#seopress_cpt .facebook-snippet-preview .snippet-fb-description').html(data_arr.og_desc),
                    $( '#seopress_cpt .facebook-snippet-preview .snippet-fb-description-default').html(data_arr.og_desc),

                    $( '#seopress_cpt #seopress_social_fb_img_meta' ).attr("placeholder", data_arr.og_img),
                    $( '#seopress_cpt .snippet-fb-img img' ).attr("src", data_arr.og_img),
                    $( '#seopress_cpt .snippet-fb-img-default img' ).attr("src", data_arr.og_img),

                    $( '#seopress_cpt .facebook-snippet-preview .snippet-fb-url').html(data_arr.og_url),
                    $( '#seopress_cpt .facebook-snippet-preview .snippet-fb-site-name').html(data_arr.og_site_name),

                    $( '#seopress_cpt #seopress_social_twitter_title_meta' ).attr("placeholder", data_arr.tw_title),
                    $( '#seopress_cpt #seopress_social_twitter_desc_meta' ).attr("placeholder", data_arr.tw_desc),
                    $( '#seopress_cpt #seopress_social_twitter_img_meta' ).attr("placeholder", data_arr.tw_img),
                    
                    $( '#seopress_cpt #seopress_robots_canonical_meta').attr('placeholder', s.data.canonical),
                    
                    $( '#seopress-analysis-tabs').load(" #seopress-analysis-tabs-1", '', sp_ca_toggle),
                    $(".analysis-score p").removeClass('loading')
                },
            });
        }
        hasSaved = !! isSavingPost;
    });
});