<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="data-card">
    <div class="data-card-head">
        <h3>Historique des demandes</h3>
        <div><input type="text" class="f-input" placeholder="Rechercher..." style="width:200px;padding:6px 10px;font-size:.8rem"></div>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Type</th>
                <th>Période</th>
                <th>Durée</th>
                <th>Statut</th>
                <th>Date traitement</th>
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
                <td class="td-muted" style="font-size:.8rem"><?= date('d/m', strtotime($conge['date_debut'])) ?> - <?= date('d/m/Y', strtotime($conge['date_fin'])) ?></td>
                <td class="td-mono"><?= $conge['nb_jours'] ?> j</td>
                <td><span class="statut <?= $conge['statut'] === 'approuvee' ? 's-approuvee' : 's-refusee' ?>"><?= $conge['statut'] ?></span></td>
                <td class="td-muted"><?= date('d/m/Y', strtotime($conge['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($conges)): ?>
            <tr>
                <td colspan="6" style="text-align:center;padding:2rem;color:var(--muted)">
                    <i class="bi bi-archive" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Aucun historique
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
