<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<!-- Métriques -->
<?php
// Calculer les statistiques
$statsEnAttente = 0;
$statsApprouvees = 0;
$statsRefusees = 0;
$statsAnnulees = 0;

foreach ($conges as $conge) {
    if ($conge['statut'] === 'en_attente') $statsEnAttente++;
    elseif ($conge['statut'] === 'approuvee') $statsApprouvees++;
    elseif ($conge['statut'] === 'refusee') $statsRefusees++;
    elseif ($conge['statut'] === 'annulee') $statsAnnulees++;
}

// Calculer le total des jours approuvés
$totalJoursApprouves = 0;
foreach ($conges as $conge) {
    if ($conge['statut'] === 'approuvee') {
        $totalJoursApprouves += $conge['nb_jours'];
    }
}
?>
<div class="metrics">
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
        <div class="metric-val"><?= $statsEnAttente ?></div>
        <div class="metric-label">En attente</div>
    </div>
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-check-circle"></i></div></div>
        <div class="metric-val"><?= $statsApprouvees ?></div>
        <div class="metric-label">Approuvées</div>
    </div>
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-calendar-check"></i></div></div>
        <div class="metric-val"><?= array_sum(array_column($soldes, 'solde')) ?></div>
        <div class="metric-label">Jours restants</div>
        <div class="metric-sub">total tous types</div>
    </div>
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-red"><i class="bi bi-x-circle"></i></div></div>
        <div class="metric-val"><?= $statsRefusees ?></div>
        <div class="metric-label">Refusée</div>
    </div>
</div>

<!-- Soldes de congés -->
<div class="data-card">
    <div class="data-card-head"><h3>Mes soldes de congés</h3></div>
    <div style="padding:1rem 1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem">
        <?php foreach ($soldes as $solde): ?>
        <div class="solde-card" style="margin:0">
            <div class="solde-header">
                <span class="solde-type"><?= $solde['type_nom'] ?? 'Type inconnu' ?></span>
                <span class="solde-nums"><strong><?= $solde['solde'] ?></strong> j</span>
            </div>
            <div class="solde-bar">
                <div class="solde-fill" style="width:<?= ($solde['solde'] > 0 ? min(($solde['solde'] / 30) * 100, 100) : 0) ?>%"></div>
            </div>
            <div class="solde-label"><?= $solde['solde'] ?> jour(s) disponible(s)</div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($soldes)): ?>
        <div style="padding:2rem;text-align:center;color:var(--muted)">
            <i class="bi bi-info-circle" style="font-size:1.5rem;display:block;margin-bottom:.5rem;opacity:.5"></i>
            Aucun solde configuré
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Dernières demandes -->
<div class="data-card">
    <div class="data-card-head">
        <h3>Mes dernières demandes</h3>
        <a href="<?= site_url('employe/demandes') ?>" style="font-size:.8rem;color:var(--forest);text-decoration:none">Voir tout →</a>
    </div>
    <table class="tbl">
        <thead>
            <tr><th>Type</th><th>Du</th><th>Au</th><th>Durée</th><th>Statut</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php foreach ($conges as $conge): ?>
            <tr>
                <td><span class="type-badge"><?= $conge['type_nom'] ?? 'N/A' ?></span></td>
                <td class="td-muted"><?= date('d M Y', strtotime($conge['date_debut'])) ?></td>
                <td class="td-muted"><?= date('d M Y', strtotime($conge['date_fin'])) ?></td>
                <td class="td-mono"><?= $conge['nb_jours'] ?> j</td>
                <td>
                    <?php 
                    $statusClass = 'td-muted';
                    if ($conge['statut'] === 'en_attente') {
                        $statusClass = 's-attente';
                        $label = 'en attente';
                    } elseif ($conge['statut'] === 'approuvee') {
                        $statusClass = 's-approuvee';
                        $label = 'approuvée';
                    } elseif ($conge['statut'] === 'refusee') {
                        $statusClass = 's-refusee';
                        $label = 'refusée';
                    } elseif ($conge['statut'] === 'annulee') {
                        $statusClass = 's-annulee';
                        $label = 'annulée';
                    }
                    ?>
                    <span class="statut <?= $statusClass ?>"><?= $label ?? $conge['statut'] ?></span>
                </td>
                <td>
                    <?php if ($conge['statut'] === 'en_attente' || $conge['statut'] === 'approuvee'): ?>
                        <a href="/employe/annuler/<?= $conge['id'] ?>" class="btn-sm btn-cancel" onclick="return confirm('Annuler cette demande ?')"><i class="bi bi-x"></i> Annuler</a>
                    <?php else: ?>
                        <span class="td-muted" style="font-size:.75rem">—</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($conges)): ?>
            <tr>
                <td colspan="6" style="text-align:center;padding:2rem;color:var(--muted)">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Aucune demande pour le moment
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>