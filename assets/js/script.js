;(function($){
  $.versioncompare = function(version1, version2){
    if ('undefined' === typeof version1) {
      throw new Error("$.versioncompare needs at least one parameter.");
    }
    version2 = version2 || $.fn.jquery;
    if (version1 == version2) {
      return 0;
    }
    var v1 = normalize(version1);
    var v2 = normalize(version2);
    var len = Math.max(v1.length, v2.length);
    for (var i = 0; i < len; i++) {
      v1[i] = v1[i] || 0;
      v2[i] = v2[i] || 0;
      if (v1[i] == v2[i]) {
        continue;
      }
      return v1[i] > v2[i] ? 1 : -1;
    }
    return 0;
  };
  function normalize(version){
    return $.map(version.split('.'), function(value){
      return parseInt(value, 10);
    });
  }
}(jQuery));

if( jQuery.versioncompare(jQuery.fn.jquery, "2.0.0") > -1)
{
    jQuery.fn.live = jQuery.fn.on;
}

var image_field;

jQuery(function($){

    $('input.devdk-select-img').live("click", function(e) {
        e.preventDefault();

        image_field = $(this).parent().parent();

        var custom_uploader = wp.media({
            title: 'Upload Billede',
            button: {
                text: 'Tilføj til widget'
            },
            multiple: false  // Set this to true to allow multiple files to be selected
        })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            image_field.find('.devdk-img-placeholder img').remove();
            image_field.find('.devdk-img-placeholder').append('<img src="'+attachment.sizes.thumbnail.url+'"/>');
            image_field.find('input.devdk-image-field').val(attachment.id);
        })
        .open();
    });
});