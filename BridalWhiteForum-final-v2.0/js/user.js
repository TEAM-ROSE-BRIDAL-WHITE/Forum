$(document).ready(function(){
    $('#regForm').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: 'user.php',
            data: {
                reg: 'tryReg',
                username: $('#username').val(),
                mail: $('#inputEmail3').val(),
                pass1: $('#inputPassword3').val(),
                pass2: $('#pass').val()
            },
            type: 'POST',
            success: function(result){
                $('.resultHolder').text(result);
            }
        });
        setInterval(function(){
            if($('.resultHolder').text()=='Пренасочваме ви!'){
                location.href='index.php';
            }
        }, 200)
    });
    $('#logForm').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: 'user.php',
            data: {
                log: 'tryLog',
                mail: $('#inputEmail3').val(),
                pass: $('#inputPassword3').val()
            },
            type: 'POST',
            success: function(result){
                $('.resultHolder').text(result);
            }
        });
        setInterval(function(){
            if($('.resultHolder').text()=='Пренасочваме ви!'){
                location.href='index.php';
            }
        }, 200)
    });
    $('.showRegForm').on('click', function(){
        $('.singIn').show();
    });
});