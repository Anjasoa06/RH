<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="data-card">
    <div class="data-card-head">
        <h3>Soldes des employés - 2025</h3>
        <div style="display:flex;gap:8px">
            <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto" id="filtreDept">
                <option value="">Tous les départements</option>
            </select>
        </div>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Département</th>
                <th>Congé annuel</th>
                <th>Congé maladie</th>
                <th>Congé sans solde</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($soldes as $solde): ?>
            <tr>
                <td>
                    <div class="profile-row">
                        <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem"><?= strtoupper(substr($solde['employe_nom'], 0, 2)) ?></div>
                        <div class="profile-info">
                            <div class="pname"><?= $solde['employe_nom'] ?></div>
                        </div>
                    </div>
                </td>
                <td><?= $solde['dept_nom'] ?></td>
                <td><span style="font-family:'DM Mono',monospace;font-size:.8rem"><?= $solde['type_nom'] === 'Congé payé' ? $solde['solde'] . ' j' : '-' ?></span></td>
                <td><span style="font-family:'DM Mono',monospace;font-size:.8rem"><?= $solde['type_nom'] === 'Congé maladie' ? $solde['solde'] . ' j' : '-' ?></span></td>
                <td><span style="font-family:'DM Mono',monospace;font-size:.8rem">-</span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($soldes)): ?>
            <tr>
                <td colspan="5" style="text-align:center;padding:2rem;color:var(--muted)">
                    <i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Aucune donnée de solde disponible
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
