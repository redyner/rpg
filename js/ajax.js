$('#formulario_levelup').submit(function(e){
    e.preventDefault();

    var xp_setada = $('#set_xp').val();
    var sta_setada = $('#set_sta').val();
    var str_setada = $('#set_str').val();
    var int_setada = $('#set_int').val();
    var dex_setada = $('#set_dex').val();

    //console.log(u_name, u_comment);
    $.ajax({
        url: 'http://localhost/RPG/paginas/testeajax.php',
        method: 'POST',
        data: {set_xp: xp_setada, set_ta:sta_setada, set_str: str_setada, set_int: int_setada, set_dex: dex_setada},
        dataType: 'json'
    }).done(function(result){
        xp_setada = ''
        $('#set_sta').val('');
        $('#set_str').val('');
        $('#set_int').val('');
        $('#set_dex').val('');
        console.log(result);
       
    });
});