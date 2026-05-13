<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<form action="<?= site_url('employe/create') ?>" method="post">
    <?= csrf_field() ?>
    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start" class="form-layout">

        <!-- Formulaire principal -->
        <div>
            <div class="form-section">
                <h3>Détails de la demande</h3>

                <div class="f-group" style="margin-bottom:1rem">
                    <label class="f-label">Type de congé <span style="color:var(--danger)">*</span></label>
                    <select class="f-select" name="type_conge_id" required>
                        <option value="">-- Choisir un type --</option>
                        <?php foreach ($types_conge as $type): ?>
                        <option value="<?= $type['id'] ?>">
                            <?= $type['nom'] ?> 
                            <?php 
                                $solde = array_filter($soldes, fn($s) => $s['type_conge_id'] === $type['id']);
                                if (!empty($solde)) {
                                    $s = reset($solde);
                                    echo '(' . $s['solde'] . ' j restants)';
                                }
                            ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-grid-2" style="margin-bottom:1rem">
                    <div class="f-group">
                        <label class="f-label">Date de début <span style="color:var(--danger)">*</span></label>
                        <input type="date" class="f-input" name="date_debut" required>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Date de fin <span style="color:var(--danger)">*</span></label>
                        <input type="date" class="f-input" name="date_fin" required>
                    </div>
                </div>

                <div class="f-computed" id="joursCalcules">
                    <div class="f-computed-num" id="nbJours">0</div>
                    <div class="f-computed-label">jours calendaires calculés<br><span style="font-size:.7rem;opacity:.7" id="periodeInfo"></span></div>
                </div>

                <div class="f-group" style="margin-bottom:1rem">
                    <label class="f-label">Motif (optionnel)</label>
                    <textarea class="f-textarea" name="motif" placeholder="Précisez le motif de votre demande si nécessaire..."></textarea>
                    <div class="f-hint">Le motif est visible par le responsable RH.</div>
                </div>

                <div class="form-actions">
                    <button class="btn-forest" type="submit"><i class="bi bi-send"></i> Soumettre la demande</button>
                    <a href="<?= site_url('employe') ?>" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
                </div>
            </div>
        </div>

        <!-- Panneau latéral -->
        <div style="display:flex;flex-direction:column;gap:1rem">
            <div class="data-card" style="margin:0">
                <div class="data-card-head"><h3><i class="bi bi-piggy-bank" style="color:var(--forest);margin-right:5px"></i>Vos soldes actuels</h3></div>
                <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.75rem">
                    <?php foreach ($soldes as $solde): ?>
                    <div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:4px">
                            <span style="font-size:.8rem"><?= $solde['type_nom'] ?></span>
                            <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:var(--forest);font-weight:500"><?= $solde['solde'] ?> j</span>
                        </div>
                        <div class="solde-bar"><div class="solde-fill" style="width:<?= min($solde['solde'] * 5, 100) ?>%"></div></div>
                    </div>
                    <?php endforeach; ?>
                    <?php if (empty($soldes)): ?>
                    <p style="font-size:.8rem;color:var(--muted)">Aucun solde disponible</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flash flash-info" style="margin:0">
                <i class="bi bi-info-circle-fill"></i>
                <span style="font-size:.8rem">Le solde est déduit uniquement à l'approbation de votre responsable.</span>
            </div>
            <div style="background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:.85rem 1rem">
                <div style="font-size:.78rem;font-weight:500;margin-bottom:.5rem"><i class="bi bi-clipboard-check" style="color:var(--forest);margin-right:5px"></i>Rappel des règles</div>
                <ul style="margin:0;padding-left:1rem;font-size:.75rem;color:var(--muted);line-height:1.7">
                    <li>Préavis minimum : 48h avant la date de début</li>
                    <li>Pas de chevauchement avec une demande en cours</li>
                    <li>Solde insuffisant = demande refusée automatiquement</li>
                </ul>
            </div>
        </div>
    </div>
</form>

<script>
    function calculerJours() {
        let debut = document.querySelector('[name="date_debut"]').value;
        let fin = document.querySelector('[name="date_fin"]').value;
        if (debut && fin) {
            let d1 = new Date(debut);
            let d2 = new Date(fin);
            let diffTime = Math.abs(d2 - d1);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            document.getElementById('nbJours').innerText = diffDays;
            document.getElementById('periodeInfo').innerText = 'du ' + new Date(debut).toLocaleDateString('fr-FR') + ' au ' + new Date(fin).toLocaleDateString('fr-FR');
        }
    }
    document.querySelector('[name="date_debut"]').addEventListener('change', calculerJours);
    document.querySelector('[name="date_fin"]').addEventListener('change', calculerJours);
</script>
<?= $this->endSection() ?>