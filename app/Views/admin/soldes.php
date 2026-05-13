<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="form-section" style="margin-bottom:1.5rem">
    <h3><i class="bi bi-sliders" style="color:var(--forest);margin-right:6px"></i>Configuration des soldes annuels</h3>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem">
        <div class="f-group">
            <label class="f-label">Année</label>
            <input type="number" class="f-input" value="2025">
        </div>
        <div class="f-group">
            <label class="f-label">Congé annuel (jours)</label>
            <input type="number" class="f-input" value="30">
        </div>
        <div class="f-group">
            <label class="f-label">Congé maladie (jours)</label>
            <input type="number" class="f-input" value="10">
        </div>
        <button class="btn-forest" style="margin-top:1.85rem"><i class="bi bi-check"></i> Mettre à jour</button>
    </div>
</div>

<div class="data-card">
    <div class="data-card-head">
        <h3>Historique des configurations</h3>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Année</th>
                <th>Annuel</th>
                <th>Maladie</th>
                <th>Spécial</th>
                <th>Date modif</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2025</td>
                <td class="td-mono">30 j</td>
                <td class="td-mono">10 j</td>
                <td class="td-mono">5 j</td>
                <td class="td-muted">13 mai 2026</td>
            </tr>
            <tr>
                <td>2024</td>
                <td class="td-mono">30 j</td>
                <td class="td-mono">10 j</td>
                <td class="td-mono">5 j</td>
                <td class="td-muted">1 janv 2024</td>
            </tr>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
