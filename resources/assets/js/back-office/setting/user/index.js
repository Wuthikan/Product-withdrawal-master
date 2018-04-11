/**
 * @author: Jirawat I.
 * @phone: 098-318-7208
 * @email: nodtem66@gmail.com
 */

var resizeTimer;
$(document).ready(() => {
  function exportData() {
    $('#exportData').unbind('click');
    $('#data_export').submit();
  }

  $("#exportData").click(exportData);

  function multipleDelete() {

    if($('input.item').filter(':checked').length == 0)
    {
      return false;
    }

    $('#deleteAll').unbind('click');

    this.itemChecked = [];
    var multipleDelete = this;

    $('input.item').filter(':checked').each(function () {
      multipleDelete.itemChecked.push(this.value);
    });

    console.log(JSON.stringify(this.itemChecked));

    $('input[name*="deleteId"]').val(JSON.stringify(this.itemChecked));

    $('form[id="form_multiple_delete"]').submit();

    // $('#deleteAll').bind(click, multipleDelete);
  }

  $('#deleteAll').click(multipleDelete);

  $('.switchCheck').click((e)=>{
    let text = 'BLOCK';
    let value = 'block';

    if(e.target.checked) {
      text = 'NORMAL';
      value = 'unblock';
    }

    $('input[name=isBlock]').val(value)

    $(e.target).closest('form').submit();
    $(e.target).parent().next().text(text);
  });

  $(window).resize((event) => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(tabContent, 250);
  });

  resizeTimer = window.setTimeout(tabContent, 250);

});

function tabContent(){
  // set dynamic panel width
  var width = $('#user').width();
  $('.panel-user-left').width(width-216);
  $('.profile-text').width(width-216-128);
  // set dynamic last row hieght
  var height = $('tr.last-row').height();
  $('.status-group').height(height);
}