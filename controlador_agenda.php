<?php

    function cadastrar($nome){

        $contatosAuxiliar = file_get_contents('contatos.json');
        $contatosAuxiliar = json_decode($contatosAuxiliar, true);

        $contato = [
            'id'      => uniqid(),
            'nome'    => $nome,
            'email'   => $_POST['email'],
            'telefone'=> $_POST['telefone']
        ];

        array_push($contatosAuxiliar, $contato);

        $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);

        file_put_contents('contatos.json', $contatosJson);

        header("Location: index.phtml");
    }

    function pegarContatos(){
        $contatosAuxiliar = file_get_contents('contatos.json');
        $contatosAuxiliar = json_decode($contatosAuxiliar, true);

        return $contatosAuxiliar;
    }

    function excluirContato($id){

        $contatosAuxiliar = file_get_contents('contatos.json');
        $contatosAuxiliar = json_decode($contatosAuxiliar, true);

        foreach ($contatosAuxiliar as $posicao => $contato){
            if($id == $contato['id']) {
                unset($contatosAuxiliar[$posicao]);
            }
        }

        $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);
        file_put_contents('contatos.json', $contatosJson);

        header('Location: index.phtml');
    }

    function editarContato($id){

        $contatosAuxiliar = file_get_contents('contatos.json');
        $contatosAuxiliar = json_decode($contatosAuxiliar, true);

        foreach ($contatosAuxiliar as $contato){
            if ($contato['id'] == $id){
                return $contato;
            }
        }
    }

    function salvarContatoEditado($id){
        $contatosAuxiliar = file_get_contents('contatos.json');
        $contatosAuxiliar = json_decode($contatosAuxiliar, true);

        foreach ($contatosAuxiliar as $posicao => $contato){
            if ($contato['id'] == $id){

                $contatosAuxiliar[$posicao]['nome'] = $_POST['nome'];
                $contatosAuxiliar[$posicao]['email'] = $_POST['email'];
                $contatosAuxiliar[$posicao]['telefone'] = $_POST['telefone'];

                break;
            }
        }

        $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);
        file_put_contents('contatos.json', $contatosJson);

        header('Location: index.phtml');

    }

    //ROTAS
        if ($_GET['acao'] == 'cadastrar'){
            cadastrar($_POST['nome']);
        } elseif ($_GET['acao'] == 'excluir'){
            excluirContato($_GET['id']);
        }
