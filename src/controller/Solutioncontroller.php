<?php
require_once __DIR__ . '/../../config/db.php';

class SolutionController {

    // Arată detaliile unui tichet rezolvat (public)
    public function show() {
        $id = $_GET['id'] ?? 0;

        $db = (new Database())->connect();
        
        // Luăm tichetul DOAR dacă e public
        // JOIN cu users ca să vedem cine a avut problema (Userul X)
        $stmt = $db->prepare("
            SELECT t.*, u.full_name as author_name 
            FROM tickets t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.id = ? AND t.is_public = 1
        ");
        $stmt->execute([$id]);
        $solution = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$solution) {
            echo "Această soluție nu există sau este privată.";
            return;
        }

        include __DIR__ . '/../../views/solutions/show.php';
    }

    // Returnează Top Tichete Rezolvate (publice)
    public static function getTopSolutions() {
        $db = (new Database())->connect();
        
        // Selectăm tichetele rezolvate, publice, ordonate după cât de utile au fost
        $stmt = $db->query("
            SELECT id, title, solution_text as content, helpful_count, created_at 
            FROM tickets 
            WHERE status = 'resolved' AND is_public = 1 
            ORDER BY helpful_count DESC 
            LIMIT 6
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}