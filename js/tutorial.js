//Nota <hr> cria uma linha na página (comando html)

//display = "none" remove elemento da página

//vizibility = "hidden" oculta elemento da página

//tipos de variável

var variavel //variável em js

var x,y,z; //várias variáveis 

const constante //constante em js

let variavel_temporaria //variável limitada pelo escopo

alert("alerta") //box de alerta

var variavel = prompt("Insira seu nome: ") // recebe um valor

var variavel = confirm("Seu nome é " + variavel + " ?") //box com opção ok e cancelar retorna true e false

document.write("Printa um texto na tela") //printa texto no documento

//estrutura if
if(variavel>0){ 
}

//estrutura switch
switch(variavel){ 
    case x:
        variavel = 1
        break;
    case y:
        variavel = "2"
        break;
    default:

}

//definir vetor
var vetor = new Array();

var vetor = [];
var vetor1 = [];
var vetor2 = [];

//adiciona item ao final do array
vetor.push(1)

//adiciona item ao inicio do array
vetor.unshift(1)

//remove o item do final do array
vetor.pop()

//remove o item do inicio do array
vetor.shift()

//remove uma quantidade de itens a partir de um índice
vetor.splice(1,3) //primeiro valor é o índice do vetor // segundo valor é a quantidade itens removidos

//retorna o índice que contém o valor
vetor.indexOf(1)

//ordena os itens do array
vetor.sort()

//reverte a ordem dos itens do array
vetor.reverse()

//criar uma string com itens do array
vetor.join()

//concatena dois arrays
vetor1.concat(vetor2)

//retorna o tamanho do array
vetor.length

//acessar item de uma matriz
vetor[0][2][1]

//incrementos
variavel += 2 //incrementa qualquer valor
variavel *= 2 //incrementa qualquer valor
variavel /= 2 //decrementa qualquer valor
variavel -= 2 //decrementa qualquer valor
variavel++ //incrementa 1
variavel-- //decrementa 1

//pós e pré incremento
document.write(variavel++)//imprime variável
document.write(++variavel)//imprime variável com incremento

//pós e pré decremento
document.write(variavel++)//imprime variável
document.write(++variavel)//imprime variável com decremento

//inverso do numero
-variavel //valor inverso da variável (não altera o valor da variável)
variavel*=-1 //valor inverso da variável (altera o valor da variável)

//loop for
for (i =0; i<vetor.length;i++){
}

//loop while
i=0
while(i<2){
    i++
}

//loop do while
i=0
do{
    i++
}while(i<2)

//tratamento de erro
try{
docuent.wrie("ERRO")
}catch(variavel){
document.write("ERRO")
console.log("ERRO")
}finally{
    console.log("Fim do tratamento")
}

throw new Error("Erro manual")

//selecionando itens do documento
document.getElementById('id').style.color="#f00" //muda cor do texto

document.getElementById('id').style.fontSize="50px" //altera tamanho do texto

document.getElementById('id').style.display="none" //oculta elemento

document.getElementById('id').style.fontSize="50px" //altera tamanho do texto

document.getElementById('id').value // pega o valor de um elemento html pelo id

document.getElementById('id').innerHTML // pega todo o conteúdo dentro da tag html

document.getElementsByTagName('p') // pega o valor de todas as tags do tipo informado em forma de vetor

document.getElementsByTagName('*') // pega o valor de todas as tags do documento em forma de vetor

document.querySelectorAll('p') // pega o valor de todas as tags do tipo informado em forma de vetor

document.querySelectorAll('p,h1,h2') // pega o valor de todas as multiplas tags do tipo informado em forma de vetor

document.querySelectorAll('.classe') // pega o valor de todas as classes do tipo informado em forma de vetor

document.querySelectorAll('p.classe') // pega o valor de todas as classes contidas na tag do tipo informado em forma de vetor

document.querySelectorAll('div > *') // pega o valor de todos os itens dentro da tag informada em forma de vetor

document.querySelectorAll('div > p') // pega o valor de todos os itens com o tipo da tag dentro da tag informada em forma de vetor

document.querySelectorAll('div.classe > p') // pega o valor de todos os itens com o tipo da tag dentro da tag com a classe informada em forma de vetor

document.querySelectorAll('div.classe > *') // pega o valor de todos os itens dentro da tag com a classe informada em forma de vetor

//formulários

document.forms // manipulação de formulários

document.forms[0] // selecionando um formulário
//ou
document.forms.item(0)

document.forms.namedItem("name") // seleciona pelo nome

//É possível manipular vários elementos como:
document.forms[0].id
document.forms[0].value
document.forms[0].innerHTML // conteúdo do formulário
document.forms["id"].innerHTML // conteúdo do formulário

document.forms.elements // elementos do formulário

document.forms.getElementById("id").elements[0].value //exemplo de busca de valor de um elemento específico do formulário

document.write(Date()) // Imprime data completa

//classe Math
document.write(Math.PI) // Pi

document.write(Math.abs(valor)) // módulo

document.write(Math.ceil(valor)) // arredonda para cima

document.write(Math.floor(valor)) // arredonda para baixo

document.write(Math.round(valor)) // arredondamento padrão

document.write(Math.pow(valor,potencia)) // eleva o número a potência

document.write(Math.sqtr(valor)) // retorna raíz do número

document.write(Math.random()) // valor aleatório entre 0 e 1

document.write(Math.random()*valor) // valor aleatório entre 0 e o valor

document.write(Math.round(Math.random()*valor)) // utilizando a função round para valores inteiros

//funções

function nome_da_função(parametro1,parametro2){
    var soma = parametro1+parametro2
    return soma
}

nome_da_função() // chamada da função

var numeros = [1,2,3,4,5,6,7,8,9,10]

function media (numeros){
    var tamanho = num.length
    var soma = 0
    for(var i = 0;i<tamanho;i++){
        soma += numeros[i];
    }
    return soma/tamanho
}


this.variavel // variável declarada

//Eventos

<button onclick = "function()" > Botão </button> // clique
<div onmouseover = "function()"></div> // seta em cima
<div onmouseout = "function()"></div> // seta fora

window.addEventListener("load",add_eventos) // chama função após carregamento da janela

document.addEventListener("load",add_eventos) // chama função após carregamento do documento

teste.addEventListener("click",alerta) // chama evento de função sem parâmetros

// chama evento de função com parâmetros
teste.addEventListener("mouseover",function(event){ 
    cor(teste,'red')
})

// removendo evento
document.removeEventListener("tipoevento",função) // remove evento

setTimeout(função,intervalo) // Executa a função após o intervalo

setInterval(função,intervalo) // Executa a função em loop após o intervalo

clearInterval(setInterval(função,intervalo)) // Para a execução do intervalo

$('td[name ="tcol1"]')   // matches exactly 'tcol1'
$('td[name^="tcol"]' )   // matches those that begin with 'tcol'
$('td[name$="tcol"]' )   // matches those that end with 'tcol'
$('td[name*="tcol"]' )   // matches those that contain 'tcol'

//Eventos Jquery

    //$('#slotm0').removeAttr('name');
    //$('#slotm0').hide();
    //$('#slotm0').css('background', 'transparent');
    // var gold = $(".gold");
    // gold.html("GOLD "+9999);
    // $('#slotm0').css('background', 'rgb(116, 84, 42)');
    //$('#slotm0').removeAttr('id');





