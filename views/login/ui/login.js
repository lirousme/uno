// views/login/ui/login.js
// Controla DOM, estado visual do form e comunicação com a API de Auth.

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('auth-form');
    const toggleBtn = document.getElementById('toggle-mode');
    const actionInput = document.getElementById('action');
    const submitBtn = document.getElementById('submit-btn');
    const formTitle = document.getElementById('form-title');
    const formSubtitle = document.getElementById('form-subtitle');
    const errorMessage = document.getElementById('error-message');

    let isLogin = true;

    // Minimiza o custo no DOM mudando apenas o necessário
    toggleBtn.addEventListener('click', () => {
        isLogin = !isLogin;
        errorMessage.classList.add('hidden');

        if (isLogin) {
            actionInput.value = 'login';
            formTitle.textContent = 'Acesso Seguro';
            formSubtitle.textContent = 'Introduza as suas credenciais para continuar.';
            submitBtn.innerHTML = '<span>Entrar no Sistema</span><i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>';
            toggleBtn.textContent = 'Não tem conta? Criar uma agora.';
        } else {
            actionInput.value = 'register';
            formTitle.textContent = 'Criar Conta';
            formSubtitle.textContent = 'Registe-se para aceder à plataforma.';
            submitBtn.innerHTML = '<span>Registar Conta</span><i class="fa-solid fa-user-plus ml-2"></i>';
            toggleBtn.textContent = 'Já tem conta? Iniciar sessão.';
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorMessage.classList.add('hidden');

        const originalBtnHtml = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>';
        submitBtn.disabled = true;

        const formData = new FormData(form);

        try {
            const response = await fetch('./api/auth.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok) {
                // Navegação por SSR redirect do cliente após sucesso na API
                window.location.href = '../dashboard/index.php';
            } else {
                errorMessage.textContent = data.error || 'Ocorreu um erro no processamento.';
                errorMessage.classList.remove('hidden');
            }
        } catch (error) {
            errorMessage.textContent = 'Falha de rede ao comunicar com o servidor.';
            errorMessage.classList.remove('hidden');
        } finally {
            submitBtn.innerHTML = originalBtnHtml;
            submitBtn.disabled = false;
        }
    });
});