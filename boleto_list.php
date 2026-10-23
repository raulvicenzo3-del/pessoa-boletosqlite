<?php
/*
 * Código de exemplo da utilização de PDO como persistencia
 * Página reponsável pela listagem da entidade Pessoa
 * @author Wesley R. Bezerra <wesley.bezerra@ifc.edu.br>
 * @version 0.1
 *
 */
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="ligth">
<?php include 'cabecalho.php'; ?>
<?php require_once 'boleto_acao.php'; ?>

<body>
    <main class="container">
        <?php include 'menu.php'; ?>
        <?php


        $dao = PDOBoletoDAO::getInstance();        
        $dados = array();
        $dados = $dao->listar();
        if (($dados == NULL) || (count($dados) == 0)) {
            echo "<div><span class='warning'>sem dados a serem exibidos</span></div>";
        }
        ?>
        <table role="grid">
            <tr>
                <th>Id</th>
                <th>Data de Vencimento</th>
                <th>Data de Pagamento</th>
                <th>Data de Emissão</th>
                <th>Valor</th>
                <th>Multa</th>
                <th>Juros</th>
                <th>Desconto</th>
                <th>Mora</th>
                <th>Valor Pago</th>
                <th>Alterar</th>
                <th>Excluir</th>
            </tr>
            <?php
            foreach ($dados as $key)
                echo "<tr><td>{$key['id']}</td>
                  <td>{$key['data_vencimento']}</td>
                  <td>{$key['data_pagamento']}</td>
                  <td>{$key['data_emissao']}</td>
                  <td>{$key['valor']}</td>
                  <td>{$key['multa']}</td>
                  <td>{$key['juros']}</td>
                  <td>{$key['desconto']}</td>
                  <td>{$key['mora']}</td>
                  <td>{$key['valor_pago']}</td>
                  <td align='center'><a role='button' href='boleto_cad.php?id=" . $key['id'] . "'>A</a></td>
                  <td align='center'><a role='button' href=javascript:excluirRegistro('boleto_acao.php?acao=excluir&id=" . $key['id'] . "');>E</a></td>
              </tr>";
            ?>
        </table>
    </main>
    <!-- funcao de confirmacacao em javascript para a exclusao-->
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
</body>

</html>