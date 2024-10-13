<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../src/styles/butterfly.css">
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/White_Butterfly.png">
    <title>Chrysalis - Sua Loja Preferida</title>

</head>

<body>
    <?php
    include("../headerAdmin.php");
    ?>
    <main>
        <div class="container m-auto sm:px-12">
            <h1 class="text-2xl font-semibold my-8">Editar Produtos</h1>

            <?php
            require('../../src/backend/conexao.php');

            if (isset($_GET['idProduto'])) {
                $idProduto = $_GET['idProduto'];
                $sqlSelect = "SELECT idProduto, valorProduto, descricao, grupo, subGrupo, genero, imagem FROM Produto WHERE idProduto = ?";
                $stmt = $conexao->prepare($sqlSelect);

                if ($stmt) {
                    $stmt->bind_param("i", $idProduto);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        ?>
                        <form action="update.php?idProduto=<?php echo $idProduto; ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-4">
                                <div class="mb-6">
                                    <label for="grupo">Grupo</label>
                                    <input type="text" name="grupo" id="grupo" placeholder="ex: Calça..."
                                        class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-md rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full px-2 py-1.5 hover:bg-white"
                                        value="<?php echo htmlspecialchars($row['grupo']); ?>" required>
                                </div>
                                <div class="mb-6">
                                    <label for="subgrupo">Subgrupo</label>
                                    <input type="subgrupo" name="subgrupo" id="subgrupo" placeholder="ex: Jeans..."
                                        class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-md rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full px-2 py-1.5 hover:bg-white"
                                        value="<?php echo htmlspecialchars($row['subGrupo']); ?>" required>
                                </div>
                                <div class="mb-4">
                                    <label for="preco">Preço</label>
                                    <input type="text" name="preco" id="preco" placeholder="ex: 197.90"
                                        class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-md rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full px-2 py-1.5 hover:bg-white"
                                        value="<?php echo htmlspecialchars($row['valorProduto']); ?>" required>
                                </div>
                                <div class="mb-6">
                                    <label for="nome">Cor e detalhes</label>
                                    <input type="text" name="nome" id="nome" placeholder="Azul, reta..."
                                        class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-md rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full px-2 py-1.5 hover:bg-white"
                                        value="<?php echo htmlspecialchars($row['descricao']); ?>" required>
                                </div>
                                <div class="mb-6">
                                <label for="genero">Gênero</label>
                                 <select id="genero" name="genero" class="border transition-all focus:scale-105 border-gray-300 text-gray-900 text-md rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full px-2 py-1.5 hover:bg-white" required>
                                     <option disabled selected>Escolha o Gênero</option>
                                     <option value="M">Masculino(a)</option>
        '                            <option value="F">Feminino(a)</option>
                                     <option value="U">Unissex</option>
                                  </select>   
                                </div>
                                <!-- Imagem -->
                                <div class="mb-6">
                                    <!-- Botão Escondido apenas para Funcionalidade -->
                                    <div class="mb-4">
                                        <input type="file" name="imagem" class="hidden" id="imagem" accept="image/*"
                                            onchange="mostrarNomeArquivo()">
                                        <label for="imagem"
                                            class="cursor-pointer border transition-colors border-gray-300 inline-block bg-transparent text-gray-800 hover:text-white hover:bg-orange-500 py-2 px-4 rounded-lg transition-all">
                                            Editar Imagem
                                        </label>
                                        <span id="file-name" class="ml-4 text-gray-700">Nenhum arquivo selecionado</span>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="transition px-8 py-2 text-md font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg text-center">Atualizar</button>
                        </form>
                    </div>
                    <?php
                    } else {
                        echo "Registro não encontrado.";
                    }

                    $stmt->close();
                } else {
                    die("Erro na preparação da query: " . $conexao->error);
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['idProduto'])) {
                $id = $_GET['idProduto'];
                $precoNovo = $_POST['preco'];
                $nomeNovo = $_POST['nome'];
                $grupoNovo = $_POST['grupo'];
                $subgrupoNovo = $_POST['subgrupo'];
                $generoNovo = $_POST['genero'];
            
                // Verifique se uma imagem foi enviada
                if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                    // Lê o conteúdo do arquivo da imagem
                    $imagemNovo = file_get_contents($_FILES['imagem']['tmp_name']);
                } else {
                    // Se nenhuma imagem foi enviada, mantenha a imagem antiga
                    $sqlSelectImagem = "SELECT imagem FROM Produto WHERE idProduto = ?";
                    $stmtImagem = $conexao->prepare($sqlSelectImagem);
                    $stmtImagem->bind_param("i", $id);
                    $stmtImagem->execute();
                    $resultImagem = $stmtImagem->get_result();
                    $rowImagem = $resultImagem->fetch_assoc();
                    $imagemNovo = $rowImagem['imagem'];
                    $stmtImagem->close();
                }
            
                // Atualize a query SQL para usar parâmetros binários para a imagem
                $sqlUpdate = "UPDATE Produto SET valorProduto = ?, descricao = ?, grupo = ?, subgrupo = ?, genero = ?, imagem = ? WHERE idProduto = ?";
            
                $stmt = $conexao->prepare($sqlUpdate);
            
                if ($stmt) {
                    $stmt->bind_param("ssssssi", $precoNovo, $nomeNovo, $grupoNovo, $subgrupoNovo, $generoNovo, $imagemNovo, $id);
            
                    if ($stmt->execute()) {
                        echo "<script>
                                alert('Dados alterados com sucesso!');
                                window.location.replace('read.php');
                              </script>";
                    } else {
                        die("ERRO NO UPDATE: " . $stmt->error);
                    }
                } else {
                    die("Erro na preparação da query: " . $conexao->error);
                }
            }
            
            ?>
    </main>
    <script>
        function mostrarNomeArquivo() {
            var input = document.getElementById('imagem');
            var nomeArquivo = input.files.length > 0 ? input.files[0].name : 'Nenhum arquivo selecionado';
            document.getElementById('file-name').textContent = nomeArquivo;
        }
    </script>
    <?php
    include('../../src/pages/footer.php');
    ?>
</body>

</html>