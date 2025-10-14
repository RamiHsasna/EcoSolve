<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        h2 { margin-bottom: 30px; }
        .card {
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .card h3 {
            background-color: #0d6efd;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }
        .table th {
            background-color: #e9ecef;
        }
    </style>
</head>
<body class="p-4">

    <div class="container-fluid">
        <h2 class="text-center mb-4">Dashboard Admin</h2>

        <div class="row">
            <!-- Utilisateurs -->
            <div class="col-md-6">
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

            <!-- Opportunités -->
            <div class="col-md-6">
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
    </div>

</body>
</html>
