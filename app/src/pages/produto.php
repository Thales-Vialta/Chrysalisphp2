<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade para dispositivos móveis -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- Inclui o TailwindCSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" /> <!-- Inclui Flowbite para componentes UI -->
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png"> <!-- Define o ícone da aba do navegador -->
    <title>Chrysalis - Produto</title> <!-- Título da página -->
</head>

<body class="bg-white text-gray-900"> <!-- Define a cor de fundo e a cor do texto padrão -->

    <?php
    include("header.php"); // Inclui o cabeçalho do site
    include("../backend/conexao.php"); // Conecta ao banco de dados

    // Verifica se o ID do produto foi passado na URL
    if (isset($_GET['id'])) {
        $idProduto = $_GET['id']; // Pega o ID do produto da URL

        // Prepara a consulta SQL para buscar os detalhes do produto
        $sql = "SELECT idProduto, valorProduto, descricao, grupo, subGrupo, genero, imagem FROM Produto WHERE idProduto = ?";
        $stmt = $conexao->prepare($sql); // Prepara a query para evitar SQL Injection
        $stmt->bind_param("i", $idProduto); // Liga o parâmetro $idProduto à query
        $stmt->execute(); // Executa a consulta
        $stmt->bind_result($idProduto, $valorProduto, $descricao, $grupo, $subgrupo, $genero, $imagem); // Associa os resultados aos respectivos campos
        $stmt->fetch(); // Busca os resultados
        $stmt->close(); // Fecha a declaração

        // Prepara a consulta para contar o número de avaliações do produto
        $sql = "SELECT count(idFeedback) FROM Feedback WHERE idProduto = ?";
        $stmt = $conexao->prepare($sql); // Prepara a query
        $stmt->bind_param("i", $idProduto); // Liga o parâmetro $idProduto
        $stmt->execute(); // Executa a consulta
        $stmt->bind_result($numeroAvaliacoes); // Associa o número de avaliações ao resultado
        $stmt->fetch(); // Busca o número de avaliações
        $stmt->close(); // Fecha a declaração
    } else {
        echo "<p>Produto não encontrado.</p>"; // Mensagem de erro caso o produto não seja encontrado
        exit; // Interrompe a execução do script
    }
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

    ?>


    <section class="flex items-center justify-center min-h-screen"> <!-- Seção centralizada ocupando a altura mínima da tela -->
        <div class="container mx-auto p-6"> <!-- Container centralizado com espaçamento -->
            <div class="flex flex-col items-center justify-center md:flex-row md:justify-center md:space-x-12 gap-8 mb-8"> <!-- Estrutura flexível para a imagem e os detalhes do produto -->

                <!-- Exibe a imagem do produto ou um placeholder caso não haja imagem -->
                <?php
                if ($imagem) {
                    // Exibe a imagem codificada em Base64
                    echo '<img class="w-5/6 m-4 rounded-lg object-contain" src="data:image/png;base64,' . base64_encode($imagem) . '" alt="' . $grupo . ' ' . $subgrupo . ' ' . $descricao . ' ' . $genero . '" style="height:500px; width: 500px;">';
                } else {
                    // Exibe uma imagem padrão caso não tenha imagem no banco
                    echo '<img class="w-5/6 m-4 rounded-lg object-contain" src="https://via.placeholder.com/500" alt="Imagem não disponível" style="height:500px; width: 500px;">';
                }
                ?>

                <!-- Detalhes do produto -->
                <div class="md:w-1/2 mt-6 md:mt-0"> <!-- Define a largura do texto e ajustes de margens para diferentes telas -->
                    <h1 class="text-3xl font-bold text-start md:text-left"><?php echo $descricao . ' ' . $grupo . ' ' . $subgrupo . ' ' . $genero; ?></h1> <!-- Título do produto -->
                    <span class="text-zinc-400 text-lg mt-4 text-start md:text-left flex items-center justify-start"> <!-- Texto com ícone de estrela e número de avaliações -->
                        <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        &nbsp; <?php echo $numeroAvaliacoes; ?> Avaliações <!-- Exibe o número de avaliações recuperado do banco de dados -->
                    </span>
                    <p class="text-4xl font-bold mt-4 text-start md:text-left">R$ <?php echo number_format($valorProduto, 2, ',', '.'); ?></p> <!-- Preço do produto formatado para o formato brasileiro -->
                    <!-- Botão para adicionar ao carrinho -->
                    <div class="mt-6">
                        <button class="w-full py-4 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-500 transition-all duration-300">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>

