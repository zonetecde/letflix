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
        // Regarde si le poster existe déjà dans la base de données
        $db = new SQLite3('db.sqlite3');
        $result = $db->query("SELECT * FROM poster WHERE title = '" . $_GET['title'] . "'");
        $row = $result->fetchArray(SQLITE3_ASSOC);
        if ($row) {
            echo json_encode($row['Path']);
            exit;
        }

        // Remplace l'API Key dans l'URL par la vraie clé
        $url = str_replace('%apikey%', $apiKey, 'https://api.themoviedb.org/3/search/movie?api_key=%apikey%&query=');
        $url = $url . urlencode($_GET['title']);
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        
        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }
        
        // Ajoute le poster à la base de données
        $result = json_decode($result, true);
        $result = $result['results'][0]['poster_path'];
        $db->exec("INSERT INTO poster (title, path) VALUES ('" . $_GET['title'] . "', '" . $result . "')");

        curl_close($ch);
        
        echo json_encode($result);
    }
    else {
        echo json_encode(['error' => 'Invalid endpoint']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
