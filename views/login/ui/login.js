// /views/login/ui/login.js
// Responsabilidade: Ligar o DOM aos eventos, gerir estado local da UI, chamar API.

import { loginUser, registerUser } from '../api/auth.js';

// Elementos DOM guardados em cache para performance
const DOM = {
    tabLogin: document.getElementById('tab-login'),
    tabRegister: document.getElementById('tab-register'),
    form: document.getElementById('auth-form'),
    actionInput: document.getElementById('auth-action'),
    usernameInput: document.getElementById('username'),
    passwordInput: document.getElementById('password'),
    submitBtn: document.getElementById('auth-submit-btn'),
    submitText: document.querySelector('#auth-submit-btn span'),
    alert: document.getElementById('auth-alert')
};

// Estado UI Local
let currentAction = 'login';

// Delegação e Handlers (Manutenção pontual do DOM)
function switchTab(action) {
    currentAction = action;
    DOM.actionInput.value = action;
    hideAlert();

    if (action === 'login') {
        DOM.tabLogin.className = "flex-1 py-4 text-sm font-medium bg-gray-800 text-indigo-400 border-b-2 border-indigo-500 transition-colors";
        DOM.tabRegister.className = "flex-1 py-4 text-sm font-medium bg-gray-900 text-gray-400 border-b-2 border-transparent hover:text-gray-200 transition-colors";
        DOM.submitText.textContent = "Entrar no Sistema";
    } else {
        DOM.tabRegister.className = "flex-1 py-4 text-sm font-medium bg-gray-800 text-indigo-400 border-b-2 border-indigo-500 transition-colors";
        DOM.tabLogin.className = "flex-1 py-4 text-sm font-medium bg-gray-900 text-gray-400 border-b-2 border-transparent hover:text-gray-200 transition-colors";
        DOM.submitText.textContent = "Registar Conta";
    }
}

function showAlert(message, type = 'error') {
    DOM.alert.textContent = message;
    DOM.alert.className = `mb-4 p-3 rounded text-sm font-medium block ${type === 'error' ? 'bg-red-900/50 text-red-400 border border-red-800' : 'bg-green-900/50 text-green-400 border border-green-800'}`;
}

function hideAlert() {
    DOM.alert.classList.add('hidden');
}

function toggleLoading(isLoading) {
    DOM.submitBtn.disabled = isLoading;
    if (isLoading) {
        DOM.submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processando...';
    } else {
        DOM.submitBtn.innerHTML = `<span>${currentAction === 'login' ? 'Entrar no Sistema' : 'Registar Conta'}</span>`;
    }
}

// Bindings
DOM.tabLogin.addEventListener('click', () => switchTab('login'));
DOM.tabRegister.addEventListener('click', () => switchTab('register'));

DOM.form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Validação + sanitização básica na entrada
    const username = DOM.usernameInput.value.trim().toLowerCase();
    const password = DOM.passwordInput.value;

    if (username.length < 3) {
        showAlert('Username deve ter pelo menos 3 caracteres.');
        return;
    }

    toggleLoading(true);

    try {
        let response;
        if (currentAction === 'login') {
            response = await loginUser(username, password);
        } else {
            response = await registerUser(username, password);
        }

        if (response.error) {
            showAlert(response.error);
        } else if (response.success) {
            showAlert(response.message, 'success');
            // Redirecionamento após sucesso
            setTimeout(() => {
                window.location.href = '/views/dashboard/index.php';
            }, 500);
        }
    } catch (err) {
        console.error("Networking error", err); // Apenas local, dados não vazados
        showAlert('Falha na comunicação com o servidor.');
    } finally {
        toggleLoading(false);
    }
});