$(function() { 
    preset_type = 'mapping';

    $('#create_' + preset_type + '_preset').live('click', function(e) {

        e.preventDefault();
        
        var mapping = $('#supra_csv_' + preset_type + '_form').serialize();  
        preset_name = $('#supra_csv_preset_name').val();

        $.ajax({
          type: 'POST',
          data: {'action':'supra_csv','command':'create_' + preset_type + '_preset','args': {'preset':mapping,'preset_name':preset_name,'filename_key':filename_key}},
          url: ajaxurl,
          success: function(preset){ presetCreateResponse(preset) }
        });

    });

    $('#update_' + preset_type + '_preset').live('click', function(e) {

        e.preventDefault();

        var mapping = $('#supra_csv_' + preset_type + '_form').serialize();
        preset_name = $('#supra_csv_preset_name').val();

        $.ajax({
          type: 'POST',
          data: {'action':'supra_csv','command':'update_' + preset_type + '_preset','args': {'preset_id':preset_id,'preset':mapping,'preset_name':preset_name,'filename_key':filename_key}},
          url: ajaxurl,
          success: function(preset){ presetUpdateResponse(preset) }
        });

    });

    $('#delete_' + preset_type + '_preset').live('click', function(e) {

        e.preventDefault();

        $.ajax({
          type: 'POST',
          data: {'action':'supra_csv','command':'delete_' + preset_type + '_preset','args': preset_id},
          url: ajaxurl,
          success: function(preset){ 
              $('#flash').html('<span class="success">Successfully deleted preset '  + preset_name  + '</span>')
              $('#select_' + preset_type + '_preset option[value=' + preset_id + ']').remove();
              clearMappingForm();
          }
        });

    });


    $('#select_' + preset_type + '_preset').live('change', function() {

        preset_id = $(this).val();

        if(preset_id) {
            $.ajax({
              type: 'POST',
              data: {'action':'supra_csv','command':'select_'+preset_type+'_preset','args': preset_id},
              url: ajaxurl,
              success: function(msg){
                  msg = $.parseJSON(msg);
                  var preset = msg.preset;
                  preset_name = msg.preset_name; 
                  $.each(preset, function(id,value) {
                      $('#supra_csv_' + id).val(value);
                  });
                  $('#supra_csv_preset_name').val(preset_name);
              }
            });

            $('#update_' + preset_type + '_preset').removeAttr('disabled');
            $('#delete_' + preset_type + '_preset').removeAttr('disabled');
        }
        else {
            $('#update_' + preset_type + '_preset').attr('disabled','disabled');
            $('#delete_' + preset_type + '_preset').attr('disabled','disabled');
        }
    });
});
