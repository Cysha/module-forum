function slugify(text) {
    return text
        .toString()
        .toLowerCase()
        .replace(/\s+\_/g, '-')         // Replace hyphens followed by spaces to with -
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}

jQuery(document).ready(function(){
    jQuery('input[data-toggle="slugify"][data-target]').each(function(idx, ele) {

        // make sure we can get to the target
        var target = jQuery(jQuery(ele).data('target'));
        if (!target.length) {
            return;
        }

        target.on('keyup', function(){
            // grab the input value & slugify it
            var targetValue = jQuery(target).val();
            var slugValue = slugify(targetValue);

            jQuery(ele).val(slugValue);
        });
    });
});
