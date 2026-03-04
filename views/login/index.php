<?php
// Caminho: views/login/index.php
// Responsabilidade: Estruturar a página de login/registo via SSI.

if (session_status() === PHP_SESSION_NONE) {
    require_once __DIR__ . '/../../shared/security/session.php';
}
if (is_logged_in()) {
    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-PT" class="dark">
<?php require_once __DIR__ . '/components/header.php'; ?>
<body class="bg-gray-950 text-gray-100 flex items-center justify-center min-h-screen antialiased">
    
    <main class="w-full max-w-md p-8 bg-gray-900 rounded-2xl shadow-2xl border border-gray-800">
        <!-- Toast de Mensagens -->
        <div id="alert-container" class="hidden mb-6 p-4 rounded-lg text-sm font-semibold transition-opacity"></div>

        <!-- Secção de Login -->
        <div id="login-section">
            <?php require_once __DIR__ . '/components/login_form.php'; ?>
        </div>

        <!-- Secção de Registo -->
        <div id="register-section" class="hidden">
            <?php require_once __DIR__ . '/components/register_form.php'; ?>
        </div>
    </main>

    <!-- Injeção segura de configuração -->
    <script>
        window.AppConfig = {
            csrfToken: '<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>'
        };
    </script>
    <script type="module" src="/views/login/ui/login.js"></script>
</body>
</html>