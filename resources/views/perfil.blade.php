<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Instagram API - Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen p-6">
    <div class="max-w-md mx-auto bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-700 mt-10">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6 text-center">
            <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-4 border-4 border-gray-800 flex items-center justify-center text-gray-600 text-4xl font-bold" id="avatar">
                ?
            </div>
            <h2 class="text-2xl font-bold" id="nome-perfil">Carregando...</h2>
            <p class="text-blue-200" id="user-handle">@usuário</p>
        </div>

        <div class="p-6 space-y-4">
            <div>
                <label class="text-xs text-gray-500 uppercase font-bold text-gray-400">E-mail</label>
                <p class="text-lg" id="email-perfil">-</p>
            </div>
            <div>
                <label class="text-xs text-gray-500 uppercase font-bold text-gray-400">Biografia</label>
                <p class="text-gray-300 italic" id="bio-perfil">Sem biografia disponível.</p>
            </div>

            <div class="pt-6 border-t border-gray-700 flex gap-2">
                <button onclick="logout()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded font-bold transition">Sair</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const token = localStorage.getItem('token');
            const userId = localStorage.getItem('user_id');


            if (!token) { window.location.href = '/login'; return; }

            try {

                const response = await fetch(`/usuarios/${userId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok && result.status === 'sucesso') {
                    const u = result.dados;
                    document.getElementById('nome-perfil').innerText = u.nome;
                    document.getElementById('user-handle').innerText = '@' + u.usuario;
                    document.getElementById('email-perfil').innerText = u.email;
                    document.getElementById('bio-perfil').innerText = u.biografia || 'Sem biografia.';
                    document.getElementById('avatar').innerText = u.nome.charAt(0);
                } else {
                    console.error("Erro na resposta:", result);
                    logout();
                }
            } catch (error) {
                console.error('Erro ao buscar dados:', error);
            }
        });

        async function logout() {
            const token = localStorage.getItem('token');

            try {

                await fetch('/usuarios/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
            } catch (e) {
                console.log("Erro ao avisar servidor do logout, mas limpando local...");
            }


            localStorage.clear();
            window.location.href = '/login';
        }
    </script>
</body>
</html>
