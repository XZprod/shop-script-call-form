let min = 12;
let max = 21;
let htmlLabels = generateTimeLabels();
let errors = false;

let $timeRange = $('#time-range');
let $timeFrom = $('#time-from');
let $timeTo = $('#time-to');
let $agree = $('#agree');
let $name = $('#name');
let $phone = $('#phone');
let $captchaError = $('.captcha-error');
let $req = $('#request');

$timeRange.slider({
    range: true,
    min: min,
    max: max,
    values: [12, 21],
    slide: function (event, ui) {
        $timeFrom.val(ui.values[0]);
        $timeTo.val(ui.values[1]);
        // $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
    }
});

$timeRange.append(htmlLabels);

$phone.mask('+7 (000) 000 00 00', {
    placeholder: "+7"
});

$req.click(function () {
    clearValidateErrors();
    if (!$agree.prop('checked')) {
        addValidateError($agree, 'Необходимо принять условия соглашения');
    }
    if ($name.val().length === 0) {
        addValidateError($name, 'Обязательное поле');
    }
    if ($phone.cleanVal().length !== 10) {
        addValidateError($phone, 'Ошибка в номере');
    }

    if (!errors) {
        $req.prop('disabled', true);
        $.ajax({
            type: "POST",
            url: '/index.php/shop/ordercall/',
            data: $('#callForm').serialize(),
            success: function (data) {
                $req.prop('disabled', false);
                if (data.data.captchaError == true) {
                    $captchaError.text('Ошибка капчи');
                    $captchaError.show();
                    return;
                }

                if (data.data.validateErrors && data.data.validateErrors.length > 0) {
                    $req.prop('disabled', false);

                    data.data.validateErrors.forEach(function (i) {
                        // пока не нашел другого способа
                        let k = Object.keys(i)[0];
                        let v = Object.values(i)[0];
                        let $el = $('#' + k);
                        addValidateError($el, v);
                    });
                }
                else {
                    $('#ordercallloc-form').text('Заявка успешно отправлена!');
                }
            },
            error: function (data) {
                console.log(data);
            },
        });
    }
});

function generateTimeLabels() {
    let labels = '';
    let vals = max - min;

    for (let i = min; i <= max; i++) {
        labels += '<label style="padding-left:' + ((i - min) / vals * 100) + '%;">' + i + '</label>';
    }
    return '<div style="">' + labels + '</div>';
}

function clearValidateErrors() {
    errors = false;
    $('.validation-error').hide();
    $captchaError.hide();
    $('.form-input').removeClass('input-error');

}

function addValidateError($input, msg) {
    errors = true;
    $input.addClass('input-error');
    $input.parent().find('.validation-error').text(msg).show();
}