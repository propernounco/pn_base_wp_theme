//Rules
jQuery(document).ready(function($){
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