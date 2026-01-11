<?php
require_once __DIR__ . '/../../config/db.php';

class DashboardController {
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $db = (new Database())->connect();
        $userId = $_SESSION['user_id'];

        // --- 1. PRELUĂM FILTRELE DIN URL ---
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';

        // --- 2. CONSTRUIM INTEROGAREA SQL ---
        $sql = "SELECT * FROM tickets WHERE user_id = ?";
        $params = [$userId];

        // Dacă utilizatorul a scris ceva în căutare
        if (!empty($search)) {
            $sql .= " AND (title LIKE ? OR id LIKE ?)";
            $params[] = "%$search%"; // Căutăm parțial în titlu
            $params[] = "%$search%"; // Sau exact ID-ul
        }

        // Dacă a selectat un status specific
        if (!empty($status) && $status !== 'all') {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY created_at DESC";

        // --- 3. EXECUTĂM ---
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // --- 4. AFIȘĂM VIEW-UL ---
        // (Nu mai facem query în view, trimitem datele gata filtrate)
        include __DIR__ . '/../../views/Dashboard.php';
    }
}