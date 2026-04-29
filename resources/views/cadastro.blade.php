<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Instagram API - Cadastro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-96 border border-gray-700">
        <h2 class="text-2xl font-bold mb-6 text-center text-green-400">Criar Conta</h2>

        <form id="formCadastro" class="space-y-4">
            <input type="text" id="nome" placeholder="Nome Completo" class="w-full p-2 rounded bg-gray-700 border border-gray-600 focus:border-green-500 outline-none text-white" required>
            <input type="email" id="email" placeholder="E-mail" class="w-full p-2 rounded bg-gray-700 border border-gray-600 focus:border-green-500 outline-none text-white" required>
            <input type="text" id="usuario_cad" placeholder="Nome de Usuário" class="w-full p-2 rounded bg-gray-700 border border-gray-600 focus:border-green-500 outline-none text-white" required>
            <input type="password" id="senha_cad" placeholder="Senha" class="w-full p-2 rounded bg-gray-700 border border-gray-600 focus:border-green-500 outline-none text-white" required>
            <textarea id="biografia" placeholder="Sua biografia..." class="w-full p-2 rounded bg-gray-700 border border-gray-600 h-24 focus:border-green-500 outline-none text-white"></textarea>

            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-gray-900 font-bold py-2 rounded transition shadow-lg">
                Cadastrar agora
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-400">
            Já tem conta? <a href="/login" class="text-green-400 hover:underline">Fazer Login</a>
        </p>
    </div>

    <script>
        document.getElementById('formCadastro').addEventListener('submit', async (e) => {
            e.preventDefault();

            const dados = {
                nome: document.getElementById('nome').value,
                email: document.getElementById('email').value,
                usuario: document.getElementById('usuario_cad').value,
                senha: document.getElementById('senha_cad').value,
                biografia: document.getElementById('biografia').value
            };

            try {
                const response = await fetch('/usuarios', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dados)
                });

                const result = await response.json();
                console.log("Resposta do Servidor:", result);

                if (response.ok || result.status === 'sucesso') {
                    alert('Cadastro realizado! Use seus dados para logar.');
                    window.location.href = '/login';
                } else {
                    const msg = result.mensagem || (result.errors ? 'Erro de validação' : 'Verifique os dados');
                    alert('Erro: ' + msg);
                }
            } catch (error) {
                console.error("Erro no Fetch:", error);
                alert('Erro ao conectar com o servidor.');
            }
        });
    </script>
</body>
</html>
