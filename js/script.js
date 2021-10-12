///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS DE BATALHA//
//////////////////////

//////////////////////////////////////////////////////////////////////////////


window.addEventListener("load", eventos_batalha);

function eventos_batalha() {
  document.getElementById("atacar").addEventListener("click", iniciar_batalha);
}

var intervalo;

function reiniciar() {
  location.reload();
}

function iniciar_batalha() {
  document.getElementById("atacar").disabled = true;
  document.getElementById("atacar").innerHTML = "Atacando"
  intervalo = setInterval(function (event) {
    var hp_1 = document.getElementById('hp_atual_1');
    var hp_2 = document.getElementById("hp_atual_2");
    combate(hp_1, hp_2);
  }, 1000);
}

function parar_batalha() {
  clearInterval(intervalo)
}

function combate(hp_1, hp_2) {
  var valida_crit_personagem = (str_personagem >= int_personagem) ? str_personagem : int_personagem * 2;
  var valida_crit_inimigo = (str_inimigo >= int_inimigo) ? str_inimigo : int_inimigo * 2;
  var power = [];
  var dano = [];
  speed();
  calculo_dano();
  hp_batalha_inimigo -= dano['personagem'];
  hp_batalha_personagem -= dano['inimigo'];
  var porcentagem_hp_inimigo = hp_batalha_inimigo * 100 / hp_inimigo;
  var porcentagem_hp_personagem = hp_batalha_personagem * 100 / hp_personagem;
  if (porcentagem_hp_inimigo < 0) porcentagem_hp_inimigo = 0;
  if (porcentagem_hp_personagem < 0) porcentagem_hp_personagem = 0;
  if (power['personagem'] >= power['inimigo']) {
    (dano['personagem'] > valida_crit_personagem) ? (document.getElementById("relatorio").innerHTML += "Voce causou " + dano['personagem'] + " de dano critico!<br><hr>") : document.getElementById("relatorio").innerHTML += "Voce causou " + dano['personagem'] + " de dano.<br><hr>";
    hp_2.style.width = porcentagem_hp_inimigo + "%";
    if (porcentagem_hp_inimigo > 0) {
      (dano['inimigo'] > valida_crit_inimigo) ? (document.getElementById("relatorio").innerHTML += "Voce recebeu " + dano['inimigo'] + " de dano critico!<br><hr>") : (document.getElementById("relatorio").innerHTML += "Voce recebeu " + dano['inimigo'] + " de dano.<br><hr>");
      hp_1.style.width = porcentagem_hp_personagem + "%";
    }
  } else {
    (dano['inimigo'] > valida_crit_inimigo) ? (document.getElementById("relatorio").innerHTML += "Voce recebeu " + dano['inimigo'] + " de dano critico!<br><hr>") : (document.getElementById("relatorio").innerHTML += "Voce recebeu " + dano['inimigo'] + " de dano.<br><hr>");
    hp_1.style.width = porcentagem_hp_personagem + "%";
    if (porcentagem_hp_personagem > 0) {
      (dano['personagem'] > valida_crit_personagem) ? (document.getElementById("relatorio").innerHTML += "Voce causou " + dano['personagem'] + " de dano critico!<br><hr>") : document.getElementById("relatorio").innerHTML += "Voce causou " + dano['personagem'] + " de dano.<br><hr>";
      hp_2.style.width = porcentagem_hp_inimigo + "%";
    }
  }

  $winner = (power['personagem'] >= power['inimigo']) ? porcentagem_hp_personagem >= porcentagem_hp_inimigo : porcentagem_hp_personagem > porcentagem_hp_inimigo;

  if (porcentagem_hp_personagem == 0 || porcentagem_hp_inimigo == 0) {
    if ($winner == true) {
      document.getElementById("relatorio").innerHTML += "Voce derrotou seu inimigo <br>E ganhou " + xp_inimigo + " pontos de experiencia!<br>";
      xp += xp_inimigo;
      if (xp >= xp_max) {
        lv += 1;
        xp_atual = xp - xp_max;
        xp = xp_atual;
        xp_max = xp_max + 50 * lv;
        sta_personagem += sta_lv;
        str_personagem += str_lv;
        int_personagem += int_lv;
        dex_personagem += dex_lv;
        gold += lv_inimigo * 10;
        document.getElementById("relatorio").innerHTML += "Parabens! voce subiu para o nivel " + lv + "<br>";
        ////////////////////////////////////////////////////////////////////////////////////////////
        //Aqui eu preciso atualizar as informações do banco de dados e atualizá-los na sessão php//
        //////////////////////////////////////////////////////////////////////////////////////////
        var personagem = {
          'lv': lv,
          'xp': xp,
          'xp_max': xp_max,
          'sta_personagem': sta_personagem,
          'str_personagem': str_personagem,
          'int_personagem': int_personagem,
          'dex_personagem': dex_personagem,
          'xp_inimigo': xp_inimigo,
          'gold': gold
        }

        var dados = JSON.stringify(personagem);

        $.ajax({
          url: 'http://localhost/RPG/paginas/levelup.php',
          type: 'POST',
          data: { data: dados },
          success: function (result) {
            console.log(result)
          }
        });
      } else {
        gold += lv_inimigo * 10;
        ////////////////////////////////////////////////////////////////////////////////////////////
        //Aqui eu preciso atualizar as informações do banco de dados e atualizá-los na sessão php//
        //////////////////////////////////////////////////////////////////////////////////////////
        var personagem = {
          'xp': xp,
          'gold': gold
        }

        var dados = JSON.stringify(personagem);

        $.ajax({
          url: 'http://localhost/RPG/paginas/levelup.php',
          type: 'POST',
          data: { data: dados },
          success: function (result) {
            console.log(result)
          }
        });

      }
    }
    else document.getElementById("relatorio").innerHTML += "Voce foi derrotado!<br>";
    document.getElementById("atacar").innerHTML = "Reiniciar"
    document.getElementById("atacar").disabled = false;
    document.getElementById("atacar").id = "reiniciar"
    document.getElementById("reiniciar").addEventListener("click", reiniciar);
    parar_batalha();
  }

  function calculo_dano() {

    var taxa = 100;
    var chance_crit_inimigo = Math.round(Math.random() * (taxa - 1) + 1);
    var chance_crit_personagem = Math.round(Math.random() * (taxa - 1) + 1);
    var taxa_crit_inimigo = dex_inimigo / 2;
    var taxa_crit_personagem = dex_personagem / 2;


    if (chance_crit_personagem <= taxa_crit_personagem) dano['personagem'] = (str_personagem > int_personagem) ? (str_personagem + dex_personagem * 2) : (int_personagem * 2 + dex_personagem);
    else (str_personagem >= int_personagem) ? (dano['personagem'] = str_personagem) : (dano['personagem'] = int_personagem * 2);

    if (chance_crit_inimigo <= taxa_crit_inimigo) dano['inimigo'] = (str_inimigo > int_inimigo) ? (str_inimigo + dex_inimigo * 2) : (int_inimigo * 2 + dex_inimigo);
    else (str_inimigo >= int_inimigo) ? (dano['inimigo'] = str_inimigo) : (dano['inimigo'] = int_inimigo * 2);

    return dano;

  }

  function speed() {

    power['personagem'] = sta_personagem + str_personagem + int_personagem + dex_personagem;
    power['inimigo'] = sta_inimigo + str_inimigo + int_inimigo + dex_inimigo;
    return power;

  }

}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS   DUNGEONS//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_dungeons);

