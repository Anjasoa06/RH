<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="form-section" style="margin-bottom:1.5rem">
    <h3><i class="bi bi-building" style="color:var(--forest);margin-right:6px"></i>Ajouter un département</h3>
    <form method="POST" action="/admin/departements" style="display:flex;gap:1rem">
        <input type="text" name="nom" class="f-input" placeholder="Nom du département" style="flex:1" required>
        <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Ajouter</button>
    </form>
</div>

<div class="data-card">
    <div class="data-card-head">
        <h3>Tous les départements</h3>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Nombre d'employés</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($departements as $dept): ?>
            <tr>
                <td><?= $dept['nom'] ?></td>
                <td><span style="font-family:'DM Mono',monospace;font-weight:500"><?= $dept['nb_employes'] ?></span></td>
                <td>
                    <a href="/admin/departements/edit/<?= $dept['id'] ?>" class="btn-sm btn-edit"><i class="bi bi-pencil"></i></a>
                    <a href="/admin/departements/delete/<?= $dept['id'] ?>" class="btn-sm btn-del" onclick="return confirm('Confirmer la suppression ?')"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($departements)): ?>
            <tr>
                <td colspan="3" style="text-align:center;padding:2rem;color:var(--muted)">
                    <i class="bi bi-building" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Aucun département
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
