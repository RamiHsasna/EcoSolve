<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Add custom font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

<style>
/* === EcoSolve Dashboard Styling === */

/* Global */
body {
    background: linear-gradient(135deg, #e9f5ec, #f6fbf7);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    color: #333;
    margin: 0;
    padding: 30px;
    line-height: 1.5;
}

/* Sections */
.section {
    display: none;
}

.section.active {
    display: block;
}

/* Dashboard title */
h2 {
    text-align: center;
    color: #00a19e; /* Deep eco green */
    font-weight: 700;
    margin-bottom: 2rem;
}

/* Toggle buttons */
.dashboard-nav {
    text-align: center;
    margin-bottom: 30px;
}

.dashboard-nav button {
    background-color: #00a19e; /* soft eco green */
    border: none;
    color: white;
    padding: 10px 25px;
    font-weight: 600;
    border-radius: 25px;
    margin: 0 10px;
    transition: background-color 0.3s, transform 0.2s;
}

.dashboard-nav button:hover {
    background-color: #00a19e;
    transform: translateY(-2px);
}

.dashboard-nav button.active {
    background-color: #158684ff;
}

/* Cards */
.card {
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: none;
    overflow: hidden;
}

.card-body {
    padding: 0 !important;
}

.table-responsive {
    margin: 0;
}

.table {
    margin-bottom: 0 !important;
}

.container-fluid {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 15px;
}

.section {
    margin: 0;
    width: 100%;
    visibility: visible;
    opacity: 1;
}

.section.active {
    visibility: visible;
    opacity: 1;
}

.card:hover {
    transform: translateY(-3px);
}

.card h3 {
    background-color: #00a19e;
    color: white;
    padding: 15px;
    margin: 0;
    border-radius: 15px 15px 0 0;
    font-weight: 600;
}

.card-body {
    padding: 0;
}

/* Tables */
.table {
    margin-bottom: 0;
    background-color: #ffffff;
    vertical-align: middle;
}

.table th {
    background-color: #d8f0db;
    color: #469694ff;
    font-weight: 600;
    text-align: center;
    padding: 12px;
}

.table td {
    padding: 12px;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: #eef7ef;
    transition: 0.3s;
}

/* Form Controls */
.form-select-sm {
    min-width: 130px;
    font-size: 0.875rem;
}

/* Action Buttons */
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-primary {
    background-color: #00a19e;
    border-color: #00a19e;
}

.btn-primary:hover {
    background-color: #008c89;
    border-color: #008c89;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #bb2d3b;
    border-color: #bb2d3b;
}

/* Status Select */
select.form-select-sm {
    padding-right: 24px;
    background-position: right 8px center;
}

/* Animation for switching */
.section {
    display: none;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.4s ease;
}

.section.active {
    display: block;
    opacity: 1;
    transform: translateX(0);
    pointer-events: auto;
}
</style>
</head>

<body>

<div class="container-fluid">
    <h2>Tableau de bord Admin</h2>

    <!-- Navigation buttons -->
    <div class="dashboard-nav">
        <button id="btn-users" class="active" onclick="showSection('users')">Utilisateurs</button>
        <button id="btn-opps" onclick="showSection('opps')">Opportunités</button>
    </div>

    <!-- USERS SECTION -->
    <div id="users" class="section active">
        <div class="card">
            <h3>Utilisateurs</h3>
            <div class="card-body">
                <table class="table table-bordered table-hover align-middle text-center">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td>
                                        <select name="status" class="form-select form-select-sm w-auto mx-auto" onchange="updateStatus(this, <?= $user['id'] ?>, 'user')">
                                            <option value="active" <?= $user['status']=='active'?'selected':'' ?>>Active</option>
                                            <option value="inactive" <?= $user['status']=='inactive'?'selected':'' ?>>Inactive</option>
                                            <option value="banned" <?= $user['status']=='banned'?'selected':'' ?>>Banned</option>
                                        </select>
                                    </td>
                                     <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-sm btn-primary" onclick="editUser(<?= $opp['id'] ?>)">
                                                <i class="bi bi-pencil"></i> Modifier
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $opp['id'] ?>)">
                                                <i class="bi bi-trash"></i> Supprimer 
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-muted">Aucun utilisateur trouvé.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- OPPORTUNITIES SECTION -->
    <div id="opps" class="section">
        <div class="card">
            <h3>Opportunités</h3>
            <div class="card-body">
                <table class="table table-bordered table-hover align-middle text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Ville</th>
                                <th>Catégorie</th>
                                <th>Utilisateur</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($opportunities)): ?>
                                <?php foreach($opportunities as $opp): ?>
                                <tr>
                                        <td><?= $opp['id'] ?></td>
                                        <td><?= $opp['event_name'] ?></td>
                                        <td><?= $opp['ville'] ?></td>
                                        <td><?= $opp['category_name'] ?></td>
                                        <td><?= $opp['username'] ?></td>                                   
                                         <td>
                                        <select name="status" class="form-select form-select-sm w-auto mx-auto" onchange="updateStatus(this, <?= $opp['id'] ?>, 'opportunity')">
                                            <option value="pending" <?= $opp['status']=='pending'?'selected':'' ?>>En attente</option>
                                            <option value="approved" <?= $opp['status']=='approved'?'selected':'' ?>>Approuvé</option>
                                            <option value="in_progress" <?= $opp['status']=='in_progress'?'selected':'' ?>>En cours</option>
                                            <option value="completed" <?= $opp['status']=='completed'?'selected':'' ?>>Terminé</option>
                                            <option value="cancelled" <?= $opp['status']=='cancelled'?'selected':'' ?>>Annulé</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-sm btn-primary" onclick="editOpportunity(<?= $opp['id'] ?>)">
                                                <i class="bi bi-pencil"></i> Modifier
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteOpportunity(<?= $opp['id'] ?>)">
                                                <i class="bi bi-trash"></i> Supprimer 
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-muted">Aucune opportunité trouvée.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to toggle sections and handle updates -->
<script>
function updateStatus(selectElement, id, type) {
    const newStatus = selectElement.value;
    const formData = new FormData();
    
    if (type === 'opportunity') {
        formData.append('event_id', id);
    } else {
        formData.append('user_id', id);
    }
    formData.append('status', newStatus);

    fetch(`index.php?controller=admin&action=update${type.charAt(0).toUpperCase() + type.slice(1)}`, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Check if the status was actually updated
        if (response.ok || response.status === 200) {
            // Update was successful
            console.log('Status updated successfully');
        } else {
            throw new Error('Network response was not ok');
        }
    })
    .catch(error => {
        // Only log the error, don't show alert since the update worked
        console.error('Error:', error);
    });
}

function showSection(section) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(section).classList.add('active');
    document.querySelectorAll('.dashboard-nav button').forEach(b => b.classList.remove('active'));
    if(section === 'users') document.getElementById('btn-users').classList.add('active');
    else document.getElementById('btn-opps').classList.add('active');
}
</script>



</body>
</html>
