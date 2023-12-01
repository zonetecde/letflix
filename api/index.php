<?php
// Pour lancer le serveur PHP :
// >>> cd /api
// >>> php -S localhost:8000 -d extension=sqlite3

header('Content-Type: application/json');

// Your API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];

    // Handle different endpoints
    if ($endpoint === 'is_running') {
        echo json_encode(['message' => 'PHP server is running']);
    } elseif ($endpoint === 'titles') {
        // Connect to SQLite database
        $db = new SQLite3('db.sqlite3');

        // Check if the connection was successful
        if (!$db) {
            echo json_encode(['error' => 'Unable to connect to the database']);
            exit;
        }

        // Execute the SQL query
        $result = $db->query('SELECT * FROM titles');

        // Fetch the data
        $titles = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $titles[] = $row;
        }

        // Close the database connection
        $db->close();

        // Return the data as JSON
        echo json_encode(['titles' => $titles]);
    } else {
        echo json_encode(['error' => 'Invalid endpoint']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
