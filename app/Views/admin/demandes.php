<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="data-card">
    <div class="data-card-head">
        <h3>Toutes les demandes</h3>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Type</th>
                <th>Période</th>
                <th>Durée</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($conges as $conge): ?>
            <tr>
                <td>
                    <div class="profile-row">
                        <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem"><?= strtoupper(substr($conge['employe_nom'], 0, 2)) ?></div>
                        <div class="profile-info">
                            <div class="pname"><?= $conge['employe_nom'] ?></div>
                        </div>
                    </div>
                </td>
                <td><span class="type-badge t-annuel"><?= $conge['type_nom'] ?></span></td>
                <td class="td-muted" style="font-size:.8rem"><?= date('d/m', strtotime($conge['date_debut'])) ?> – <?= date('d/m/Y', strtotime($conge['date_fin'])) ?></td>
                <td class="td-mono"><?= $conge['nb_jours'] ?> j</td>
                <td><span class="statut <?= strpos($conge['statut'], 'attente') ? 's-attente' : (strpos($conge['statut'], 'approuv') ? 's-approuvee' : 's-refusee') ?>"><?= ucfirst($conge['statut']) ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($conges)): ?>
            <tr>
                <td colspan="5" style="text-align:center;padding:2rem;color:var(--muted)">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Aucune demande
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.btn-filtre').forEach(btn => {
        btn.addEventListener('click', function () {
            let filtre = this.dataset.filtre;
            document.querySelectorAll('.tbl tbody tr').forEach(row => {
                let statut = row.querySelector('.statut')?.innerText.toLowerCase().replace(' ', '_');
                if (filtre === 'all' || statut === filtre) row.style.display = '';
                else row.style.display = 'none';
            });
            document.querySelectorAll('.btn-filtre').forEach(b => {
                b.style.background = 'var(--white)'; b.style.color = 'var(--muted)'; b.style.borderColor = 'var(--border)';
            });
            this.style.background = 'var(--forest)'; this.style.color = 'var(--white)'; this.style.borderColor = 'var(--forest)';
        });
    });
</script>
<?= $this->endSection() ?>
