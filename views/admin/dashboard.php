<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* === EcoSolve Dashboard Styling === */

/* Global */
body {
    background: linear-gradient(135deg, #e9f5ec, #f6fbf7);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
    margin: 0;
    padding: 30px;
}

/* Dashboard title */
h2 {
    text-align: center;
    color: #2e7d32; /* Deep eco green */
    font-weight: 700;
    margin-bottom: 2rem;
}

/* Toggle buttons */
.dashboard-nav {
    text-align: center;
    margin-bottom: 30px;
}

.dashboard-nav button {
    background-color: #6fbf73; /* soft eco green */
    border: none;
    color: white;
    padding: 10px 25px;
    font-weight: 600;
    border-radius: 25px;
    margin: 0 10px;
    transition: background-color 0.3s, transform 0.2s;
}

.dashboard-nav button:hover {
    background-color: #5aa55e;
    transform: translateY(-2px);
}

.dashboard-nav button.active {
    background-color: #4b8b4b;
}

/* Cards */
.card {
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: none;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
}

.card h3 {
    background-color: #6fbf73;
    color: white;
    padding: 15px;
    margin: 0;
    border-radius: 15px 15px 0 0;
    font-weight: 600;
}

/* Tables */
.table {
    margin-bottom: 0;
    background-color: #ffffff;
}

.table th {
    background-color: #d8f0db;
    color: #2e7d32;
    font-weight: 600;
}

.table tbody tr:hover {
    background-color: #eef7ef;
    transition: 0.3s;
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
                                    <td><?= ucfirst($user['status']) ?></td>
                                    <td>
                                        <form method="POST" action="index.php?controller=admin&action=updateUser" style="display:inline-block">
                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="active" <?= $user['status']=='active'?'selected':'' ?>>Active</option>
                                                <option value="inactive" <?= $user['status']=='inactive'?'selected':'' ?>>Inactive</option>
                                                <option value="banned" <?= $user['status']=='banned'?'selected':'' ?>>Banned</option>
                                            </select>
                                        </form>
                                    </td>
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
                                    <td><?= ucfirst(str_replace('_', ' ', $opp['status'])) ?></td>
                                    <td>
                                        <form method="POST" action="index.php?controller=admin&action=updateOpportunity">
                                            <input type="hidden" name="event_id" value="<?= $opp['id'] ?>">
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="pending" <?= $opp['status']=='pending'?'selected':'' ?>>Pending</option>
                                                <option value="approved" <?= $opp['status']=='approved'?'selected':'' ?>>Approved</option>
                                                <option value="in_progress" <?= $opp['status']=='in_progress'?'selected':'' ?>>In Progress</option>
                                                <option value="completed" <?= $opp['status']=='completed'?'selected':'' ?>>Completed</option>
                                                <option value="cancelled" <?= $opp['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-muted">Aucune opportunité trouvée.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to toggle sections -->
<script>
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