function eventos_dungeons() {
  // document.getElementsByClassName("dungeon").addEventListener("click",exibir_dungeons);
  $("#floresta").on("click", inimigos_floresta);
  $("#planice").on("click", inimigos_planice);
  $("#ice").on("click", inimigos_ice);
  $("#lava").on("click", inimigos_lava);
  $("#gruta").on("click", inimigos_gruta);
}

function exibir_dungeons() {
  $("#selecao_inimigo").show()
}

function inimigos_floresta() {

  $("#selecao_inimigo").show()

  $('.avatar_inimigo_selecao').hide()
  $("#Javali").show()
  $("#Urso").show()
  $("#Snake").show()

}

function inimigos_planice() {

  $("#selecao_inimigo").show()
  $('.avatar_inimigo_selecao').hide()
  $("#Goblin").show()
  $("#Orc").show()
  $("#Ogro").show()
}

function inimigos_ice() {

  $("#selecao_inimigo").show()
  $('.avatar_inimigo_selecao').hide()
  $("#Lobo").show()
  $("#Ice_Warrior").show()
  $("#Ice_King").show()
}

function inimigos_lava() {

  $("#selecao_inimigo").show()
  $('.avatar_inimigo_selecao').hide()
  $("#Drag").show()
  $("#Cerberus").show()
  $("#Demon").show()
}

