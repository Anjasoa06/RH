<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="form-section">
    <h3><i class="bi bi-pencil" style="color:var(--forest);margin-right:6px"></i>Modifier l'employé</h3>
    <form method="POST" action="/admin/employes/update/<?= $employe['id'] ?>">
        <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group"><label class="f-label">Nom</label><input type="text" name="nom" class="f-input" value="<?= $employe['nom'] ?>" required></div>
            <div class="f-group"><label class="f-label">Email</label><input type="email" name="email" class="f-input" value="<?= $employe['email'] ?>" required></div>
            <div class="f-group"><label class="f-label">Département</label>
                <select name="departement_id" class="f-select" required>
                    <option value="">-- Choisir --</option>
                    <?php foreach ($departements as $dept): ?>
                    <option value="<?= $dept['id'] ?>" <?= $dept['id'] == $employe['departement_id'] ? 'selected' : '' ?>><?= $dept['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="f-group"><label class="f-label">Rôle</label>
                <select name="role" class="f-select" required>
                    <option value="employe" <?= $employe['role'] == 'employe' ? 'selected' : '' ?>>Employé</option>
                    <option value="rh" <?= $employe['role'] == 'rh' ? 'selected' : '' ?>>RH</option>
                    <option value="admin" <?= $employe['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
        </div>
        <div style="display:flex;gap:1rem">
            <button type="submit" class="btn-forest"><i class="bi bi-check"></i> Enregistrer</button>
            <a href="/admin/employes" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
