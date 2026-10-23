<?php

/*
 * Código de exemplo da utilização de PDO como persistencia
 * Controlador reponsável pela manutenção do cadastro da entidade Pessoa
 * @author Wesley R. Bezerra <wesley.bezerra@ifc.edu.br>
 * @version 0.1
 *
 */
require_once "boleto.php";
require_once "persistencia/PDOBoletoDAO.php";
/* definição de constantes */
define("DESTINO", "boleto_list.php");
define("ARQUIVO_XML", "boleto.xml");

/* escolha da ação que processará a requisição */
$acao = "";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
        break;
    case 'POST':
        $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
        break;
}

switch ($acao) {
    case 'Salvar':
        salvar();
        break;
    case 'Alterar':
        alterar();
        break;
    case 'excluir':
        excluir();
        break;
}

/*
 * Método que converte formulário html para array com respectivos dados
 * @return array
 */
function tela2array()
{
    $novo =  array(
        'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
        'data_vencimento' => isset($_POST['data_vencimento']) ? $_POST['data_vencimento'] : "",
        'data_pagamento' => isset($_POST['data_pagamento']) ? $_POST['data_pagamento'] : "",
        'data_emissao' => isset($_POST['data_emissao']) ? $_POST['data_emissao'] : "",
        'valor' => isset($_POST['valor']) ? $_POST['valor'] : "",
        'multa' => isset($_POST['multa']) ? $_POST['multa'] : "",
        'juros' => isset($_POST['juros']) ? $_POST['juros'] : "",
        'desconto' => isset($_POST['desconto']) ? $_POST['desconto'] : "",
        'mora' => isset($_POST['mora']) ? $_POST['mora'] : "",
        'valor_pago' => isset($_POST['valor_pago']) ? $_POST['valor_pago'] : ""
    );
    if ($novo['id'] == "0") {
        $novo['id'] = date("YmdHis");
    }
    return $novo;
}

/*
 * Método que converte array para objeto
 * @return String json
 */
function array2objeto($array_dados)
{
    $elemento = new Boleto();

    $elemento->id = $array_dados['id'];
    $elemento->data_vencimento = $array_dados['data_vencimento'];
    $elemento->data_pagamento = $array_dados['data_pagamento'];
    $elemento->data_emissao = $array_dados['data_emissao'];
    $elemento->valor = $array_dados['valor'];
    $elemento->multa = $array_dados['multa'];
    $elemento->juros = $array_dados['juros'];
    $elemento->desconto = $array_dados['desconto'];
    $elemento->mora = $array_dados['mora'];
    $elemento->valor_pago = $array_dados['valor_pago'];

    return $elemento;
}


/*
 * Método que converte array para objeto
 * @return String array
 */
function objeto2array($elemento)
{
    $dado = array(
        'id' => (string) $elemento->id,
        'data_vencimento' => (string) $elemento->data_vencimento,
        'data_pagamento' => (string) $elemento->data_pagamento,
        'data_emissao' => (string) $elemento->data_emissao,
        'valor' => (string) $elemento->valor,
        'multa' => (string) $elemento->multa,
        'juros' => (string) $elemento->juros,
        'desconto' => (string) $elemento->desconto,
        'mora' => (string) $elemento->mora,
        'valor_pago' => (string) $elemento->valor_pago
    );

    return $dado;
}

/*
 * Método que lê os dados e os carrega em um variável chamada json
 * @param $id int identificador numérico do registro
 * @return String dados codificados no formato json
 */
function carregar($id)
{
    $dao = PDOBoletoDAO::getInstance();
    $dados = $dao->obter($id);
    return $dados;
}

/*
 * Método que altera os dados de um registro
 * @return void
 */
function alterar() //todo: ainda nao funciona
{
    $novo = tela2array();

    $dao = PDOBoletoDAO::getInstance();
    $objeto = array2objeto($novo);
    $dados = $dao->alterar($objeto);


    header("location:" . DESTINO);


}


/*
1 - abrir json em formato php;
2 - percorrer e achar o item pelo ID;
3 - estratégia de deletar;
4 - gravar em json novamente, sem o item;
5 - redirecionar para a página index.php
*/

/*
 * Método exclui um registro
 * @return void
 */
function excluir()
{
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $dao = PDOBoletoDAO::getInstance();
    $dados = $dao->excluir($id);

    header("location:" . DESTINO);

}
/*
 * Método salva alterações feitas em um registro
 * @return void
 */
function salvar()
{
    $xml = NULL;
    $novo = tela2array();

    $dao = PDOBoletoDAO::getInstance();
    $objeto = array2objeto($novo);
    $dados = $dao->inserir($objeto);

    header("location:" . DESTINO);
}

?>