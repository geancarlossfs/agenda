<?php
//a função cadastrar vai pegar os dados do formulario
function cadastrar($nome, $email, $telefone){
    $contatosAuxiliar = pegarContatos();//a variavel recebe os dados enviados pelo formulario

    $contato = [
        'id'      => uniqid(),//a funçao uniquid() vai gerar uma ID aleatória para cada pessoa cadastrada
        'nome'    => $nome,
        'email'   => $email,
        'telefone'=> $telefone
    ];

    array_push($contatosAuxiliar, $contato);//ele incrementa um novo item ao array

    converterJson($contatosAuxiliar);
    enviar_header();//vai direcionar os dados para a página inicial

}

function pegarContatos(){//ele pega os dados e le os arquivos json e transforma em um array
    $contatosAuxiliar = file_get_contents('contatos.json');
    $contatosAuxiliar = json_decode($contatosAuxiliar, true);

    return $contatosAuxiliar;
}

function excluirContato($id){//a função sera ira pegar o contato pela sua id e excluir ela para não ser mais exibida
    $contatosAuxiliar=pegarContatos();

    foreach ($contatosAuxiliar as $posicao => $contato){
        if($id == $contato['id']) {//se o id procurado for igual ao contato selecionado
            unset($contatosAuxiliar[$posicao]);//ele sera excluido pelo unset
        }
    }


    converterJson($contatosAuxiliar);
    enviar_header();

}

function buscarContatoParaEditar($id){
    $contatosAuxiliar=pegarContatos();

    foreach ($contatosAuxiliar as $contato){
        if ($contato['id'] == $id){
            return $contato;
        }
    }
}

function salvarContatoEditado($id, $nome, $email, $telefone){
    $contatosAuxiliar=pegarContatos();

    foreach ($contatosAuxiliar as $posicao => $contato){
        if ($contato['id'] == $id){

            $contatosAuxiliar[$posicao]['nome']     = $nome;
            $contatosAuxiliar[$posicao]['email']    = $email;
            $contatosAuxiliar[$posicao]['telefone'] = $telefone;

            break;
        }
    }

    converterJson($contatosAuxiliar);
    enviar_header();

    return $contatosJson;
}

function enviar_header(){
    header('Location: index.phtml');
}

function buscarContato($nome){

    $contatos = pegarContatos();//Pego os contatos;

    $contatosEncontrados = [];//a variavel vai receber um espaço vazio para ser preenchido logo após ser requerido

    foreach ($contatos as $contato){//Para cada contatoAuxiliar como contato

        if ($contato['nome'] == $nome){//Se e o id do contato é o mesmo que estou procurando

            $contatosEncontrados[] = $contato;//retorna o contato com seus dados;
        }
    }

    return $contatosEncontrados;
}

function converterJson($contatosAuxiliar){
    $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);//o arquivo Json é convertido em um array
    file_put_contents('contatos.json', $contatosJson);//salva os dados em um arquivo em .JSON
}
//Rotas
switch($_GET['acao']){
    case "editar":
        salvarContatoEditado($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['telefone']);
        break;

    case "cadastrar":
        cadastrar($_POST['nome'], $_POST['email'], $_POST['telefone']);
        break;

    case "excluir":
        excluirContato($_GET['id']);
        break;

}