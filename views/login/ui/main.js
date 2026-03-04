// /views/login/ui/main.js

/**
 * Interface JS da view de Login.
 * Lógica modular utilizando ES6. Responsável por bindings de DOM e chamadas às APIs.
 */

// Obter token CSRF seguro exposto no cabeçalho HTML
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Referências DOM
const viewLogin = document.getElementById('view-login');
const viewRegister = document.getElementById('view-register');
const formLogin = document.getElementById('form-login');
const formRegister = document.getElementById('form-register');
const toastContainer = document.getElementById('toast-container');
const toastMsg = document.getElementById('toast-msg');

// Handlers de Alternância de Views (Delegação de Eventos para os links)
document.getElementById('toggle-to-register').addEventListener('click', (e) => {
    e.preventDefault();
    viewLogin.classList.add('hidden');
    viewRegister.classList.remove('hidden');
    hideToast();
});

document.getElementById('toggle-to-login').addEventListener('click', (e) => {
    e.preventDefault();
    viewRegister.classList.add('hidden');
    viewLogin.classList.remove('hidden');
    hideToast();
});

// Utilitário local para Feedback Visual
function showToast(message, isError = true) {
    toastMsg.textContent = message;
    if (isError) {
        toastMsg.className = 'bg-red-500/20 border border-red-500 text-red-200 text-sm p-3 rounded-lg text-center font-medium';
    } else {
        toastMsg.className = 'bg-green-500/20 border border-green-500 text-green-200 text-sm p-3 rounded-lg text-center font-medium';
    }
    toastContainer.classList.remove('hidden');
    setTimeout(hideToast, 4000);
}

function hideToast() {
    toastContainer.classList.add('hidden');
}

function toggleLoading(btnId, spinnerId, isLoading) {
    const btn = document.getElementById(btnId);
    const spinner = document.getElementById(spinnerId);
    btn.disabled = isLoading;
    if (isLoading) {
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        spinner.classList.remove('hidden');
    } else {
        btn.classList.remove('opacity-75', 'cursor-not-allowed');
        spinner.classList.add('hidden');
    }
}

// Handler de Submit: LOGIN
formLogin.addEventListener('submit', async (e) => {
    e.preventDefault();
    hideToast();
    toggleLoading('btn-submit-login', 'spinner-login', true);

    const formData = new FormData(formLogin);
    const payload = Object.fromEntries(formData.entries());

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken // Protecção anti-CSRF
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || 'Ocorreu um erro ao fazer login.');
        }

        // Sucesso: Redireciona para o Dashboard
        window.location.href = '/dashboard';

    } catch (error) {
        showToast(error.message, true);
    } finally {
        toggleLoading('btn-submit-login', 'spinner-login', false);
    }
});

// Handler de Submit: REGISTO
formRegister.addEventListener('submit', async (e) => {
    e.preventDefault();
    hideToast();
    toggleLoading('btn-submit-register', 'spinner-register', true);

    const formData = new FormData(formRegister);
    const payload = Object.fromEntries(formData.entries());

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || 'Ocorreu um erro ao criar a conta.');
        }

        // Sucesso: Mostrar mensagem, mudar para login e preencher username
        showToast('Conta criada com sucesso! Por favor, faz login.', false);
        viewRegister.classList.add('hidden');
        viewLogin.classList.remove('hidden');
        document.getElementById('login-username').value = payload.username;
        formRegister.reset();

    } catch (error) {
        showToast(error.message, true);
    } finally {
        toggleLoading('btn-submit-register', 'spinner-register', false);
    }
});