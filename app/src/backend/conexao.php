<?php
$servidor = "localhost";
$username = "root";
$senha = ""; //se tiver senha, só colocar aqui

$conexao = new mysqli($servidor, $username, $senha);

if ($conexao->connect_error) {
    die("Erro ao realizar a conexão: " . $conexao->connect_error);
}

//criando a database, caso não tenha sido criada ainda
$conexao->query("CREATE DATABASE IF NOT EXISTS BancoChrysalis ");

//selecionando a database
$conexao->select_db("BancoChrysalis");

//criando as tabelas caso não tenham sido criadas ainda

$conexao->query("CREATE TABLE IF NOT EXISTS Endereco (
    cep VARCHAR(9) PRIMARY KEY NOT NULL,
    rua VARCHAR(200) NOT NULL,
    bairro VARCHAR(200) NOT NULL,
    estado CHAR(2) NOT NULL,  
    cidade VARCHAR(200) NOT NULL
    )");

$conexao->query("CREATE TABLE IF NOT EXISTS Pessoa (
    idPessoa INT AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(14) NOT NULL,
    numResidencia VARCHAR(20) NOT NULL,
    numTelefone VARCHAR(30) NOT NULL,
    nome VARCHAR(200) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    email VARCHAR(200) NOT NULL,
    dataNascimento DATE NOT NULL,
    sexo CHAR(1) NOT NULL,
    FOREIGN KEY (cep) REFERENCES Endereco(cep)
    )");

// $conexao->query("CREATE TABLE IF NOT EXISTS Administrador (
//     idAdmin INT AUTO_INCREMENT PRIMARY KEY,
//     loginAdmin VARCHAR(200) NOT NULL,
//     senha VARCHAR(255) NOT NULL,
//     idPessoa INT,
//     FOREIGN KEY (idPessoa) REFERENCES Pessoa(idPessoa)
//     )");

$conexao->query("CREATE TABLE IF NOT EXISTS Usuario (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    loginUsuario VARCHAR(200) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    idPessoa INT,
    FOREIGN KEY (idPessoa) REFERENCES Pessoa(idPessoa)
    )");

$conexao->query("CREATE TABLE IF NOT EXISTS Produto (
    idProduto INT AUTO_INCREMENT PRIMARY KEY,
    valorProduto REAL NOT NULL,
    descricao TEXT NOT NULL,
    grupo TEXT NOT NULL,
    subGrupo TEXT NOT NULL,
    genero CHAR NOT NULL,
    imagem MEDIUMBLOB NOT NULL
    )");

$conexao->query("CREATE TABLE IF NOT EXISTS Carrinho (
    idCarrinho INT AUTO_INCREMENT PRIMARY KEY,
    tamanhoCarrinho INT NOT NULL,
    idUsuario INT,
    valorCarrinho REAL NOT NULL,
    FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario)
    )");

$conexao->query("CREATE TABLE IF NOT EXISTS CarrinhoXProduto(
    idCarrinho INT,
    idProduto INT,
    FOREIGN KEY (idCarrinho) REFERENCES Carrinho(idCarrinho),
    FOREIGN KEY (idProduto) REFERENCES Produto(idProduto)
    )");

$conexao->query("CREATE TABLE IF NOT EXISTS Tamanho (
    idTamanho INT AUTO_INCREMENT PRIMARY KEY,
    unidadeMedida VARCHAR(200) NOT NULL, 
    tamanho INT NOT NULL
    )");

$conexao->query("CREATE TABLE IF NOT EXISTS ProdutoXTamanho(
    idTamanho INT,
    idProduto INT,
    FOREIGN KEY (idTamanho) REFERENCES Tamanho(idTamanho),
    FOREIGN KEY (idProduto) REFERENCES Produto(idProduto)
    )");

//_Todo elemento que possui AUTO_INCREMENT deve possuir, consequentemente, PRIMARY KEY
$conexao->query("CREATE TABLE IF NOT EXISTS Feedback(
    idFeedback INT AUTO_INCREMENT PRIMARY KEY,
    nota INT NOT NULL,
    descricaoFeedback TEXT,
    idUsuario INT,
    idProduto INT,
    FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario),
    FOREIGN KEY (idProduto) REFERENCES Produto(idProduto)
    )");

//Criando perfil de usuário administrador
// Cria a senha criptografada
$senhaAdmin = password_hash('adminadmin123123', PASSWORD_BCRYPT);

// Insere os dados no banco de dados
$conexao->query("INSERT IGNORE INTO Endereco VALUES ('00000001','Rua Administrador Chrysalis','Chrysalis','SP','Caçapava');");
$conexao->query("INSERT IGNORE INTO Pessoa VALUES (1,'00000000001','00000000000000000001','12999999999','Administrador','00000001','administradorchrysalis@gmail.com','2000/01/01','M');");
$conexao->query("INSERT IGNORE INTO Usuario VALUES (1,'administradorchrysalis@gmail.com','$senhaAdmin',1);");
