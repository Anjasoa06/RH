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
            <tr><th>Type</th><th>Début</th><th>Fin</th><th>Durée</th><th>Statut</th><th>Commentaire RH</th><th>Action</th></tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="type-badge t-annuel">Annuel</span></td>
                <td class="td-muted">23 juin 2025</td>
                <td class="td-muted">27 juin 2025</td>
                <td class="td-mono">5 j</td>
                <td><span class="statut s-attente">en attente</span></td>
                <td class="td-muted" style="font-size:.78rem">—</td>
                <td><button class="btn-sm btn-cancel" onclick="return confirm('Annuler cette demande ?')"><i class="bi bi-x"></i> Annuler</button></td>
            </tr>
            <tr>
                <td><span class="type-badge t-maladie">Maladie</span></td>
                <td class="td-muted">2 juin 2025</td>
                <td class="td-muted">3 juin 2025</td>
                <td class="td-mono">2 j</td>
                <td><span class="statut s-approuvee">approuvée</span></td>
                <td style="font-size:.78rem;color:var(--success)"><i class="bi bi-check-circle"></i> Validé</td>
                <td><span class="td-muted" style="font-size:.75rem">—</span></td>
            </tr>
            <tr>
                <td><span class="type-badge t-special">Spécial</span></td>
                <td class="td-muted">5 avr. 2025</td>
                <td class="td-muted">5 avr. 2025</td>
                <td class="td-mono">1 j</td>
                <td><span class="statut s-refusee">refusée</span></td>
                <td style="font-size:.78rem;color:var(--danger)">Chevauchement détecté</td>
                <td><span class="td-muted" style="font-size:.75rem">—</span></td>
            </tr>
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