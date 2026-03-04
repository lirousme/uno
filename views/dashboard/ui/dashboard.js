// /views/dashboard/ui/dashboard.js
// Responsabilidade: Lógica de front-end do Dashboard (Render, Modais, Delegação de eventos)

import { fetchDirectories, createDirectory, updateDirectory, deleteDirectory } from '../api/dir_api.js';

const DOM = {
    dirList: document.getElementById('directory-list'),
    emptyState: document.getElementById('empty-state'),
    contentGrid: document.getElementById('content-grid'),
    btnCreateRoot: document.getElementById('btn-create-root-dir'),
    btnEmptyCreate: document.getElementById('btn-empty-create'),
    // Modals
    modalCreate: document.getElementById('modal-create'),
    modalEdit: document.getElementById('modal-edit'),
    // Forms
    formCreate: document.getElementById('form-create-dir'),
    formEdit: document.getElementById('form-edit-dir')
};

// Cache local de estado (Segurança: contém apenas IDs e Nomes não sensíveis do util. logado)
let state = {
    directories: []
};

// Inicialização
async function init() {
    setupListeners();
    await loadRootDirectories();
}

// ==========================================
// RENDER UI
// ==========================================

async function loadRootDirectories() {
    try {
        const data = await fetchDirectories(); // Busca os que têm parent_id = NULL
        state.directories = data;
        renderSidebar();
    } catch (e) {
        console.error(e);
        DOM.dirList.innerHTML = '<div class="text-red-400 text-sm p-2">Erro ao carregar dados.</div>';
    }
}

function renderSidebar() {
    DOM.dirList.innerHTML = '';
    
    if (state.directories.length === 0) {
        DOM.emptyState.classList.remove('hidden');
        DOM.contentGrid.classList.add('hidden');
        return;
    }

    DOM.emptyState.classList.add('hidden');
    DOM.contentGrid.classList.remove('hidden');

    // Usa fragmento de documento para performance (Minimiza custo de DOM)
    const fragment = document.createDocumentFragment();

    state.directories.forEach(dir => {
        const div = document.createElement('div');
        div.className = "group flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700/50 cursor-pointer text-gray-300 hover:text-white transition-colors";
        div.innerHTML = `
            <div class="flex items-center gap-3 truncate">
                <i class="fa-regular fa-folder text-indigo-400"></i>
                <span class="truncate text-sm font-medium">${escapeHTML(dir.name)}</span>
            </div>
            <button class="opacity-0 group-hover:opacity-100 p-1 text-gray-400 hover:text-indigo-300 transition-opacity btn-edit-dir" data-id="${dir.id}" data-name="${escapeHTML(dir.name)}">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
        `;
        fragment.appendChild(div);
    });

    DOM.dirList.appendChild(fragment);
}

// Util para evitar XSS DOM based
function escapeHTML(str) {
    return str.replace(/[&<>'"]/g, tag => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;'
    }[tag] || tag));
}

// ==========================================
// MODALS LOGIC
// ==========================================

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    const content = document.getElementById(`${modalId}-content`);
    modal.classList.remove('hidden');
    // Animação leve
    requestAnimationFrame(() => {
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95');
    });
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    const content = document.getElementById(`${modalId}-content`);
    modal.classList.add('opacity-0');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200); // Aguarda CSS transitar
}

// ==========================================
// LISTENERS & DELEGAÇÃO
// ==========================================

function setupListeners() {
    // Abrir Create Modal
    DOM.btnCreateRoot.addEventListener('click', () => {
        document.getElementById('create-dir-name').value = '';
        openModal('modal-create');
        setTimeout(() => document.getElementById('create-dir-name').focus(), 100);
    });
    DOM.btnEmptyCreate.addEventListener('click', () => DOM.btnCreateRoot.click());

    // Fechar Modals
    document.getElementById('btn-close-create').addEventListener('click', () => closeModal('modal-create'));
    document.getElementById('btn-cancel-create').addEventListener('click', () => closeModal('modal-create'));
    document.getElementById('btn-close-edit').addEventListener('click', () => closeModal('modal-edit'));
    document.getElementById('btn-cancel-edit').addEventListener('click', () => closeModal('modal-edit'));

    // Delegação de eventos para botões de editar criados dinamicamente
    DOM.dirList.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-edit-dir');
        if (btn) {
            e.stopPropagation();
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            document.getElementById('edit-dir-id').value = id;
            document.getElementById('edit-dir-name').value = name;
            openModal('modal-edit');
            setTimeout(() => document.getElementById('edit-dir-name').focus(), 100);
        }
    });

    // Submeter Criação
    DOM.formCreate.addEventListener('submit', async (e) => {
        e.preventDefault();
        const nameInput = document.getElementById('create-dir-name');
        const name = nameInput.value.trim();
        if(!name) return;

        try {
            const res = await createDirectory(name);
            if(res.success) {
                closeModal('modal-create');
                loadRootDirectories(); // Recarrega lista
            } else {
                alert(res.error || 'Erro ao criar'); // Em prod, trocar alert por Toast (na camada shared)
            }
        } catch(err) { console.error(err); }
    });

    // Submeter Edição
    DOM.formEdit.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('edit-dir-id').value;
        const name = document.getElementById('edit-dir-name').value.trim();
        
        try {
            const res = await updateDirectory(id, name);
            if(res.success) {
                closeModal('modal-edit');
                loadRootDirectories();
            } else {
                alert(res.error);
            }
        } catch(err) { console.error(err); }
    });

    // Apagar
    document.getElementById('btn-delete-dir').addEventListener('click', async () => {
        if(!confirm('Tem certeza que deseja apagar este directório e todo o seu conteúdo?')) return;
        
        const id = document.getElementById('edit-dir-id').value;
        try {
            const res = await deleteDirectory(id);
            if(res.success) {
                closeModal('modal-edit');
                loadRootDirectories();
            }
        } catch(err) { console.error(err); }
    });

    // Logout provisório
    document.getElementById('btn-logout').addEventListener('click', () => {
        // Num fluxo real, fazer POST a /api/logout.php e invalidar sessão. Para MVP:
        document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.reload();
    });
}

// Inicia ciclo
document.addEventListener('DOMContentLoaded', init);