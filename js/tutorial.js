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

//throw new Error("Erro manual")


document.getElementById('id').style.color="#f00" //muda cor do texto

document.getElementById('id').style.fontSize="50px" //altera tamanho do texto

document.getElementById('id').style.display="none" //oculta elemento

document.getElementById('id').style.fontSize="50px" //altera tamanho do texto

document.getElementById('id').value // pega o valor de um elemento html pelo id

document.getElementById('id').innerHTML // pega todo o conteúdo dentro da tag html




