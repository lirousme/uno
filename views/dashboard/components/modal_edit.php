<!-- /views/dashboard/components/modal_edit.php -->
<!-- Partial HTML: Modal Editar/Excluir Directório -->

<div id="modal-edit" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center opacity-0 transition-opacity">
    <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform" id="modal-edit-content">
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center">
            <h3 class="font-semibold text-lg">Gerir Directório</h3>
            <button id="btn-close-edit" class="text-gray-400 hover:text-gray-200">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="form-edit-dir" class="p-6">
            <input type="hidden" id="edit-dir-id" value="">
            
            <div class="mb-4">
                <label for="edit-dir-name" class="block text-sm font-medium text-gray-300 mb-2">Renomear Directório</label>
                <input type="text" id="edit-dir-name" required autocomplete="off"
                    class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            
            <div class="flex justify-between mt-8 pt-4 border-t border-gray-700">
                <button type="button" id="btn-delete-dir" class="px-3 py-2 rounded-lg text-sm font-medium text-red-400 hover:bg-red-900/30 flex items-center gap-2">
                    <i class="fa-solid fa-trash-can"></i> Apagar
                </button>
                <div class="flex gap-2">
                    <button type="button" id="btn-cancel-edit" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700">Cancelar</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>