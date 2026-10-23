<?php
/*
 * Código de exemplo da utilização de PDO como persistencia
 * Classe abstrata para persistencia de Pessoa
 * @author Wesley R. Bezerra <wesley.bezerra@ifc.edu.br>
 * @version 0.1
 *
 */
include_once __DIR__ . "/BoletoDAO.php";
class PDOBoletoDAO extends BoletoDAO
{
    private static $instance = NULL;
    private $conn = NULL;
    function PDOBoletoDAO()
    {
        $this->connect();
    }

    public static function getInstance()
    {
        if (self::$instance == NULL)
            self::$instance = new PDOBoletoDAO();        
        return self::$instance;
    }

    /*
     * Método faz a conexao com o recurso usado
     * @return void
     */
    function connect()
    {
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
        }
    
    }
    /*
     * Método que insere dados no sistema de persistencia
     * @param $objeto Pessoa objeto que será inserido 
     * @return void
     */
    function inserir($objeto)
    {
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conn->prepare('INSERT INTO boleto (data_vencimento, data_pagamento, data_emissao, valor, multa, juros, desconto, mora, valor_pago) 
                 VALUES(:data_vencimento, :data_pagamento, :data_emissao, :valor, :multa, :juros, :desconto, :mora, :valor_pago)');
            $stmt->execute(
                array(
                    ':data_vencimento' => $objeto->data_vencimento,
                    ':data_pagamento' => $objeto->data_pagamento,
                    ':data_emissao' => $objeto->data_emissao,
                    ':valor' => $objeto->valor,
                    ':multa' => $objeto->multa,
                    ':juros' => $objeto->juros,
                    ':desconto' => $objeto->desconto,
                    ':mora' => $objeto->mora,
                    ':valor_pago' => $objeto->valor_pago
                )
            );
            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }

    }
    /*
                    ':peso' => $objeto->peso
                )
            );
            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }

    }
    /*
     * Método que altera dados no sistema de persistencia
     * @param $objeto Pessoa objeto que será inserido 
     * @return void
     */
    function alterar($objeto)
    {
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conn->prepare('UPDATE boleto SET data_vencimento=:data_vencimento, data_pagamento=:data_pagamento, data_emissao=:data_emissao, valor=:valor, multa=:multa, juros=:juros, desconto=:desconto, mora=:mora, valor_pago=:valor_pago 
                  WHERE id=:id');
            $stmt->execute(
                array(
                    ':data_vencimento' => $objeto->data_vencimento,
                    ':data_pagamento' => $objeto->data_pagamento,
                    ':data_emissao' => $objeto->data_emissao,
                    ':valor' => $objeto->valor,
                    ':multa' => $objeto->multa,
                    ':juros' => $objeto->juros,
                    ':desconto' => $objeto->desconto,
                    ':mora' => $objeto->mora,
                    ':valor_pago' => $objeto->valor_pago,
                    ':id' => $objeto->id
                )
            );
            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }
    }
    /*
                    ':peso' => $objeto->peso,
                    ':id' => $objeto->id
                )
            );
            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }
    }
    /*
     * Método que exclui dados no sistema de persistencia
     * @param $id int identificador do registro 
     * @return void
     */
    function excluir($id)
    {
        try {      
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conn->prepare('DELETE FROM boleto WHERE id=:id');
            $stmt->execute(
                array(
                    ':id' => $id
                )
            );
            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }

    }
    /*
     * Método que lista dados no sistema de persistencia
     * @return array array de dados
     */
    function listar()
    {
        $dados = array();
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $result = $this->conn->query("SELECT * FROM boleto");

            while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                $boleto = array();
                $boleto['id'] = $linha['id'];
                $boleto['data_vencimento'] = $linha['data_vencimento'];
                $boleto['data_pagamento'] = $linha['data_pagamento'];
                $boleto['data_emissao'] = $linha['data_emissao'];
                $boleto['valor'] = $linha['valor'];
                $boleto['multa'] = $linha['multa'];
                $boleto['juros'] = $linha['juros'];
                $boleto['desconto'] = $linha['desconto'];
                $boleto['mora'] = $linha['mora'];
                $boleto['valor_pago'] = $linha['valor_pago'];
                array_push($dados, $boleto);
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        return $dados;

    }
    /* Método que lista dados com filtro no sistema de persistencia
     * @param $filtro String filtro para dados     
     * @return array array de dados
     */
    function listar_filtro($filtro)
    {
        $dados = array();
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $result = $this->conn->query("SELECT * FROM boleto " . $filtro);

            while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                $boleto = array();
                $boleto['id'] = $linha['id'];
                $boleto['data_vencimento'] = $linha['data_vencimento'];
                $boleto['data_pagamento'] = $linha['data_pagamento'];
                $boleto['data_emissao'] = $linha['data_emissao'];
                $boleto['valor'] = $linha['valor'];
                $boleto['multa'] = $linha['multa'];
                $boleto['juros'] = $linha['juros'];
                $boleto['desconto'] = $linha['desconto'];
                $boleto['mora'] = $linha['mora'];
                $boleto['valor_pago'] = $linha['valor_pago'];
                array_push($dados, $boleto);
            }
        


        return $dados;
            
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }


        return $dados;

    }
    /*
     * Método que obtem dados no sistema de persistencia
     * @param $id int identificador do registro 
     * @return array objeto em array
     */
    function obter($id)
    {
        $boleto = array();
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $result = $this->conn->query("SELECT * FROM boleto WHERE id=?");
            $result->execute([$id]);

            if ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                $boleto['id'] = $linha['id'];
                $boleto['data_vencimento'] = $linha['data_vencimento'];
                $boleto['data_pagamento'] = $linha['data_pagamento'];
                $boleto['data_emissao'] = $linha['data_emissao'];
                $boleto['valor'] = $linha['valor'];
                $boleto['multa'] = $linha['multa'];
                $boleto['juros'] = $linha['juros'];
                $boleto['desconto'] = $linha['desconto'];
                $boleto['mora'] = $linha['mora'];
                $boleto['valor_pago'] = $linha['valor_pago'];
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        return $boleto;
    }
}
?>