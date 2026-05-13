<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div style="display:flex;gap:8px;margin-bottom:1.25rem;flex-wrap:wrap">
    <button class="btn-filtre" data-filtre="all"
        style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--forest);background:var(--forest);color:var(--white);cursor:pointer">Tous
        (8)</button>
    <button class="btn-filtre" data-filtre="en_attente"
        style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer">En
        attente (4)</button>
    <button class="btn-filtre" data-filtre="approuvee"
        style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer">Approuvées
        (3)</button>
    <button class="btn-filtre" data-filtre="refusee"
        style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer">Refusées
        (1)</button>
    <select class="f-select" id="filtreDept" style="font-size:.8rem;padding:6px 10px;width:auto;margin-left:auto">
        <option value="all">Tous les départements</option>
        <option value="IT">IT</option>
        <option value="Finance">Finance</option>
        <option value="Marketing">Marketing</option>
    </select>
</div>

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
                <th>Solde dispo</th>
                <th>Statut</th>
                <th>Actions</th>
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
                            <div class="pdept"><?= $conge['dept_nom'] ?></div>
                        </div>
                    </div>
                </td>
                <td><span class="type-badge t-annuel"><?= $conge['type_nom'] ?></span></td>
                <td class="td-muted" style="font-size:.8rem"><?= date('d/m', strtotime($conge['date_debut'])) ?> – <?= date('d/m/Y', strtotime($conge['date_fin'])) ?></td>
                <td class="td-mono"><?= $conge['nb_jours'] ?> j</td>
                <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--success);font-weight:500">18 j</span> dispo</td>
                <td><span class="statut s-attente">en attente</span></td>
                <td>
                    <div class="action-btns">
                        <button class="btn-sm btn-approve" onclick="confirmerAction('approuver', <?= $conge['id'] ?>)"><i class="bi bi-check-lg"></i> Approuver</button>
                        <button class="btn-sm btn-refuse" onclick="confirmerAction('refuser', <?= $conge['id'] ?>)"><i class="bi bi-x-lg"></i> Refuser</button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($conges)): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:2rem;color:var(--muted)">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Aucune demande en attente
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function confirmerAction(action, id) {
        if (confirm(`Êtes-vous sûr de vouloir ${action === 'approuver' ? 'approuver' : 'refuser'} cette demande ?`)) {
            window.location.href = `<?= site_url('rh/traiter') ?>/${action}/${id}`;
        }
    }

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