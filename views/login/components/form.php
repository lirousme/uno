<!-- /views/login/components/form.php -->
<!-- Partial HTML restrito à view de login -->

<div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden">
    <!-- Tabs -->
    <div class="flex border-b border-gray-700">
        <button id="tab-login" class="flex-1 py-4 text-sm font-medium bg-gray-800 text-indigo-400 border-b-2 border-indigo-500 transition-colors">
            Entrar
        </button>
        <button id="tab-register" class="flex-1 py-4 text-sm font-medium bg-gray-900 text-gray-400 border-b-2 border-transparent hover:text-gray-200 transition-colors">
            Criar Conta
        </button>
    </div>

    <div class="p-6">
        <!-- Notificações de Erro/Sucesso -->
        <div id="auth-alert" class="hidden mb-4 p-3 rounded text-sm font-medium"></div>

        <!-- Formulário Dinâmico -->
        <form id="auth-form" class="space-y-4">
            <input type="hidden" id="auth-action" value="login">
            
            <div>
                <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-user text-gray-500"></i>
                    </div>
                    <input type="text" id="username" name="username" required autocomplete="username"
                        class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder-gray-600"
                        placeholder="O teu username exclusivo">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-500"></i>
                    </div>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                        class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder-gray-600"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" id="auth-submit-btn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors flex justify-center items-center gap-2">
                <span>Entrar no Sistema</span>
                <i class="fa-solid fa-arrow-right text-sm hidden group-hover:block"></i>
            </button>
        </form>
    </div>
</div>