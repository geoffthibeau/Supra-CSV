var presetCreateResponse = function(preset) {
              preset = $.parseJSON(preset);

              var select = $('#select_' + preset_type + '_preset');

              if(select.prop) {
                  var options = select.prop('options');
              }
              else {
                  var options = select.attr('options');
              }

              options[options.length] = new Option(preset.name,preset.id);
              $(select).val(preset.id);
              $(select).trigger('change');
              $('#flash').html(preset.msg);
}

var presetUpdateResponse = function(preset) {
              preset = $.parseJSON(preset);
              $('#select_' + preset_type + '_preset option').each(function() {
                  if(this.value == preset_id)
                      this.text = preset_name;
              });

              $('#select_' + preset_type + '_preset').val(preset_id);
              $('#select_' + preset_type + '_preset').trigger('change');
              $('#flash').html(preset.msg);
}

var clearMappingForm = function() {
    $('#supra_csv_' + preset_type + '_form').find(':input').each(function() {
        $(this).val('');
    });
    $('#update_' + preset_type + '_preset').attr('disabled','disabled');
    $('#delete_' + preset_type + '_preset').attr('disabled','disabled');
    $('#supra_csv_preset_name').val(null);
}

