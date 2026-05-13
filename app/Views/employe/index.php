<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="data-card">
    <div class="data-card-head">
        <h3>Toutes mes demandes</h3>
        <div style="display:flex;gap:6px">
            <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto" id="filtreStatut">
                <option value="all">Tous les statuts</option>
                <option value="en_attente">En attente</option>
                <option value="approuvee">Approuvée</option>
                <option value="refusee">Refusée</option>
                <option value="annulee">Annulée</option>
            </select>
        </div>
    </div>
    <table class="tbl">
        <thead>
            <tr><th>Type</th><th>Début</th><th>Fin</th><th>Durée</th><th>Statut</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php foreach ($conges as $conge): ?>
            <tr class="row-<?= $conge['statut'] ?>">
                <td><span class="type-badge t-annuel"><?= $conge['type_nom'] ?? 'N/A' ?></span></td>
                <td class="td-muted"><?= date('d M Y', strtotime($conge['date_debut'])) ?></td>
                <td class="td-muted"><?= date('d M Y', strtotime($conge['date_fin'])) ?></td>
                <td class="td-mono"><?= $conge['nb_jours'] ?> j</td>
                <td><span class="statut <?= strpos($conge['statut'], 'attente') ? 's-attente' : (strpos($conge['statut'], 'approuv') ? 's-approuvee' : 's-refusee') ?>"><?= ucfirst($conge['statut']) ?></span></td>
                <td>
                    <?php if ($conge['statut'] === 'en_attente'): ?>
                    <button class="btn-sm btn-cancel" onclick="return confirm('Annuler cette demande ?')"><i class="bi bi-x"></i> Annuler</button>
                    <?php else: ?>
                    <span class="td-muted" style="font-size:.75rem">—</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($conges)): ?>
            <tr>
                <td colspan="6" style="text-align:center;padding:2rem;color:var(--muted)">
                    <i class="bi bi-calendar2-week" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Aucune demande de congé
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    document.getElementById('filtreStatut').addEventListener('change', function() {
        let rows = document.querySelectorAll('.tbl tbody tr');
        rows.forEach(row => {
            let statut = row.querySelector('.statut')?.innerText.toLowerCase();
            if (this.value === 'all' || statut === this.value.replace('_', ' ')) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?>