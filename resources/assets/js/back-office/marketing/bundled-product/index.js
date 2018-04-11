/** 
 * @author: Piyaporn Saykaew
 * @phone: 0884350313
 * @email: piyaporn.saykaew@gmail.com
 */

$(document).ready(function () { 
    // //center
    // $height = $(window).height() - 200;
    // $('.panel-content').css('max-height', $height);

    // $(window).resize(function(event) {
    //     event.preventDefault();
    //     //center
    //     $height = $(window).height() - 200;
    //     $('.panel-content').css('max-height', $height);
    // });

    var checkAll = $('#selectall');
    var checkboxes = $('input[name="item[]"]');

    checkAll.on('ifChecked ifUnchecked', function (event) {
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function (event) {
        if (checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.prop('checked', false);
        }
        checkAll.iCheck('update');
    });
});