<!-- Seção de Adicionar Avaliação -->
<div class="mt-12 mb-8">
    <h2 class="text-2xl font-bold text-center">Adicionar Avaliação</h2>
    <form action="produto.php?id=<?php echo $idProduto; ?>" method="POST" class="flex flex-col items-center space-y-4 mt-4">
        <!-- Botões de avaliação por estrelas -->
        <div class="flex space-x-1">
            <input type="hidden" name="avaliacao" id="avaliacao" value="0">
            <button type="button" onclick="avaliarPorEstrelas(1)">⭐</button>
            <button type="button" onclick="avaliarPorEstrelas(2)">⭐</button>
            <button type="button" onclick="avaliarPorEstrelas(3)">⭐</button>
            <button type="button" onclick="avaliarPorEstrelas(4)">⭐</button>
            <button type="button" onclick="avaliarPorEstrelas(5)">⭐</button>
        </div>

        <!-- Caixa de texto para comentário -->
        <textarea class="w-full md:w-1/2 p-4 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500"
            name="comentario" placeholder="Adicione um comentário (opcional)"></textarea>

        <!-- Botão de enviar avaliação -->
        <button type="submit" name="enviarAvaliacao"
            class="py-2 px-6 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-500 transition-all duration-300">Enviar Avaliação</button>
    </form>
</div>
            <!-- Seção de comentários -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-center">Comentários</h2> <!-- Título da seção de comentários -->

                <!-- Botões para filtrar avaliações por estrelas -->
                <div class="flex justify-center space-x-2 mt-4">
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">Todas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">5 Estrelas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">4 Estrelas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">3 Estrelas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">2 Estrelas</button>
                    <button class="py-2 px-4 bg-gray-200 rounded-lg hover:bg-gray-300">1 Estrela</button>
                </div>

                <!-- Exemplos de comentários, que podem ser gerados dinamicamente -->
                <div class="mt-6">
                    <div class="p-4 border-b border-gray-300"> <!-- Estrutura de comentário -->
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-bold">Cliente Exemplo</h3> <!-- Nome do cliente -->
                                <p class="text-sm text-gray-500">Publicado em 24/09/2024</p> <!-- Data da publicação -->
                            </div>
                            <div class="flex">
                                <span class="text-orange-500">⭐️⭐️⭐️⭐️⭐️</span> <!-- Exibe estrelas de avaliação -->
                            </div>
                        </div>
                        <p class="mt-2 text-gray-700">Produto excelente! Chegou rápido e a qualidade é ótima. Recomendo!</p> <!-- Comentário do cliente -->
                    </div>

                    <div class="p-4 border-b border-gray-300"> <!-- Estrutura de outro comentário -->
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-bold">Outro Cliente</h3> <!-- Nome do cliente -->
                                <p class="text-sm text-gray-500">Publicado em 20/09/2024</p> <!-- Data da publicação -->
                            </div>
                            <div class="flex">
                                <span class="text-orange-500">⭐️⭐️⭐️⭐️</span> <!-- Exibe estrelas de avaliação -->
                            </div>
                        </div>
                        <p class="mt-2 text-gray-700">Bom produto, mas demorou um pouco para chegar.</p> <!-- Comentário do cliente -->
                    </div>
                </div>
            </div>
    </section>
    <?php include("footer.php"); ?> <!-- Inclui o rodapé do site -->
    <script>
function avaliarPorEstrelas(value) {
    document.getElementById('avaliacao').value = value;
}
</script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script> <!-- Script do Flowbite -->
</body>

</html>