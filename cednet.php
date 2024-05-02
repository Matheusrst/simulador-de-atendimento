<?php

class cliente
{//requesitos do cliente
    public $nome;
    public $cpf;
    public $idade;
    public $endereco;
    public $plano;
    public $velocidade;
    public $ativo;
    public $manutencoes = [

    ];
    public $contatos = [

    ];
//construct do cliente
    public function __construct(
        $nome, $cpf, $idade, $endereco, $velocidade = 0, $plano = null
    ) {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->idade = $idade;
        $this->endereco = $endereco;
        $this->plano = $plano;
        $this->velocidade = $velocidade;
        $this->ativo = true;
    }

    public function _set($name, $value)
    {
        $this->$name = $value;
    }
}

class cednet
{//requesitos da cednet
    public $name;
    public $cnpj;
    public $endereco;
//construct da cednet 
    public function __construct(
        $name, $cnpj, $endereco,
    ) {
        $this->name = $name;
        $this->endereco = $endereco;
        $this->cnpj = $cnpj;
    }
//função de nome
    public function _get($name)
    {
        return $this->$name;
    }
//função de contratação
    public function contratacao(cliente $cliente, $velocidade, $plano): cliente
    {
        $cliente->plano = $plano;
        $cliente->velocidade = $velocidade;
        return $cliente;
    }
//função de dowgrade
    public function downgrade(cliente $cliente, $velocidade, $plano): cliente
    {
        if ($velocidade >= $cliente->velocidade) {
            echo "A valor de velocidade para downgrade, tem que ser menor que o valor atual.";
            exit(0);
        }

        $cliente->plano = $plano;
        $cliente->velocidade = $velocidade;
        return $cliente;
    }
//função de upgrade
    public function upgrade(cliente $cliente, $velocidade, $plano): cliente
    {
        if ($velocidade <= $cliente->velocidade) {
            echo "A valor de velocidade para upgrade, tem que ser maior que o valor atual.";
            exit(0);
        }

        $cliente->plano = $plano;
        $cliente->velocidade = $velocidade;
        return $cliente;
    }
//função de agendamento
    public function agendamento(cliente $cliente, array $manutencao): cliente
    {
        if (!$cliente->ativo) {
            return $cliente;
        }

        $anteriores = $cliente->manutencoes;
        array_push($anteriores, $manutencao);

        $cliente->manutencoes = $anteriores;

        return $cliente;
    }
//função de cancelamento
    public function cancelamento(cliente $cliente): cliente
    {
        $cliente->ativo = false;
        echo "A linha foi cancelada";
        return $cliente;
    }
//função de contato
    public function contato(cliente $cliente, array $contatos): cliente
    {
        if (!$cliente->ativo) {
            return $cliente;
        }

        $anteriores = $cliente->contatos;

        array_push($anteriores, $contatos);

        $cliente->contatos = $anteriores;

        return $cliente;
    }

}

//dados cliente 1
$cliente1 = new cliente("josé", '25562847682', '22', 'rua geraldo bom fim');

//dados cliente 2
$cliente2 = new Cliente("godolfredo", '47623869542', '48', 'rua cristovon colombo');

//dados cliente 3
$cliente3 = new Cliente("adalberto", '15886347632', '51', 'rua antonio neves');

//dados cednet
$cednet = new cednet("CedNet", "08.752.674/0001-54", "rua acacia");

//contratação do cliente 1
$cliente1 = $cednet->contratacao($cliente1, 200, "200 MB");
//contratação do cliente 2
$cliente2 = $cednet->contratacao($cliente2, 200, "200 MB");
//contratação do cliente 3
$cliente3 = $cednet->contratacao($cliente3, 200, "200 MB");

//print dados cednet
print_r($cednet);

//print dados cliente 1
print_r($cliente1);

//print dados cliente 2
print_r($cliente2);

//print dados cliente 2
print_r($cliente3);

//contato cliente 1
$cliente1 = $cednet->contato($cliente1, ['contato' => "149856347585", "tipo" => "whatsapp"]);

print_r($cliente1);
 
//contato cliente 2
$cliente2 = $cednet->contato($cliente2, ['contato' => "149856347585", "tipo" => "whatsapp"]);

print_r($cliente2);

//contato cliente 3
$cliente3 = $cednet->contato($cliente3, ['contato' => "149856347585", "tipo" => "whatsapp"]);

print_r($cliente3);

//agendamento cliente 1
$cliente1 = $cednet->agendamento($cliente1, ['mensagem' => "Cliente sem conexão", "tipo" => "Sem conexão"]);

print_r($cliente1);

//agendamento cliente 2
$cliente2 = $cednet->agendamento($cliente2, ['mensagem' => "Cliente com a conexão lenta.", "tipo" => "Conexão Lenta"]);

print_r($cliente2);

//cacelamento cliente 1

$cliente1 = $cednet->cancelamento($cliente1, ['A linha foi cancelada']);
echo "\n";
print_r($cliente1);
//agendamento cliente 2
$cliente2 = $cednet->agendamento($cliente2, ['mensagem' => "Cliente com a conexão lenta.", "tipo" => "Conexão Lenta"]);

print_r($cliente2);

//dowgrade cliente 3
$cliente3 = $cednet->downgrade($cliente3, 100, "100 MB");

print_r($cliente3);

//upgrade cliente 2
$cliente3 = $cednet->upgrade($cliente3, 300, "300 MB");

print_r($cliente3);

