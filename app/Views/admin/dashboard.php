<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="metrics">
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-people"></i></div></div>
        <div class="metric-val">24</div>
        <div class="metric-label">Employés actifs</div>
        <div class="metric-sub up"><i class="bi bi-arrow-up-short"></i> +2 ce mois</div>
    </div>
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
        <div class="metric-val">4</div>
        <div class="metric-label">Demandes en attente</div>
    </div>
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-calendar-check"></i></div></div>
        <div class="metric-val">31</div>
        <div class="metric-label">Approuvées ce mois</div>
    </div>
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-blue"><i class="bi bi-building"></i></div></div>
        <div class="metric-val">4</div>
        <div class="metric-label">Départements</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem">
    <div class="data-card" style="margin:0">
        <div class="data-card-head"><h3>Demandes récentes</h3><a href="<?= site_url('rh') ?>" style="font-size:.8rem;color:var(--forest);text-decoration:none">Tout voir →</a></div>
        <table class="tbl">
            <thead><tr><th>Employé</th><th>Type</th><th>Durée</th><th>Statut</th></tr></thead>
            <tbody>
                <tr><td><div class="profile-row"><div class="avatar av-green" style="width:28px;height:28px;font-size:.62rem">SR</div><span>Soa Rakoto</span></div></td><td><span class="type-badge t-annuel">Annuel</span></td><td class="td-mono">5 j</td><td><span class="statut s-attente">en attente</span></td></tr>
                <tr><td><div class="profile-row"><div class="avatar av-amber" style="width:28px;height:28px;font-size:.62rem">TF</div><span>Tsiry Fidy</span></div></td><td><span class="type-badge t-maladie">Maladie</span></td><td class="td-mono">2 j</td><td><span class="statut s-attente">en attente</span></td></tr>
            </tbody>
        </table>
    </div>

    <div>
        <div class="data-card" style="margin:0 0 1rem 0">
            <div class="data-card-head"><h3>Absents aujourd'hui</h3></div>
            <div style="padding:.75rem 1.1rem">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px"><div class="avatar av-green" style="width:30px;height:30px">SR</div><div><div>Soa Rakoto</div><div style="font-size:.72rem;color:var(--muted)">Congé annuel</div></div></div>
                <div style="display:flex;align-items:center;gap:8px"><div class="avatar av-amber" style="width:30px;height:30px">TF</div><div><div>Tsiry Fidy</div><div style="font-size:.72rem;color:var(--muted)">Maladie</div></div></div>
            </div>
        </div>
        <div class="flash flash-warn" style="margin:0"><i class="bi bi-exclamation-triangle-fill"></i><span>2 employés ont un solde critique.</span></div>
    </div>
</div>
<?= $this->endSection() ?>