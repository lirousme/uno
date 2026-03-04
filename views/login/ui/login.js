// Caminho: views/login/ui/login.js
// Módulo ES6 para lidar com o DOM da view de Login

const loginSection = document.getElementById('login-section');
const registerSection = document.getElementById('register-section');
const btnShowRegister = document.getElementById('btn-show-register');
const btnShowLogin = document.getElementById('btn-show-login');
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const alertContainer = document.getElementById('alert-container');

// Navegação entre forms
const toggleSections = (hideEl, showEl) => {
    hideEl.classList.add('hidden');
    showEl.classList.remove('hidden');
    hideAlert();
};

btnShowRegister.addEventListener('click', () => toggleSections(loginSection, registerSection));
btnShowLogin.addEventListener('click', () => toggleSections(registerSection, loginSection));

// UI Feedback
const showAlert = (message, type = 'error') => {
    alertContainer.textContent = message;
    const baseClasses = 'mb-6 p-4 rounded-lg text-sm font-semibold transition-opacity';
    const typeClasses = type === 'error' 
        ? 'bg-red-900/30 text-red-400 border border-red-800' 
        : 'bg-emerald-900/30 text-emerald-400 border border-emerald-800';
    
    alertContainer.className = `${baseClasses} ${typeClasses}`;
    alertContainer.classList.remove('hidden');
};

const hideAlert = () => alertContainer.classList.add('hidden');

// Fetch abstraction
const postData = async (action, formElement) => {
    const data = new FormData(formElement);
    data.append('csrf_token', window.AppConfig.csrfToken);
    data.append('action', action);

    const response = await fetch('/views/login/api/auth.php', {
        method: 'POST',
        body: data
    });

    const result = await response.json();
    if (!response.ok || !result.success) {
        throw new Error(result.error || 'Ocorreu um erro no servidor.');
    }
    return result;
};

// Handlers
const handleAuthSubmit = async (e, action) => {
    e.preventDefault();
    hideAlert();
    
    const form = e.target;
    const btn = form.querySelector('button[type="submit"]');
    const originalHTML = btn.innerHTML;
    
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>';
    btn.disabled = true;
    btn.classList.add('opacity-70', 'cursor-not-allowed');

    try {
        await postData(action, form);
        if (action === 'register') {
            showAlert('Conta criada! A entrar...', 'success');
        }
        setTimeout(() => window.location.href = '/', action === 'register' ? 1000 : 0);
    } catch (err) {
        showAlert(err.message);
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        btn.classList.remove('opacity-70', 'cursor-not-allowed');
    }
};

loginForm.addEventListener('submit', (e) => handleAuthSubmit(e, 'login'));
registerForm.addEventListener('submit', (e) => handleAuthSubmit(e, 'register'));