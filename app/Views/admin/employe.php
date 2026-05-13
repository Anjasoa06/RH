<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<!-- Formulaire ajout -->
<div class="form-section">
    <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>Ajouter un employé</h3>
    <form method="POST" action="/admin/employes">
        <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group"><label class="f-label">Nom</label><input type="text" name="nom" class="f-input" placeholder="Jean Rakoto" required></div>
            <div class="f-group"><label class="f-label">Email</label><input type="email" name="email" class="f-input" placeholder="jean@techmada.mg" required></div>
            <div class="f-group"><label class="f-label">Mot de passe</label><input type="password" name="password" class="f-input" placeholder="••••••" required></div>
            <div class="f-group"><label class="f-label">Département</label>
                <select name="departement_id" class="f-select" required>
                    <option value="">-- Choisir --</option>
                    <?php foreach ($departements ?? [] as $dept): ?>
                    <option value="<?= $dept['id'] ?>"><?= $dept['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="f-group"><label class="f-label">Rôle</label><select name="role" class="f-select" required><option value="employe">Employé</option><option value="rh">RH</option><option value="admin">Admin</option></select></div>
        </div>
        <div class="flash flash-info" style="margin-bottom:1rem"><i class="bi bi-info-circle-fill"></i> Les soldes seront initialisés automatiquement.</div>
        <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Créer l'employé</button>
    </form>
</div>

<!-- Liste employés -->
<div class="data-card">
    <div class="data-card-head">
        <h3>Tous les employés</h3>
        <div><input type="text" class="f-input" placeholder="Rechercher..." style="width:200px;padding:6px 10px;font-size:.8rem"></div>
    </div>
    <table class="tbl">
        <thead><tr><th>Employé</th><th>Département</th><th>Rôle</th><th>Email</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($employes as $employe): ?>
            <tr>
                <td>
                    <div class="profile-row">
                        <div class="avatar av-green" style="width:32px;height:32px"><?= strtoupper(substr($employe['nom'], 0, 2)) ?></div>
                        <div>
                            <div><?= $employe['nom'] ?></div>
                            <div style="font-size:.7rem;color:var(--muted)"><?= $employe['email'] ?></div>
                        </div>
                    </div>
                </td>
                <td><?= $employe['dept_nom'] ?></td>
                <td><span class="type-badge"><?= $employe['role'] ?></span></td>
                <td style="font-size:.8rem"><?= $employe['email'] ?></td>
                <td>
                    <a href="/admin/employes/edit/<?= $employe['id'] ?>" class="btn-sm btn-edit"><i class="bi bi-pencil"></i></a>
                    <a href="/admin/employes/delete/<?= $employe['id'] ?>" class="btn-sm btn-del" onclick="return confirm('Confirmer la suppression ?')"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($employes)): ?>
            <tr>
                <td colspan="5" style="text-align:center;padding:2rem;color:var(--muted)">
                    <i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Aucun employé trouvé
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>