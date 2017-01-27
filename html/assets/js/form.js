/**
 * Created by jacson on 24/01/2017.
 */
$(function () {
    var uri = 'http://localhost:4040';
    $('.form').on("submit",formData);

    function formData() {
        var data = $('.form').serialize();

        $.ajax({
            url: uri+'/login/input',
            data:data,
            type:'POST',
            dataType:'json',
            beforeSend:function () {
                $("input[type=submit]").val("aguarde...");
            },
            success:function (d) {
                localStorage.setItem('token', d.accesstoken);
                window.location.href = uri+'/admin';
            },
            error:function (e) {
                console.log(e);
            }
        });
        return false;
    }
})