<!-- Caminho: views/login/components/login_form.php -->
<div class="text-center mb-8">
    <i class="fa-solid fa-cube text-4xl text-indigo-500 mb-2"></i>
    <h1 class="text-2xl font-bold tracking-tight">Iniciar Sessão</h1>
    <p class="text-gray-400 text-sm mt-1">Bem-vindo de volta ao UNO</p>
</div>

<form id="login-form" class="space-y-5">
    <div>
        <label for="login-username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-user text-gray-500"></i>
            </div>
            <input type="text" id="login-username" name="username" required autocomplete="username"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg py-2.5 pl-10 pr-4 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
        </div>
    </div>
    
    <div>
        <label for="login-password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-lock text-gray-500"></i>
            </div>
            <input type="password" id="login-password" name="password" required autocomplete="current-password"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg py-2.5 pl-10 pr-4 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
        </div>
    </div>

    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200 flex justify-center items-center">
        <span>Entrar</span><i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
    </button>
</form>

<p class="mt-6 text-center text-sm text-gray-400">
    Não tens conta? <button type="button" id="btn-show-register" class="text-indigo-400 hover:text-indigo-300 font-semibold hover:underline transition">Criar agora</button>
</p>