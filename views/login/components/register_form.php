<!-- Caminho: views/login/components/register_form.php -->
<div class="text-center mb-8">
    <i class="fa-solid fa-user-plus text-4xl text-emerald-500 mb-2"></i>
    <h1 class="text-2xl font-bold tracking-tight">Nova Conta</h1>
    <p class="text-gray-400 text-sm mt-1">Regista o teu username no UNO</p>
</div>

<form id="register-form" class="space-y-5">
    <div>
        <label for="reg-username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-at text-gray-500"></i>
            </div>
            <input type="text" id="reg-username" name="username" required minlength="3" maxlength="50" autocomplete="off"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg py-2.5 pl-10 pr-4 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
        </div>
    </div>
    
    <div>
        <label for="reg-password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-key text-gray-500"></i>
            </div>
            <input type="password" id="reg-password" name="password" required minlength="8" autocomplete="new-password"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg py-2.5 pl-10 pr-4 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
        </div>
    </div>

    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200 flex justify-center items-center">
        <span>Criar Conta</span><i class="fa-solid fa-check ml-2"></i>
    </button>
</form>

<p class="mt-6 text-center text-sm text-gray-400">
    Já tens conta? <button type="button" id="btn-show-login" class="text-emerald-400 hover:text-emerald-300 font-semibold hover:underline transition">Iniciar sessão</button>
</p>