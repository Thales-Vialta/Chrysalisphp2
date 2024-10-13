<head>
    <link rel="stylesheet" href="../styles/butterfly.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<?php
include_once('../backend/conexao.php');
if (!isset($_SESSION)) {
    session_start();
}
?>
<header class="bg-orange-400">
    <nav class="border-gray-200 bg-orange-400">
        <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3">
                <a href="index.php" class="flex items-center space-x-3 transition-all">
                    <img id="butterfly_img" src="../../public/assets/images/White_Butterfly.png" class="h-8"
                         alt="Chrysalis Logo Borboleta" />
                    <img src="../../public/assets/images/White_Chrysalis.png" class="h-8  hidden md:visible sm:visible" alt="Chrysalis Logo Texto" />
                </a>
            </div>

            <!-- Menu Button for Small Screens -->
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-700 rounded-lg md:hidden hover:bg-gray-100 focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>

            <!-- Menu Section -->
            <div class="hidden md:flex md:items-center md:space-x-8" id="navbar-default">
                <a href="index.php" class="text-white hover:underline hover:scale-125 transition-all">Início</a>
                <a href="about.php" class="text-white hover:underline hover:scale-125 transition-all">Sobre</a>
                <a href="#" class="block">
                    <img src="../../public/assets/images/icons/cart.svg" alt="Carrinho" class="w-6 h-6" style="filter: invert(100%)">
                </a>
                <img class="w-6 h-6 cursor-pointer hover:scale-125 transition-all" src="../../public/assets/images/icons/account.svg" alt="Perfil" style="filter: invert(100%)" onclick="toggleModal()">
            </div>
        </div>

        <!-- Menu for Small Screens -->
        <div class="hidden" id="navbar-small">
            <ul class="flex flex-col items-center space-y-4 p-4 bg-orange-400 md:hidden">
                <li><a href="index.php" class="text-white hover:underline transition-all">Início</a></li>
                <li><a href="about.php" class="text-white hover:underline transition-all">Sobre</a></li>
                <li><a href="#"><img src="../../public/assets/images/icons/cart.svg" alt="Carrinho" class="w-6 h-6" style="filter: invert(100%)"></a></li>
                <li><img src="../../public/assets/images/icons/account.svg" alt="Perfil" class="w-6 h-6 cursor-pointer" style="filter: invert(100%)" onclick="toggleModal()"></li>
            </ul>
        </div>
    </nav>
</header>

<script>
    // Alterna o menu de navegação para pequenas telas
    const burgerButton = document.querySelector('[data-collapse-toggle="navbar-default"]');
    const navbarSmall = document.getElementById('navbar-small');

    burgerButton.addEventListener('click', () => {
        navbarSmall.classList.toggle('hidden');
    });

    function toggleModal() {
        const modal = document.getElementById("userModal");
        modal.classList.toggle("hidden");
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
