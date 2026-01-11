<?php
require_once __DIR__ . '/../../config/db.php';

class AdminController {

    // Helper: Verifică dacă ești admin, altfel te dă afară
    private function checkAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    // 1. Dashboard Admin: Lista cu toate tichetele
    public function index() {
        $this->checkAdmin();
        $db = (new Database())->connect();

        // Luăm tichetele și numele userului care le-a creat
        // Le ordonăm: cele deschise primele, apoi cele mai noi
        $stmt = $db->query("
            SELECT t.*, u.full_name 
            FROM tickets t 
            JOIN users u ON t.user_id = u.id 
            ORDER BY FIELD(status, 'open', 'answered', 'resolved') ASC, created_at DESC
        ");
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../views/admin/dashboard.php';
    }

    // 2. Pagina de vizualizare și răspuns la un tichet
    public function showTicket() {
        $this->checkAdmin();
        $ticket_id = $_GET['id'] ?? 0;
        $db = (new Database())->connect();

        // A. Luăm detaliile tichetului
        $stmt = $db->prepare("SELECT t.*, u.full_name, u.email FROM tickets t JOIN users u ON t.user_id = u.id WHERE t.id = ?");
        $stmt->execute([$ticket_id]);
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ticket) { echo "Tichet inexistent."; return; }

        // B. Luăm mesajele (Chat-ul)
        $stmtMsgs = $db->prepare("
            SELECT m.*, u.full_name, u.role 
            FROM ticket_messages m 
            JOIN users u ON m.user_id = u.id 
            WHERE ticket_id = ? 
            ORDER BY created_at ASC
        ");
        $stmtMsgs->execute([$ticket_id]);
        $messages = $stmtMsgs->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../views/admin/show_ticket.php';
    }

    // 3. Procesarea răspunsului Adminului
    public function reply() {
        $this->checkAdmin();
        
        $ticket_id = $_POST['ticket_id'];
        $message = $_POST['message'];
        $status = $_POST['status']; // open, resolved, etc.
        
        // Checkbox-ul "Make Public" (pentru sugestii)
        $is_public = isset($_POST['is_public']) ? 1 : 0;
        $solution_text = $_POST['solution_text'] ?? '';

        $db = (new Database())->connect();

        try {
            // A. Salvăm mesajul adminului
            if (!empty($message)) {
                $stmt = $db->prepare("INSERT INTO ticket_messages (ticket_id, user_id, message) VALUES (?, ?, ?)");
                $stmt->execute([$ticket_id, $_SESSION['user_id'], $message]);
            }

            // B. Actualizăm statusul tichetului și setările de public/privat
            // Dacă tichetul devine public, trebuie să avem și textul soluției
            $sql = "UPDATE tickets SET status = ?, is_public = ?";
            $params = [$status, $is_public];

            if ($is_public == 1 && !empty($solution_text)) {
                $sql .= ", solution_text = ?";
                $params[] = $solution_text;
            }

            $sql .= " WHERE id = ?";
            $params[] = $ticket_id;

            $stmt = $db->prepare($sql);
            $stmt->execute($params);

            header("Location: " . BASE_URL . "/admin/ticket?id=" . $ticket_id);
        } catch (Exception $e) {
            echo "Eroare: " . $e->getMessage();
        }
    }

    // --- 4. ȘTERGERE TICHET (NOU) ---
    public function delete() {
        $this->checkAdmin(); // Doar adminul poate șterge

        $ticket_id = $_POST['ticket_id'] ?? 0;
        
        if ($ticket_id) {
            $db = (new Database())->connect();
            try {
                // 1. Ștergem mesajele asociate
                $stmt = $db->prepare("DELETE FROM ticket_messages WHERE ticket_id = ?");
                $stmt->execute([$ticket_id]);

                // 2. Ștergem tichetul
                $stmt = $db->prepare("DELETE FROM tickets WHERE id = ?");
                $stmt->execute([$ticket_id]);
                
                header("Location: " . BASE_URL . "/admin?success=deleted");
                exit;
            } catch (Exception $e) {
                die("Eroare la ștergere: " . $e->getMessage());
            }
        }
        header("Location: " . BASE_URL . "/admin");
        exit;
    }
}