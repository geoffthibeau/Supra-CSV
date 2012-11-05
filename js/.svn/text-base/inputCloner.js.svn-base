$(function () {

            checkAddRem();

            $('#add_pmr').live('click', function(e) {

                e.preventDefault();

                num     = $('.pm_info').length - 1;

                var newNum  = new Number(num + 1);

                var newElem = $('#pm_info' + num).clone().attr('id', 'pm_info' + newNum);

                newElem.children('#meta_key'+num).attr('id', 'meta_key' + newNum).attr('name', 'meta_key[]').val(null);

                newElem.children('#displayname'+num).attr('id', 'displayname' + newNum).attr('name', 'displayname[]').val(null);

                $('#pm_info' + num).after(newElem);

                $('#rem_pmr').removeAttr('disabled');

            });

            $('#rem_pmr').live('click', function(e) {

                e.preventDefault();

                num = $('.pm_info').length - 1;

                $('#pm_info' + num).remove();

                $('#add_pmr').removeAttr('disabled');

                if (num == 1)
                    $('#rem_pmr').attr('disabled','disabled');
            });
});


var checkAddRem = function() {
    var num = $('.pm_info').length;
    console.log(num);
    if (num <= 1)
        $('#rem_pmr').attr('disabled','disabled');
    else
        $('#rem_pmr').removeAttr('disabled');
}
