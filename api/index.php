<?php
include('api_key.php'); // Contient l'API Key de TheMovieDB

// Pour lancer le serveur PHP :
// >>> cd /api
// >>> php -S localhost:8000 -c php.ini
ini_set('allow_url_fopen', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];

    // Handle different endpoints
    if ($endpoint === 'is_running') {
        echo json_encode(['message' => 'PHP server is running']);
    } elseif ($endpoint === 'execute') {
        // Récupère la requête SQL
        $sql = $_GET['sql'];

        // Ouvre la connexion à la base de données
        $db = new SQLite3('db.sqlite3');

        // Vérifie la connexion
        if (!$db) {
            echo json_encode(['error' => 'Unable to connect to the database']);
            exit;
        }

        // Éxecute la requête
        $result = $db->query($sql);

        // Récupère les résultats
        $results = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $results[] = $row;
        }

        // Ferme la connexion
        $db->close();

        // Renvoie les résultats
        echo json_encode(['results' => $results]);
    }
    else if ($endpoint === 'themoviedb'){
        // http://localhost:8000/index.php?endpoint=themoviedb&req=https%3A%2F%2Fapi.themoviedb.org%2F3%2Fsearch%2Fmovie%3Fapi_key%3D%25apikey%25%26query%3Dthe%2Bavengers

        // Remplace l'API Key dans l'URL par la vraie clé
        $url = str_replace('%apikey%', $apiKey, $_GET['req']);
        
        $ch = curl_init($url);
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        
        $result = curl_exec($ch);
        
        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }
        
        curl_close($ch);
        
        echo json_encode($result);
        
        
    }
    else {
        echo json_encode(['error' => 'Invalid endpoint']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
