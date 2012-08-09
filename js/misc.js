$(function() {

    $('#delete_upload').live('click', function() {

        filename_key = $(this).data('key');

        $.ajax({
          type: 'POST',
          data: {'action':'supra_csv','command':'delete_file','args':filename_key},
          url: ajaxurl,
          success: function(msg){
              $('#supra_csv_upload_forms').html(msg);
          }
        });

    });

    $('#download_upload').live('click', function() {

        var file = $(this).data('file');

        $.ajax({
          type: 'POST',
          data: {'action':'supra_csv','command':'download_file','args':file},
          url: ajaxurl,
          success: function(msg){
              $('#supra_csv_preview').html(msg);
          }
        });
    });

    $('#select_csv_file').live('change', function() {
        filename_key = $(this).val();

        if(key) {
          $.ajax({
            type: 'POST',
            data: {'action':'supra_csv','command':'select_ingest_file','args':filename_key},
            url: ajaxurl,
            success: function(msg){
                msg = $.parseJSON(msg);
                $('#supra_csv_ingestion_mapper').html(msg.map);
                $('#supra_csv_mapping_preset').html(msg.preset);
                clearMappingForm();
            }
          });
        }
    });

    $('#supra_csv_ingest_csv').live('click', function(e) {
        e.preventDefault();

        $('#patience').show();

        var data = $('#supra_csv_mapping_form').serialize();
        var filename = $('#supra_csv_mapping_form').data('filename');

        $.ajax({
          type: 'POST',
          data: {'action':'supra_csv','command':'ingest_file','args': {'data': data, 'filename':filename} },
          url: ajaxurl,
          success: function(msg){
              $('#supra_csv_ingestion_log').html(msg);
              $('#patience').hide();
          }
        });
    });
});
