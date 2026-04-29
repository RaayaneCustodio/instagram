<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Instagram API - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-96 border border-gray-700">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-400">Entrar no Sistema</h2>

        <form id="formLogin" class="space-y-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Usuário</label>
                <input type="text" id="usuario" class="w-full p-2 rounded bg-gray-700 border border-gray-600 focus:border-blue-500 outline-none text-white" required>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Senha</label>
                <input type="password" id="senha" class="w-full p-2 rounded bg-gray-700 border border-gray-600 focus:border-blue-500 outline-none text-white" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded transition shadow-lg mt-4">
                Entrar
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-400">
            Não tem uma conta? <a href="/cadastro" class="text-blue-400 hover:underline">Cadastre-se</a>
        </p>
    </div>

    <script>
        document.getElementById('formLogin').addEventListener('submit', async (e) => {
            e.preventDefault();
            const dados = {
                usuario: document.getElementById('usuario').value,
                senha: document.getElementById('senha').value
            };

            try {
                // USANDO URL RELATIVA: Começa com / para o navegador resolver o IP sozinho
                const response = await fetch('/usuarios/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dados)
                });

                const result = await response.json();

                if (response.ok && result.status === 'sucesso') {
                    localStorage.setItem('token', result.dados.token);
                    localStorage.setItem('user_id', result.dados.usuario.id);

                    alert('Login realizado!');
                    window.location.href = '/perfil';
                } else {
                    alert('Erro: ' + (result.mensagem || 'Credenciais inválidas'));
                }
            } catch (error) {
                alert('Erro ao conectar com o servidor.');
            }
        });
    </script>
</body>
</html>
