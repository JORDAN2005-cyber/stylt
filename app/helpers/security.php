<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field(): string {
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}
function verify_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Session expirée. Recharge la page et réessaie.');
    }
}
function redirect(string $url): never {
    header('Location: ' . $url); exit;
}
function flash(string $type, string $message): void {
    $_SESSION['flash'][] = ['type'=>$type,'message'=>$message];
}
function flashes(): array {
    $f = $_SESSION['flash'] ?? []; unset($_SESSION['flash']); return $f;
}
