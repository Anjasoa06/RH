<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<!-- Formulaire ajout -->
<div class="form-section">
    <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>Ajouter un employé</h3>
    <div class="form-grid-2" style="margin-bottom:1rem">
        <div class="f-group"><label class="f-label">Nom</label><input type="text" class="f-input" placeholder="Jean Rakoto"></div>
        <div class="f-group"><label class="f-label">Email</label><input type="email" class="f-input" placeholder="jean@techmada.mg"></div>
        <div class="f-group"><label class="f-label">Mot de passe</label><input type="password" class="f-input" placeholder="••••••"></div>
        <div class="f-group"><label class="f-label">Département</label><select class="f-select"><option>IT</option><option>Finance</option><option>Marketing</option><option>RH</option></select></div>
        <div class="f-group"><label class="f-label">Rôle</label><select class="f-select"><option value="employe">Employé</option><option value="rh">RH</option><option value="admin">Admin</option></select></div>
        <div class="f-group"><label class="f-label">Date d'embauche</label><input type="date" class="f-input"></div>
    </div>
    <div class="flash flash-info" style="margin-bottom:1rem"><i class="bi bi-info-circle-fill"></i> Les soldes seront initialisés automatiquement.</div>
    <button class="btn-forest"><i class="bi bi-plus"></i> Créer l'employé</button>
</div>

<!-- Liste employés -->
<div class="data-card">
    <div class="data-card-head">
        <h3>Tous les employés</h3>
        <div><input type="text" class="f-input" placeholder="Rechercher..." style="width:200px;padding:6px 10px;font-size:.8rem"></div>
    </div>
    <table class="tbl">
        <thead><tr><th>Employé</th><th>Département</th><th>Rôle</th><th>Solde annuel</th><th>Actions</th></tr></thead>
        <tbody>
            <tr><td><div class="profile-row"><div class="avatar av-green" style="width:32px;height:32px">SR</div><div><div>Soa Rakoto</div><div>soa@techmada.mg</div></div></div></td><td>IT</td><td><span class="type-badge">employe</span></td><td><span style="font-family:'DM Mono',monospace">18 / 30 j</span></td><td><button class="btn-sm btn-edit"><i class="bi bi-pencil"></i></button> <button class="btn-sm btn-del"><i class="bi bi-trash"></i></button></td></tr>
            <tr><td><div class="profile-row"><div class="avatar av-blue" style="width:32px;height:32px">MR</div><div><div>Marie Rabe</div><div>rh@techmada.mg</div></div></div></td><td>RH</td><td><span class="type-badge t-maladie">rh</span></td><td><span style="font-family:'DM Mono',monospace">25 / 30 j</span></td><td><button class="btn-sm btn-edit"><i class="bi bi-pencil"></i></button><button class="btn-sm btn-del"><i class="bi bi-trash"></i></button></td></tr>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>