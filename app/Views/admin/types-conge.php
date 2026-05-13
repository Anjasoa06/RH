<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="form-section" style="margin-bottom:1.5rem">
    <h3><i class="bi bi-tags" style="color:var(--forest);margin-right:6px"></i>Ajouter un type de congé</h3>
    <form method="POST" action="/admin/types-conge" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem">
        <input type="text" name="nom" class="f-input" placeholder="Nom du type" required>
        <input type="number" name="jours_par_an" class="f-input" placeholder="Jours par an" value="30" required>
        <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Ajouter</button>
    </form>
</div>

<div class="data-card">
    <div class="data-card-head">
        <h3>Types de congé</h3>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Type</th>
                <th>Jours/an</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($types_conge as $type): ?>
            <tr>
                <td><?= $type['nom'] ?></td>
                <td class="td-mono"><?= $type['jours_par_an'] ?> j</td>
                <td>
                    <a href="/admin/types-conge/edit/<?= $type['id'] ?>" class="btn-sm btn-edit"><i class="bi bi-pencil"></i></a>
                    <a href="/admin/types-conge/delete/<?= $type['id'] ?>" class="btn-sm btn-del" onclick="return confirm('Confirmer la suppression ?')"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($types_conge)): ?>
            <tr>
                <td colspan="3" style="text-align:center;padding:2rem;color:var(--muted)">
                    <i class="bi bi-tags" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Aucun type de congé
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
