<?php
include_once('../backend/conexao.php');

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Busca os dados do banco
$sql = 'SELECT SUM(idFeedback) AS NumAvaliações FROM Feedback';
$result = $conexao->query($sql);
$soma = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $soma = $row['NumAvaliações'];
    }
}
$sql = 'SELECT * FROM produto';
$result = $conexao->query($sql);
// Supondo que você já tenha uma conexão estabelecida com o MySQL via mysqli
while ($user_data = mysqli_fetch_assoc($result)) {
    $genero = $user_data['genero'];

    switch (trim($genero)) {
        case "M":
            $genero = "Masculino(a)";
            break;
        case "F":
            $genero = "Feminino(a)";
            break;
        case "U":
            $genero = "Unissex";
            break;
        default:
            $genero = ""; // Caso padrão se o valor não corresponder
            break;
    }
    echo ('<div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow">
    <a href="produto.php?id=' . $user_data['idProduto'] . '">
        <img class="p-8 rounded-t-lg" src="exibir_imagem.php?id=' . $user_data['idProduto'] . '" alt="Imagem do Produto"  style="max-height:500px"/>
    </a>
    <div class="px-5 pb-5">
        <a href="produto.php?id=' . $user_data['idProduto'] . '">
            <h5 class="text-xl font-semibold tracking-tight text-gray-900">' . $user_data['grupo'] . ' ' . $user_data['subGrupo'] . ' ' . $user_data['descricao'] . ' ' . $genero . '</h5>
        </a>
        <div class="flex items-center mt-2.5 mb-5">
            <div class="flex items-center space-x-1 rtl:space-x-reverse">
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded">' . ($soma > 0 ? '(' . $soma . ')' : '(0)') . '</span>
            <span class="bg-orange-100 text-orange-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-orange-200 dark:text-orange-800 ms-3">5.0</span>
        </div>
        <div class="flex items-center justify-between">           
            <span class="text-3xl font-bold text-gray-900">R$' . $user_data['valorProduto'] . '</span>
            <a href=""
                class="text-white bg-orange-700 transition-colors hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                <img src="../../public/assets/images/icons/cart.svg" alt="Carrinho" style="filter: invert(100%)">
            </a>
        </div>
    </div>
</div>
');
}
