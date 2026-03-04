<!-- /views/dashboard/components/sidebar.php -->
<!-- Partial HTML: Lista Adjacente de Directórios -->

<aside class="w-64 bg-gray-800 border-r border-gray-700 flex flex-col h-screen flex-shrink-0 transition-all">
    <div class="h-16 flex items-center justify-between px-4 border-b border-gray-700">
        <div class="flex items-center gap-2 text-indigo-400">
            <i class="fa-solid fa-cube text-xl"></i>
            <span class="font-bold tracking-wider">UNO</span>
        </div>
        <button id="btn-create-root-dir" class="text-gray-400 hover:text-white transition-colors" title="Novo Directório Raíz">
            <i class="fa-solid fa-folder-plus"></i>
        </button>
    </div>

    <!-- Lista de Directórios Raízes Injetada Via JS (Performance de DOM reduzida) -->
    <div class="flex-1 overflow-y-auto p-3 space-y-1" id="directory-list">
        <!-- Esqueleto de carregamento -->
        <div class="animate-pulse flex space-x-4 p-2">
            <div class="rounded bg-gray-700 h-4 w-full"></div>
        </div>
        <div class="animate-pulse flex space-x-4 p-2">
            <div class="rounded bg-gray-700 h-4 w-3/4"></div>
        </div>
    </div>
</aside>