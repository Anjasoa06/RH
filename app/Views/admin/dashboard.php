<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="metrics">
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-people"></i></div></div>
        <div class="metric-val"><?= $total_employes ?></div>
        <div class="metric-label">Employés actifs</div>
    </div>
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
        <div class="metric-val"><?= $demandes_en_attente ?></div>
        <div class="metric-label">Demandes en attente</div>
    </div>
    <div class="metric">
        <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-calendar-check"></i></div></div>
        <div class="metric-val"><?= $demandes_approuvees ?></div>
        <div class="metric-label">Approuvées</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem">
    <div class="data-card" style="margin:0">
        <div class="data-card-head"><h3>Absents aujourd'hui</h3></div>
        <div style="padding:.75rem 1.1rem">
            <?php if (!empty($absents_aujourd_hui)): ?>
                <?php foreach ($absents_aujourd_hui as $absent): ?>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                    <div class="avatar av-green" style="width:30px;height:30px;font-size:.7rem"><?= strtoupper(substr($absent['nom'], 0, 2)) ?></div>
                    <div>
                        <div><?= $absent['nom'] ?></div>
                        <div style="font-size:.72rem;color:var(--muted)"><?= $absent['type_nom'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:var(--muted);font-size:.8rem">Aucun absent aujourd'hui</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>