<!-- /views/dashboard/components/modal_create.php -->
<!-- Partial HTML: Modal Criar Directório -->

<div id="modal-create" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center opacity-0 transition-opacity">
    <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform" id="modal-create-content">
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center">
            <h3 class="font-semibold text-lg">Criar Directório</h3>
            <button id="btn-close-create" class="text-gray-400 hover:text-gray-200">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="form-create-dir" class="p-6">
            <!-- Em actualizações futuras, podemos colocar parent_id aqui dinamicamente -->
            <input type="hidden" id="create-parent-id" value=""> 
            
            <div class="mb-4">
                <label for="create-dir-name" class="block text-sm font-medium text-gray-300 mb-2">Nome do Directório</label>
                <input type="text" id="create-dir-name" required autocomplete="off"
                    class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                    placeholder="Ex: Projectos 2026">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" id="btn-cancel-create" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white">Criar</button>
            </div>
        </form>
    </div>
</div>