<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Événements Écologiques Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #e9f5ec, #f6fbf7);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            padding: 30px;
        }

        h1 {
            text-align: center;
            color: #00a19e;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .event-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            color: #00a19e;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .card-text {
            color: #555;
            line-height: 1.6;
        }

        .text-muted {
            color: #777 !important;
        }

        .bi {
            margin-right: 0.5rem;
        }

        .location-text {
            font-weight: 500;
            color: #00a19e !important;
        }
    </style>
</head>

<body>
    <h1>Événements Écologiques Disponibles</h1>
    <div class="event-container">
        <?php
        require_once __DIR__ . '/../controllers/EcoEventController.php';

        $controller = new EcoEventController();
        $events = $controller->getAllEvents();

        if (empty($events)) {
            echo '<p class="text-center">Aucun événement disponible pour le moment.</p>';
        } else {
            echo '<div class="row">';
            foreach ($events as $event) {
                echo '<div class="col-md-3 mb-4">';
                echo '<div class="card h-100">';
                echo '<div class="card-body d-flex flex-column">';
                echo '<h5 class="card-title">' . htmlspecialchars($event['event_name']) . '</h5>';
                echo '<p class="card-text flex-grow-1">' . htmlspecialchars($event['description']) . '</p>';
                echo '<div class="mt-auto">';
                echo '<p class="mb-1"><small class="text-muted location-text"><i class="bi bi-geo-alt"></i> ' . htmlspecialchars($event['ville'] . ', ' . $event['pays']) . '</small></p>';
                echo '<p class="mb-1"><small class="text-muted"><i class="bi bi-calendar"></i> ' . date('Y-m-d', strtotime($event['event_date'])) . '</small></p>';
                echo '<p class="mb-0"><small class="text-muted"><i class="bi bi-tag"></i> ' . htmlspecialchars($event['category_name']) . '</small></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>
</body>

</html>