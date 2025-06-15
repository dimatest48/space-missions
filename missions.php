<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Misje kosmiczne</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body.missions-page {
            background-color: #0b0f1a;
            color: #f0eaf1;
            font-family: 'Outfit', sans-serif;
            padding: 40px 20px;
        }

        .intro-section {
            margin: 0 0 40px 0;
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(255, 105, 180, 0.05);
        }

        .intro-section h1 {
            font-size: 2.5rem;
            color: #ffaad4;
            margin-bottom: 20px;
        }

        .intro-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #f7f1f5;
        }

        .mission-card {
            max-width: 90%;
            margin: 0 auto 40px auto;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 45px;
            box-shadow: 0 0 17px 2px rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
             transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    z-index: 1;
        }

        /* Головний ефект при наведенні */
.mission-card:hover {
    transform: scale(1.03);
    box-shadow: 0 0 15px 7px rgba(255, 255, 255, 0.5);
    z-index: 10;
}

/* Ефект "від'їзду вниз" інших блоків */
.mission-card:hover ~ .mission-card {
    transform: translateY(20px);
    opacity: 0.85;
}

        .mission-card h2 {
            color: #ffaad4;
            margin-bottom: 10px;
        }

        .mission-card p {
            margin: 8px 0;
            color: #e4dbe8;
        }

        .mission-card a {
            color: #ff69b4;
            text-decoration: none;
            font-weight: 500;
        }


        .back-link {
            text-align: center;
            margin-top: 40px;
        }

        .back-link a {
            color: #ffaad4;
            font-weight: 500;
            padding: 10px 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            background-color: rgba(255, 105, 180, 0.05);
            box-shadow: 0 0 10px #ffaad4;
        }
    </style>
</head>
<body class="missions-page">
    <span id="block_panel">
     <a class="panel_mis" href="index.php">Główna</a>
  <a class="panel_mis" href="missions.php">Misji</a>
    </span>
    <div class="intro-section">
        <h1>🚀 Misje Kosmiczne</h1>
        <p>
            Witamy na stronie poświęconej największym i najważniejszym misjom kosmicznym w historii ludzkości. 
            Znajdziesz tu szczegóły dotyczące startów, zaangażowanych agencji oraz celów, które mają zmienić nasze 
            spojrzenie na wszechświat. Odkryj fascynujący świat eksploracji kosmosu! ✨
        </p>
    </div>

    <?php
    $sql = "SELECT missions.id, missions.title, missions.description, missions.launch_date, missions.image_url, agencies.name AS agency 
        FROM missions 
        JOIN agencies ON missions.agency_id = agencies.id 
        ORDER BY missions.launch_date DESC";


    $stmt = $pdo->query($sql);
    $missions = $stmt->fetchAll();

    if ($missions):
        foreach ($missions as $mission): ?>
            <div class="mission-card">
    <div class="card-content">
        <img src="<?= htmlspecialchars($mission['image_url']) ?>" alt="Obraz misji" class="mission-image">
        <div class="mission-text">
            <h2><?= htmlspecialchars($mission['title']) ?></h2>
            <p><strong>Agencja:</strong> <?= htmlspecialchars($mission['agency']) ?></p>
            <p><strong>Data startu:</strong> <?= htmlspecialchars($mission['launch_date']) ?></p>
            <p><?= htmlspecialchars($mission['description']) ?></p>
            <p><a href="comments.php?mission_id=<?= $mission['id'] ?>">💬 Komentarze</a></p>
        </div>
    </div>
</div>

        <?php endforeach;
    else:
        echo "<p>Brak misji do wyświetlenia.</p>";
    endif;
    ?>

    <div class="back-link">
        <a href="index.php">⬅️ Powrót do strony głównej</a>
    </div>
</body>
</html>
