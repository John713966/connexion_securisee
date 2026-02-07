<?php
session_start();
require_once "traitement/connexion.php";

// Check if user is logged in
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header("location: index.html");
    exit();
}

// Get user information from database
$user_id = $_SESSION['id_user'];
$username = $_SESSION['username'] ?? 'User';

try {
    $stmt = $pdo->prepare("SELECT id_users, username, email, created_at FROM users WHERE id_users = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch();
    
    if (!$user) {
        // User not found in database, redirect to login
        session_destroy();
        header("location: index.html");
        exit();
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $user = null;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo htmlspecialchars($username); ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #1a252f 100%);
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
        }
        .stat-card.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        .stat-card.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stat-card.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            font-weight: bold;
        }
        .logout-btn {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .logout-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(231, 76, 60, 0.4);
        }
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 30px;
        }
        .activity-item {
            padding: 15px;
            border-left: 3px solid #667eea;
            background: #f8f9fa;
            margin: 10px 0;
            border-radius: 0 8px 8px 0;
        }
        .quick-action-btn {
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            border: 2px solid #e9ecef;
        }
        .quick-action-btn:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }
        .quick-action-btn i {
            font-size: 32px;
            margin-bottom: 10px;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse show" id="sidebarMenu">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <div class="user-avatar mx-auto mb-3">
                            <?php echo strtoupper(substr($username, 0, 1)); ?>
                        </div>
                        <h5><?php echo htmlspecialchars($username); ?></h5>
                        <small class="text-muted">Connecté</small>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i>📊</i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i>👤</i> Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i>⚙️</i> Paramètres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i>📁</i> Fichiers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i>📈</i> Rapports
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link" href="/traitement/logout.php">
                                <i>🚪</i> Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Bar -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-white p-3 rounded">
                    <h1 class="h4">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Partager</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Exporter</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle">
                            <i>📅</i> Cette semaine
                        </button>
                    </div>
                </div>

                <!-- Welcome Banner -->
                <div class="welcome-banner mb-4">
                    <h2>Bienvenue, <?php echo htmlspecialchars($username); ?>! 👋</h2>
                    <p class="mb-0">Nous sommes heureux de vous revoir. Voici un aperçu de votre activité.</p>
                </div>

                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Utilisateurs</h5>
                                <h2 class="display-4">1,234</h2>
                                <p class="card-text"><i class="arrow-up">↑</i> 12% cette semaine</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card success h-100">
                            <div class="card-body">
                                <h5 class="card-title">Ventes</h5>
                                <h2 class="display-4">€4,567</h2>
                                <p class="card-text"><i class="arrow-up">↑</i> 8% cette semaine</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card warning h-100">
                            <div class="card-body">
                                <h5 class="card-title">Commandes</h5>
                                <h2 class="display-4">89</h2>
                                <p class="card-text"><i class="arrow-down">↓</i> 3% cette semaine</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card info h-100">
                            <div class="card-body">
                                <h5 class="card-title">Visites</h5>
                                <h2 class="display-4">23,456</h2>
                                <p class="card-text"><i class="arrow-up">↑</i> 15% cette semaine</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Profile Card -->
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i>👤</i> Profil Utilisateur</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="user-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 40px;">
                                    <?php echo strtoupper(substr($username, 0, 1)); ?>
                                </div>
                                <h4><?php echo htmlspecialchars($username); ?></h4>
                                <p class="text-muted">Membre depuis <?php echo isset($user['created_at']) ? date('Y', strtotime($user['created_at'])) : date('Y'); ?></p>
                                <hr>
                                <div class="text-start">
                                    <p><strong><i>📧</i> Email:</strong> <?php echo isset($user['email']) ? htmlspecialchars($user['email']) : 'Non défini'; ?></p>
                                    <p><strong>🆔 ID:</strong> <?php echo $user_id; ?></p>
                                    <p><strong>📅 Dernière connexion:</strong> <?php echo date('d/m/Y H:i'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i>⚡</i> Actions Rapides</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="quick-action-btn">
                                            <i>➕</i>
                                            <p class="mb-0">Nouvelle Commande</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="quick-action-btn">
                                            <i>👥</i>
                                            <p class="mb-0">Ajouter Utilisateur</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="quick-action-btn">
                                            <i>📊</i>
                                            <p class="mb-0">Voir Statistiques</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="quick-action-btn">
                                            <i>📁</i>
                                            <p class="mb-0">Gérer Fichiers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i>🕐</i> Activité Récente</h5>
                            </div>
                            <div class="card-body">
                                <div class="activity-item">
                                    <strong>Connexion réussie</strong>
                                    <br><small class="text-muted">Aujourd'hui à <?php echo date('H:i'); ?></small>
                                </div>
                                <div class="activity-item">
                                    <strong>Mise à jour du profil</strong>
                                    <br><small class="text-muted">Hier à 14:30</small>
                                </div>
                                <div class="activity-item">
                                    <strong>Nouvelle commande #1234</strong>
                                    <br><small class="text-muted">Il y a 2 jours</small>
                                </div>
                                <div class="activity-item">
                                    <strong>Téléchargement de rapport</strong>
                                    <br><small class="text-muted">Il y a 3 jours</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i>💻</i> État du Système</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Serveur</span>
                                        <span class="text-success">En ligne</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 98%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Base de données</span>
                                        <span class="text-success">Opérationnelle</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 99%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Stockage</span>
                                        <span class="text-warning">75% utilisé</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Mémoire</span>
                                        <span class="text-info">45% utilisé</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 45%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="mt-5 mb-3 text-center text-muted">
                    <p>&copy; <?php echo date('Y'); ?> Votre Application. Tous droits réservés.</p>
                    <p><small>Développé avec ❤️ et PHP</small></p>
                </footer>
            </main>
        </div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

