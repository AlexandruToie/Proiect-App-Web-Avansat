<?php
// Includem conexiunea la baza de date
require_once __DIR__ . '/../../config/db.php';

class AuthController {
    
    // --- 1. FUNCȚIILE CARE AFIȘEAZĂ FORMULARELE (Lipseau înainte) ---

    public function showLoginForm() {
        // Doar afișează HTML-ul
        include __DIR__ . '/../../views/authcode/login.php';
    }

    public function showRegisterForm() {
        // Doar afișează HTML-ul
        include __DIR__ . '/../../views/authcode/register.php';
    }

    // --- 2. FUNCȚIILE DE PROCESARE (Codul tău existent) ---

    public function register() {
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $error = null;

        // Validări
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Te rugăm să introduci o adresă de email validă!";
        } elseif (strlen($password) < 6) {
            $error = "Parola este prea scurtă! Minim 6 caractere.";
        } elseif ($password !== $confirm_password) {
            $error = "Parolele introduse nu sunt identice.";
        } elseif (empty($full_name) || empty($email)) {
            $error = "Toate câmpurile sunt obligatorii.";
        }

        // Verificare DB
        if (!$error) {
            $db = (new Database())->connect();
            
            // Verificare de siguranță pentru eroarea "void"
            if ($db === null) {
                die("Eroare critică: Nu s-a putut conecta la baza de date. Verifică config/db.php");
            }

            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error = "Acest email este deja înregistrat.";
            }
        }

        if ($error) {
            $old_input = ['full_name' => $full_name, 'email' => $email];
            include __DIR__ . '/../../views/authcode/register.php';
            return;
        }

        // Salvare
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // $db este deja inițializat mai sus
            if (!isset($db)) { $db = (new Database())->connect(); }
            
            $stmt = $db->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$full_name, $email, $hashed_password]);

            header("Location: " . BASE_URL . "/login?success=registered");
            exit;
        } catch (Exception $e) {
            $error = "Eroare tehnică: " . $e->getMessage();
            include __DIR__ . '/../../views/authcode/register.php';
        }
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = null;

        if (empty($email) || empty($password)) {
            $error = "Te rugăm să completezi ambele câmpuri.";
        } else {
            $db = (new Database())->connect();
            
            if ($db === null) {
                die("Eroare critică: Conexiunea la DB a eșuat.");
            }

            $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_role'] = $user['role'] ?? 'user'; // Fallback dacă nu ai rol

                header("Location: " . BASE_URL . "/"); 
                exit;
            } else {
                $error = "Email sau parolă incorectă.";
            }
        }

        include __DIR__ . '/../../views/authcode/login.php';
    }
}