<?php
/**
 * Test MySQL Database Connection
 * 
 * This file tests the connection to your local MySQL database.
 * Access it at: http://localhost:9090/test-db.php
 */

// Database configuration (matches docker-compose.yml)
$host = getenv('DB_HOST') ?: 'mysql';
$dbname = getenv('DB_NAME') ?: 'playground';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: 'rootpassword';

echo "<h1>MySQL Connection Test</h1>";

try {
    // Test PDO connection
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    
    echo "<p style='color: green;'>✅ <strong>Connection successful!</strong></p>";
    
    // Get MySQL version
    $stmt = $pdo->query("SELECT VERSION() as version");
    $version = $stmt->fetch();
    echo "<p><strong>MySQL Version:</strong> " . htmlspecialchars($version['version']) . "</p>";
    
    // List databases
    echo "<h2>Available Databases:</h2>";
    $stmt = $pdo->query("SHOW DATABASES");
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>" . htmlspecialchars($row['Database']) . "</li>";
    }
    echo "</ul>";
    
    // Test creating a table
    echo "<h2>Testing Table Creation:</h2>";
    $pdo->exec("CREATE TABLE IF NOT EXISTS test_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        message VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "<p style='color: green;'>✅ Test table created/verified</p>";
    
    // Insert test data
    $stmt = $pdo->prepare("INSERT INTO test_table (message) VALUES (?)");
    $stmt->execute(["Hello from PHP at " . date('Y-m-d H:i:s')]);
    echo "<p style='color: green;'>✅ Test data inserted</p>";
    
    // Read test data
    $stmt = $pdo->query("SELECT * FROM test_table ORDER BY id DESC LIMIT 5");
    echo "<h3>Recent Test Records:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Message</th><th>Created At</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['message']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ <strong>Connection failed:</strong></p>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    
    echo "<h2>Connection Details:</h2>";
    echo "<ul>";
    echo "<li><strong>Host:</strong> $host</li>";
    echo "<li><strong>Database:</strong> $dbname</li>";
    echo "<li><strong>Username:</strong> $username</li>";
    echo "<li><strong>Password:</strong> " . str_repeat('*', strlen($password)) . "</li>";
    echo "</ul>";
    
    echo "<h2>Troubleshooting:</h2>";
    echo "<ul>";
    echo "<li>Make sure MySQL container is running: <code>docker compose ps</code></li>";
    echo "<li>Check MySQL logs: <code>docker compose logs mysql</code></li>";
    echo "<li>Wait a few seconds after starting containers for MySQL to initialize</li>";
    echo "</ul>";
}
?>
