<?php
    //a função cadastrar vai pegar os dados do formulario
    function cadastrar($nome, $email, $telefone){
     $contatosAuxiliar = pegarContatos();//a variavel recebe os dados enviados pelo formulario

        $contato = [
            'id'      => uniqid(),
            'nome'    => $nome,
            'email'   => $email,
            'telefone'=> $telefone
        ];

        array_push($contatosAuxiliar, $contato);//ele incrementa um novo item ao array
        $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);//o arquivo Json é convertido em um array
        file_put_contents('contatos.json', $contatosJson);//salva os dados em um arquivo em .JSON

        enviar_header();//vai direcionar os dados para a página inicial

    }

    function pegarContatos(){//ele pega os dados e le os arquivos json e transforma em um array
        $contatosAuxiliar = file_get_contents('contatos.json');
        $contatosAuxiliar = json_decode($contatosAuxiliar, true);

        return $contatosAuxiliar;
    }

    function excluirContato($id){
        $contatosAuxiliar=pegarContatos();

        foreach ($contatosAuxiliar as $posicao => $contato){
            if($id == $contato['id']) {
                unset($contatosAuxiliar[$posicao]);
            }
        }

        $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);
        file_put_contents('contatos.json', $contatosJson);

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

        enviar_header();


        $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);
        file_put_contents('contatos.json', $contatosJson);


        return $contatosJson;
    }

    function enviar_header(){
        header('Location: index.phtml');
    }

//    function modificaDados(){
//        $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);
//        file_put_contents('contatos.json', $contatosJson);
//    }

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