function inimigos_gruta() {

  $("#selecao_inimigo").show()
  $('.avatar_inimigo_selecao').hide()
  $("#Blue_Drag").show()
  $("#Boss").show()
}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS      ARENA//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_arena);

function eventos_arena() {
  $('#buscar_arena').submit(function (e) {
    e.preventDefault();

    var nick_buscado = $('#busca_nick').val();

    $.ajax({
      url: 'http://localhost/RPG/paginas/buscaarena.php',
      method: 'POST',
      data: { busca_nick: nick_buscado },
      dataType: 'json'
    }).done(function (result) {
      $('.avatar_inimigo_batalha').attr("name", result['classe_inimigo'])
      nick_inimigo = result['nick_inimigo']
      sta_inimigo = result['sta_inimigo']
      str_inimigo = result['str_inimigo']
      int_inimigo = result['int_inimigo']
      dex_inimigo = result['dex_inimigo']
      lv_inimigo = result['lv_inimigo']
      hp_inimigo = sta_inimigo * 10;
      hp_batalha_inimigo = hp_inimigo;
    });
  });
}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS      ITENS//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_inventario)

function eventos_inventario() {

  $('.slot').on("mouseover", function (event) {
    var box = this.id
    var info = $(this).data("info")
    $('#'+box).css('border', '5px solid grey');
    $(info).show();
  });

  $('.slot').on("mouseout", function (event) {
    var box = this.id
    var info = $(this).data("info");
    var indice = $(this).data("indice")
    if (slot[indice][1]=="N") $('#'+box).css('border', '5px solid black')
    $(info).hide()
  });

  $('.slot').on("click", function (event) {
    var id_inventario = $(this).data("id_inventario")
    var indice = $(this).data("indice")
    var box = this.id
    if (slot[indice][1] == "N") {
      var equipar = confirm("Deseja equipar este item?")
      if (equipar == true) {
        $('.slot').css('border', '5px solid black');
        for(var i=0;i<slot.length;i++)
        {
        slot[i][1] = "N";
        }
        $('#'+box).css('border', '5px solid grey');
        slot[indice][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: id_inventario, equipado: slot[indice][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          },
          error: function (result) {
            alert(JSON.stringify(result));
          }
        })
      } else slot[indice][1] = "N";
    }
    else {
      equipar = confirm("Deseja desequipar este item?")
      if (equipar == true) {
        $('#'+box).css('border', '5px solid black');
        slot[indice][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: id_inventario, equipado: slot[indice][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[indice][1] = "S";
    }
  });

}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS      FORJA//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_forja)

function eventos_forja() {

  var porcentagem_refinar = 0;

  var selecionado = false;

  $('.slotf').on("mouseover", function (event) {
    var box = this.id
    var info = $(this).data("info")
    $('#'+box).css('border', '5px solid grey');
    $(info).show();
  });

  $('.slotf').on("mouseout", function (event) {
    var box = this.id
    var info = $(this).data("info");
    var indice = $(this).data("indice")
    if (slot[indice][1]=="N") $('#'+box).css('border', '5px solid black')
    $(info).hide()
  });

  $('.slotf').on("click", function (event) {
    var box = this.id
    var id_inventario = $(this).data("id_inventario")
    var indice = $(this).data("indice")
    if (slot[indice][1] == "N") {
      equipar = confirm("Deseja selecionar este item?")
      if (equipar == true) {
        $('.slotf').css('border', '5px solid black');
        for(var i=0;i<slot.length;i++)
        {
        slot[i][1] = "N";
        }
        $('#'+box).css('border', '5px solid grey');
        slot[indice][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itensf.php',
          method: 'POST',
          data: { id_inventario: id_inventario, equipado: slot[indice][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            nome = result['nome']
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            ref = result['ref']
            id_inventario = result['id_inventario']
            equipado = result['equipado']
            $('.avatar_item').attr("data-id_inventario", id_inventario)
            $('.avatar_item').attr("data-equipado", equipado)
            $('.avatar_item').attr("name", result['nome'])
            selecionado = true;
          }
        })
      } else slot[indice][1] = "N";
    }
    else {
      equipar = confirm("Deseja remover este item?")
      if (equipar == true) {
        $('#'+box).css('border', '5px solid black');
        slot[indice][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itensf.php',
          method: 'POST',
          data: { id_inventario: id_inventario, equipado: slot[indice][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            nome = result['nome']
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            ref = result['ref']
            id_inventario = result['id_inventario']
            equipado = result['equipado']
            $('.avatar_item').attr("data-id_inventario", "")
            $('.avatar_item').attr("data-equipado", "")
            $('.avatar_item').attr("name", "")
            selecionado = false;
          }
        })
      } else slot[indice][1] = "S";
    }
  });

  $('#refinar').on("click", function (event) {
    var id_inventario = $('.avatar_item').data("id_inventario")
    var equipado = $('.avatar_item').data("equipado")
    if (selecionado == true)
    {
      comfirma_refinar = confirm("Deseja refinar este item?")
      if (comfirma_refinar == true) iniciar_refino(id_inventario,equipado)
    }  
    });

    function iniciar_refino(id_inventario,equipado)
    {
      refinando = setInterval(function (event) {
        var barra_refinar = $('#barra_refinar');
        var refinar_atual = $("#refinar_atual");

        refinar(barra_refinar, refinar_atual,id_inventario,equipado);
      }, 1000);
    }

    function refinar(barra_refinar, refinar_atual,id_inventario,equipado)
    {
          id_inventario;
          porcentagem_refinar += 25;
          refinar_atual.width(porcentagem_refinar + "%");
          if(refinar_atual.width()>=250)
          {
            $.ajax({
              url: 'http://localhost/RPG/paginas/refinar.php',
              method: 'POST',
              data: {id_inventario: id_inventario, equipado: equipado, ref: ref},
              dataType: 'json',
              success: function (result) {
                console.log(result)
                nome = result['nome']
                sta = result['sta']
                str = result['str']
                int = result['int']
                dex = result['dex']
                ref = result['ref']
                id_inventario = result['id_inventario']
                equipado = result['equipado']
              }
            })
            $('#status_refino').html("Item Refinado com sucesso!")
            parar_refino();
          }
    }
    
    function parar_refino() {
      clearInterval(refinando)
    }

    

}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS     MARKET//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_market)

function eventos_market() {

  var slots_compra = $("#comprar_item");
  slots_compra.show();

  var slots_venda = $("#vender_item");
  slots_venda.hide();

  $('#vendercomprar').on("click", function (event) {
    if ($('#vendercomprar').html() == 'Vender') {
      $('#vendercomprar').html("Comprar");
      slots_venda.show();
      slots_compra.hide();
    }
    else {
      $('#vendercomprar').html("Vender")
      slots_venda.hide();
      slots_compra.show();
    }
  });

  $('.slotm').on("mouseover", function (event) {
    var box = this.id
    var info = $(this).data("info")
    $('#'+box).css('border', '5px solid grey');
    $(info).show();
  });

  $('.slotm').on("mouseout", function (event) {
    var box = this.id
    var info = $(this).data("info")
    $('#'+box).css('border', '5px solid black');
    $(info).hide();
  });

  $('.slotm').on("click", function (event) {
    var indice = $(this).data("indice")
    var id = this.id
    var id_inventario = $(this).data("id_inventario")
    if ($('#vendercomprar').html()=="Vender") var compra = confirm("Deseja comprar este item?")
    if ($('#vendercomprar').html()=="Comprar") var venda = confirm("Deseja vender este item?")
    if (compra == true || venda == true) {
      if (compra == true) var tipo = "c"
      else var tipo = "v"
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[indice][0], id_inventario: id_inventario, valor: slot[indice][1], tipo: tipo },
        dataType: 'json',
        success: function (result) {
          $(".gold").html("GOLD - "+result['gold']);
          if (tipo == "v")
          {
            $('#'+id).attr("data-info", "")
            $('#'+id).attr("data-slot", "")
            $('#'+id).attr("data-id_inventario", "")
            $('#'+id).attr("data-indice", "")
            $('#'+id).attr("name", "")
            $('#'+id).attr("class", "slot_empty")
            $('#'+id).hide()
            $('#'+id).attr("id", "")
          }
          else{
             ///////////////////////////////////////////////////////////////
            //adicionar evento para adicionar imagem aos itens para venda//
          ////////////////////////////////////////////////////////////////
          }
        },
        error: function (result) {
          alert(JSON.stringify(result));
        }
      })
    }
  });

}


