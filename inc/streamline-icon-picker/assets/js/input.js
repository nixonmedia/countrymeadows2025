(function($) {
  $(document).ready(function() {
    const $selects = $('.streamline-icon-select');

    if (typeof $.fn.select2 !== 'undefined') {
      $selects.select2({
        placeholder: "Search for an icon...",
        allowClear: true,
        width: '100%',
        templateResult: formatIconOption,
        templateSelection: formatIconOption
      });
    }

    function formatIconOption(option) {
      if (!option.id) return option.text; // skip placeholder

      const $option = $(option.element);
      const previewUrl = $option.data('preview');
      const name = option.text;

      if (previewUrl) {
        const $html = $(`
          <div style="display:flex;align-items:center;gap:8px;">
            <img src="${previewUrl}" alt="${name}" style="width:20px;height:20px;object-fit:contain;">
            <span>${name}</span>
          </div>
        `);
        return $html;
      } else {
        return name;
      }
    }

    // Handle preview below dropdown (optional)
    $selects.on('change', function() {
      const $this = $(this);
      const $container = $this.parent();

      $container.find('.streamline-preview').remove();
    });
  }); 
})(jQuery); 
