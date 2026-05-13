<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="form-section">
    <h3><i class="bi bi-pencil" style="color:var(--forest);margin-right:6px"></i>Modifier le type de congé</h3>
    <form method="POST" action="/admin/types-conge/update/<?= $type['id'] ?>">
        <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group">
                <label class="f-label">Nom du type</label>
                <input type="text" name="nom" class="f-input" value="<?= $type['nom'] ?>" required>
            </div>
            <div class="f-group">
                <label class="f-label">Jours par an</label>
                <input type="number" name="jours_par_an" class="f-input" value="<?= $type['jours_par_an'] ?>" required>
            </div>
        </div>
        <div style="display:flex;gap:1rem">
            <button type="submit" class="btn-forest"><i class="bi bi-check"></i> Enregistrer</button>
            <a href="/admin/types-conge" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
