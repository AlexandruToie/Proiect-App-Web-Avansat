<?php
require_once __DIR__ . '/../../config/db.php';

class TicketController {

    // --- HELPER: UPLOAD FIȘIERE ---
    private function handleUpload() {
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $uploadFileDir = __DIR__ . '/../../public/uploads/';
            
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            $fileName = $_FILES['attachment']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'pdf');

            if (in_array($fileExtension, $allowedfileExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;

                if(move_uploaded_file($_FILES['attachment']['tmp_name'], $dest_path)) {
                    return $newFileName;
                }
            }
        }
        return null;
    }

    // --- 1. PAGINA DE CREARE + SOLUȚII PUBLICE ---
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
        
        // 1. Conectare DB
        $db = (new Database())->connect();

        // 2. Căutăm tichetele PUBLICE care sunt REZOLVATE și au o soluție scrisă
        // (Presupunem că ai coloana 'solution_text' din discuțiile anterioare despre Smart Search)
        $publicTickets = [];
        try {
            $stmt = $db->prepare("SELECT * FROM tickets WHERE is_public = 1 AND status = 'resolved' AND solution_text IS NOT NULL ORDER BY created_at DESC LIMIT 6");
            $stmt->execute();
            $publicTickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Dacă apare o eroare (ex: nu ai încă coloana solution_text), lista rămâne goală, nu crapă site-ul
            $publicTickets = [];
        }

        // 3. Încărcăm View-ul (și îi trimitem variabila $publicTickets)
        if (file_exists(__DIR__ . '/../../views/ticketscode/create.php')) {
            include __DIR__ . '/../../views/ticketscode/create.php';
        } else {
            die("Eroare: Nu găsesc fișierul views/ticketscode/create.php");
        }
    }

    // --- 2. SALVARE TICHET ---
    public function store() {
        if (!isset($_SESSION['user_id'])) { header("Location: " . BASE_URL . "/login"); exit; }

        $title = $_POST['title'] ?? '';
        $message = $_POST['message'] ?? '';
        $attachment = $this->handleUpload();

        if (empty($title) || empty($message)) {
            echo "Titlul și mesajul sunt obligatorii.";
            return;
        }

        $db = (new Database())->connect();
        try {
            $stmt = $db->prepare("INSERT INTO tickets (user_id, title, status, is_public, created_at) VALUES (?, ?, 'open', 0, NOW())");
            $stmt->execute([$_SESSION['user_id'], $title]);
            $ticket_id = $db->lastInsertId();

            $stmtMsg = $db->prepare("INSERT INTO ticket_messages (ticket_id, user_id, message, attachment, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmtMsg->execute([$ticket_id, $_SESSION['user_id'], $message, $attachment]);

            header("Location: " . BASE_URL . "/dashboard?success=ticket_created");
            exit;
        } catch (Exception $e) {
            die("Eroare la salvare: " . $e->getMessage());
        }
    }

    // --- 3. VIZUALIZARE TICHET ---
    public function view() {
        if (!isset($_SESSION['user_id'])) { header("Location: " . BASE_URL . "/login"); exit; }

        $ticket_id = $_GET['id'] ?? 0;
        $user_id = $_SESSION['user_id'];
        
        $db = (new Database())->connect();

        // Luăm tichetul
        $stmt = $db->prepare("SELECT * FROM tickets WHERE id = ? AND user_id = ?");
        $stmt->execute([$ticket_id, $user_id]);
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ticket) {
            echo "<h1>Nu ai acces la acest tichet.</h1>";
            echo "<a href='".BASE_URL."/dashboard'>Înapoi</a>";
            return;
        }

        // Luăm mesajele
        $stmtMsgs = $db->prepare("
            SELECT m.*, u.full_name, u.role 
            FROM ticket_messages m 
            JOIN users u ON m.user_id = u.id 
            WHERE ticket_id = ? 
            ORDER BY created_at ASC
        ");
        $stmtMsgs->execute([$ticket_id]);
        $messages = $stmtMsgs->fetchAll(PDO::FETCH_ASSOC);

        // --- AICI ERA EROAREA: Am schimbat 'tickets' cu 'ticketscode' ---
        if (file_exists(__DIR__ . '/../../views/ticketscode/view.php')) {
            include __DIR__ . '/../../views/ticketscode/view.php';
        } else {
             die("Eroare: Nu găsesc fișierul views/ticketscode/view.php");
        }
    }

    // --- 4. REPLY USER ---
    public function reply() {
        if (!isset($_SESSION['user_id'])) { header("Location: " . BASE_URL . "/login"); exit; }

        $ticket_id = $_POST['ticket_id'];
        $message = $_POST['message'];
        $user_id = $_SESSION['user_id'];
        $attachment = $this->handleUpload();

        $db = (new Database())->connect();

        $stmt = $db->prepare("SELECT id FROM tickets WHERE id = ? AND user_id = ?");
        $stmt->execute([$ticket_id, $user_id]);
        if (!$stmt->fetch()) { die("Acces interzis."); }

        $stmt = $db->prepare("INSERT INTO ticket_messages (ticket_id, user_id, message, attachment, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$ticket_id, $user_id, $message, $attachment]);

        $db->prepare("UPDATE tickets SET status = 'open' WHERE id = ?")->execute([$ticket_id]);

        header("Location: " . BASE_URL . "/ticketscode/view?id=" . $ticket_id);
        exit;
    }

    // --- 5. SMART SEARCH API ---
    public function checkSolution() {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        echo json_encode(['found' => false]); // Simplificat momentan
    }
}