/**
 * @author:ปิยะพร ทรายแก้ว
 * @phone: 0884350313
 * @email: piyaporn.saykaew@gmail.com
 */
$(".date").datetimepicker({ viewMode: "days", format: "DD/MM/YYYY" });

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            // $('.profilePicture').attr('src', e.target.result);
            $(input).prev().attr('src', e.target.result);
            $('#imageShow').val(input.name);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$('[id^=profilePictureField]').change(function () {
    readURL(this);
    if(this.id=='profilePictureField1'){
        $('input:radio[value=image1]').iCheck('check');
    } else {
        $('input:radio[value=image2]').iCheck('check');
    }
});

$('input:radio[value^=image]').on('ifChecked', function () {
	if(this.value=='image1'){
		$('input:radio[value=image2]').iCheck('uncheck');
	} else {
		$('input:radio[value=image1]').iCheck('uncheck');
	}
});