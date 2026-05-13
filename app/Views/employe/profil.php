<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div style="display:grid;grid-template-columns:1fr 350px;gap:1.5rem">
    <div class="form-section">
        <h3>Informations personnelles</h3>
        <div class="form-grid-2">
            <div class="f-group">
                <label class="f-label">Nom complet</label>
                <input type="text" class="f-input" value="Soa Rakoto" readonly disabled>
            </div>
            <div class="f-group">
                <label class="f-label">Email</label>
                <input type="email" class="f-input" value="jean@rh.mg" readonly disabled>
            </div>
            <div class="f-group">
                <label class="f-label">Département</label>
                <input type="text" class="f-input" value="IT" readonly disabled>
            </div>
            <div class="f-group">
                <label class="f-label">Rôle</label>
                <input type="text" class="f-input" value="Employé" readonly disabled>
            </div>
            <div class="f-group">
                <label class="f-label">Date d'embauche</label>
                <input type="text" class="f-input" value="2022-03-01" readonly disabled>
            </div>
        </div>
    </div>

    <div>
        <div class="data-card" style="margin:0">
            <div class="data-card-head"><h3>Changer le mot de passe</h3></div>
            <div style="padding:1.25rem">
                <form action="<?= site_url('employe/changerMotDePasse') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="f-group">
                        <label class="f-label">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="f-input" required>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Nouveau mot de passe</label>
                        <input type="password" name="new_password" class="f-input" required>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Confirmer</label>
                        <input type="password" name="confirm_password" class="f-input" required>
                    </div>
                    <button type="submit" class="btn-forest">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>