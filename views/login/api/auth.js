// /views/login/api/auth.js
// Responsabilidade: Tratar apenas do networking específico de autenticação.

export async function loginUser(username, password) {
    return fetch('./api/endpoint_login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': window.APP_CONFIG.csrfToken
        },
        body: JSON.stringify({ username, password })
    }).then(res => res.json());
}

export async function registerUser(username, password) {
    return fetch('./api/endpoint_register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': window.APP_CONFIG.csrfToken
        },
        body: JSON.stringify({ username, password })
    }).then(res => res.json());
}