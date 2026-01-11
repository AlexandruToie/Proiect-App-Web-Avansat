<?php
// 1. SETĂRI SERVER & ERORI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. CONSTANTE
define('BASE_URL', '/proiect/public');

// 3. INCLUDE-URI DE BAZĂ
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/CoreCode/Router.php';

$router = new Router();

// =================================================================
// 1. ZONA DE AUTENTIFICARE (Auth)
// =================================================================
$router->get('/login', function() {
    require_once __DIR__ . '/../src/controller/AuthController.php';
    (new AuthController())->showLoginForm();
});

$router->post('/login', function() {
    require_once __DIR__ . '/../src/controller/AuthController.php';
    (new AuthController())->login();
});

$router->get('/register', function() {
    require_once __DIR__ . '/../src/controller/AuthController.php';
    (new AuthController())->showRegisterForm();
});

$router->post('/register', function() {
    require_once __DIR__ . '/../src/controller/AuthController.php';
    (new AuthController())->register();
});

$router->get('/logout', function() {
    session_destroy();
    header("Location: " . BASE_URL . "/login");
    exit;
});

// =================================================================
// 2. DASHBOARD
// =================================================================
$router->get('/dashboard', function() {
    // Atenție la numele fișierului: Dashboardcontroller.php
    require_once __DIR__ . '/../src/controller/Dashboardcontroller.php';
    (new DashboardController())->index();
});

// =================================================================
// 3. TICHETE (User)
// =================================================================
// Formular creare
$router->get('/ticketscode/create', function() {
    require_once __DIR__ . '/../src/controller/Ticketcontroller.php';
    (new TicketController())->create();
});

// Salvare tichet (POST)
$router->post('/ticketscode/store', function() {
    require_once __DIR__ . '/../src/controller/Ticketcontroller.php';
    (new TicketController())->store();
});

// Vizualizare tichet (Chat)
$router->get('/ticketscode/view', function() {
    require_once __DIR__ . '/../src/controller/Ticketcontroller.php';
    (new TicketController())->view();
});

// Reply user (POST)
$router->post('/ticketscode/reply', function() {
    require_once __DIR__ . '/../src/controller/Ticketcontroller.php';
    (new TicketController())->reply();
});

// API Căutare Soluții (Opțional, dacă îl folosești)
$router->post('/api/check-solution', function() {
    require_once __DIR__ . '/../src/controller/Ticketcontroller.php';
    (new TicketController())->checkSolution();
});

// =================================================================
// 4. ADMIN PANEL
// =================================================================
$router->get('/admin', function() {
    // Atenție la numele fișierului: Admincontroller.php
    require_once __DIR__ . '/../src/controller/Admincontroller.php';
    (new AdminController())->index();
});

$router->get('/admin/ticket', function() {
    require_once __DIR__ . '/../src/controller/Admincontroller.php';
    (new AdminController())->showTicket();
});

$router->post('/admin/reply', function() {
    require_once __DIR__ . '/../src/controller/Admincontroller.php';
    (new AdminController())->reply();
});

$router->post('/admin/delete', function() {
    require_once __DIR__ . '/../src/controller/Admincontroller.php';
    (new AdminController())->delete();
});

// =================================================================
// 5. HOME (Rădăcină)
// =================================================================
$router->get('/', function() {
    // Afișăm pagina de Home indiferent dacă e logat sau nu
    // Butoanele din pagină se vor schimba dinamic (vezi codul din home.php)
    include __DIR__ . '/../views/home.php';
});

// --- PROFIL ---
$router->get('/profile', function() {
    require_once __DIR__ . '/../src/controller/ProfileController.php';
    (new ProfileController())->index();
});

$router->post('/profile/update', function() {
    require_once __DIR__ . '/../src/controller/ProfileController.php';
    (new ProfileController())->update();
});
// Executăm rutele
$router->resolve();