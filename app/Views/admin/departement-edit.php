<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="form-section">
    <h3><i class="bi bi-pencil" style="color:var(--forest);margin-right:6px"></i>Modifier le département</h3>
    <form method="POST" action="/admin/departements/update/<?= $departement['id'] ?>">
        <div class="f-group" style="margin-bottom:1rem">
            <label class="f-label">Nom du département</label>
            <input type="text" name="nom" class="f-input" value="<?= $departement['nom'] ?>" required>
        </div>
        <div style="display:flex;gap:1rem">
            <button type="submit" class="btn-forest"><i class="bi bi-check"></i> Enregistrer</button>
            <a href="/admin/departements" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
