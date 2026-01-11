<?php

class Router {
    protected $routes = [];

    // Adaugă rute GET
    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    // Adaugă rute POST
    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }

    // Funcția care decide ce pagină să încarce
    public function resolve() {
        // 1. Luăm URL-ul curent
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // 2. IMPORTANT: Eliminăm parametrii de după ? (ex: ?id=1)
        // Asta e partea care îți lipsea!
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        // 3. Eliminăm folderul proiectului din cale (dacă există)
        // Modifică '/proiect/public' cu numele folderului tău dacă e diferit
        $basePath = '/proiect/public'; 
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }

        // 4. Luăm metoda (GET sau POST)
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $callback = $this->routes[$method][$path] ?? false;

        // 5. Executăm ruta
        if ($callback) {
            // Dacă e funcție, o executăm
            if (is_callable($callback)) {
                call_user_func($callback);
            } 
            // Dacă e string (ex: 'Controller/metoda'), o procesăm (opțional, depinde cum ai scris rutele)
            else {
                // Pentru rutele definite ca string
                $parts = explode('/', $callback);
                // ... logica ta veche aici dacă foloseai string-uri ...
            }
        } else {
            // DEBUG: Dacă nu găsește ruta, afișăm ce a căutat
            echo "<h1>404 Not Found</h1>";
            echo "<p>Router-ul a căutat calea: <strong>" . htmlspecialchars($path) . "</strong></p>";
            echo "<p>Metoda: <strong>" . htmlspecialchars($method) . "</strong></p>";
            echo "<p>Verifică index.php dacă această rută este definită exact așa.</p>";
            exit;
        }
    }
}