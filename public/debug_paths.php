<?php
// Script de diagnosticare a căilor
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔍 Diagnosticare Fișiere și Rute</h1>";
echo "<p>Folder curent: " . __DIR__ . "</p>";

// LISTA DE FIȘIERE CRITICE DE VERIFICAT
// Ajustăm să căutăm în folderul src/controller (cu c mic, cum aveai tu)
$filesToCheck = [
    '../config/db.php',
    '../src/CoreCode/Router.php',
    '../src/controller/AuthController.php',
    '../src/controller/Ticketcontroller.php', // Verificăm varianta ta
    '../src/controller/TicketController.php', // Verificăm și varianta standard
    '../views/tickets/create.php',
    '../views/tickets/view.php'
];

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Fișier Căutat</th><th>Status</th><th>Calea Completă Detectată</th></tr>";

foreach ($filesToCheck as $file) {
    $fullPath = realpath(__DIR__ . '/' . $file);
    $exists = file_exists(__DIR__ . '/' . $file);
    
    $color = $exists ? 'green' : 'red';
    $status = $exists ? '✅ GĂSIT' : '❌ LIPSĂ';
    $displayPath = $fullPath ? $fullPath : "Nu a putut fi rezolvată calea";

    echo "<tr>";
    echo "<td>$file</td>";
    echo "<td style='color:$color; font-weight:bold;'>$status</td>";
    echo "<td>$displayPath</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h2>Testare Încărcare TicketController</h2>";

// Încercăm să includem controllerul manual să vedem dacă crapă clasa
$ticketFile = __DIR__ . '/../src/controller/Ticketcontroller.php';
if (file_exists($ticketFile)) {
    try {
        require_once $ticketFile;
        if (class_exists('TicketController')) {
            echo "<p style='color:green'>✅ Clasa <b>TicketController</b> a fost găsită și încărcată corect!</p>";
        } else {
            echo "<p style='color:red'>❌ Fișierul există, dar clasa <b>TicketController</b> NU a fost găsită în el. Verifică `class NumeClasa`.</p>";
        }
    } catch (Throwable $e) {
        echo "<p style='color:red'>❌ Eroare fatală la încărcarea fișierului: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Nu putem testa clasa pentru că fișierul lipsește.</p>";
}