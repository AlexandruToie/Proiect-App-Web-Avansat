<?php
require_once __DIR__ . '/../../config/db.php';

class ProfileController {

    public function index() {
        if (!isset($_SESSION['user_id'])) { header("Location: " . BASE_URL . "/login"); exit; }
        
        // Luăm datele userului
        $db = (new Database())->connect();
        $stmt = $db->prepare("SELECT full_name, email FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../views/profile/index.php';
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) { header("Location: " . BASE_URL . "/login"); exit; }

        $full_name = $_POST['full_name'];
        $password = $_POST['password']; // Parola nouă (opțional)
        $id = $_SESSION['user_id'];

        $db = (new Database())->connect();

        try {
            // 1. Actualizăm Numele
            $sql = "UPDATE users SET full_name = ? WHERE id = ?";
            $params = [$full_name, $id];

            // 2. Dacă a completat și parola, o actualizăm
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    header("Location: " . BASE_URL . "/profile?error=short_password");
                    exit;
                }
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                
                // Modificăm query-ul să includă parola
                $sql = "UPDATE users SET full_name = ?, password = ? WHERE id = ?";
                $params = [$full_name, $hashed, $id];
            }

            $stmt = $db->prepare($sql);
            $stmt->execute($params);

            // Actualizăm sesiunea cu noul nume
            $_SESSION['user_name'] = $full_name;

            header("Location: " . BASE_URL . "/profile?success=updated");
        } catch (Exception $e) {
            die("Eroare: " . $e->getMessage());
        }
    }
}