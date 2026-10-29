(function( $ ){

  $.fn.filemanager = function(type, options) {
    type = type || 'file';
    var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';

    this.off('click.lfm').on('click.lfm', function(e) {
      e.preventDefault();
      var inputId = $(this).attr('data-input') || $(this).data('input');
      var previewId = $(this).attr('data-preview') || $(this).data('preview');
      if (!inputId || !previewId) return false;

      // Store IDs on window so SetUrl can find elements when called from popup
      window._lfmInputId = inputId;
      window._lfmPreviewId = previewId;

      window.SetUrl = function (items) {
        if (!items || !items.length) return;
        var inputId = window._lfmInputId;
        var previewId = window._lfmPreviewId;
        if (!inputId || !previewId) return;

        var target_input = document.getElementById(inputId);
        var target_preview = document.getElementById(previewId);
        if (!target_input) return;

        var file_path = items.map(function (item) {
          return item.url || '';
        }).filter(Boolean).join(',');

        target_input.value = file_path;
        $(target_input).trigger('change');

        if (target_preview) {
          target_preview.innerHTML = '';
          items.forEach(function (item) {
            var src = item.thumb_url || item.url || '';
            if (src) {
              var img = document.createElement('img');
              img.src = src;
              img.alt = '';
              img.style.height = '5rem';
              target_preview.appendChild(img);
            }
          });
          $(target_preview).trigger('change');
        }
      };

      var winName = 'FileManager_' + Date.now();
      window.open(route_prefix + '?type=' + type, winName, 'width=900,height=600');
      return false;
    });
  }

})(jQuery);
