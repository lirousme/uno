// /views/dashboard/api/dir_api.js
// Responsabilidade: Networking de directórios

const headers = () => ({
    'Content-Type': 'application/json',
    'X-CSRF-Token': window.APP_CONFIG.csrfToken
});

export async function fetchDirectories(parentId = null) {
    const url = `./api/endpoint_dirs.php${parentId ? '?parent_id=' + parentId : ''}`;
    const res = await fetch(url);
    if(!res.ok) throw new Error("Falha ao carregar directórios");
    return res.json();
}

export async function createDirectory(name, parentId = null) {
    const res = await fetch('./api/endpoint_dirs.php', {
        method: 'POST',
        headers: headers(),
        body: JSON.stringify({ name, parent_id: parentId })
    });
    return res.json();
}

export async function updateDirectory(id, name) {
    const res = await fetch('./api/endpoint_dirs.php', {
        method: 'PUT',
        headers: headers(),
        body: JSON.stringify({ id, name })
    });
    return res.json();
}

export async function deleteDirectory(id) {
    const res = await fetch('./api/endpoint_dirs.php', {
        method: 'DELETE',
        headers: headers(),
        body: JSON.stringify({ id })
    });
    return res.json();
}