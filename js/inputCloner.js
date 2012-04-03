$j = jQuery;

$j(function () {

            $j('#add_pmr').click(function() {

                var num     = $j('.pm_info').length;

                var newNum  = new Number(num + 1);

                var newElem = $j('#pm_info' + num).clone().attr('id', 'pm_info' + newNum);

                newElem.children('#meta_key'+num).attr('id', 'meta_key' + newNum).attr('name', 'meta_key[]').val(null);

                newElem.children('#displayname'+num).attr('id', 'displayname' + newNum).attr('name', 'displayname[]').val(null);

                $j('#pm_info' + num).after(newElem);

                $j('#rem_pmr').removeAttr('disabled');

            });

            $j('#rem_pmr').click(function() {

                var num = $j('.pm_info').length;

                $j('#pm_info' + num).remove();

                $j('#add_pmr').removeAttr('disabled');

                if (num-1 == 1)
                    $j('#rem_pmr').attr('disabled','disabled');
            });
});


