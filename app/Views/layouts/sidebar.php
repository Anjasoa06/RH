<?php
$role = session()->get('role');
$nom = session()->get('nom');
$initiales = strtoupper(substr($nom, 0, 2));
?>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
        <div class="sidebar-brand-name">
            TechMada RH
            <span>
                <?php if ($role == 'admin'): ?>Administration
                <?php elseif ($role == 'rh'): ?>Espace RH
                <?php else: ?>Espace employé
                <?php endif; ?>
            </span>
        </div>
    </div>

    <?php if ($role == 'employe'): ?>
        <div class="sidebar-section">Menu</div>
        <ul class="sidebar-nav">
            <li><a href="<?= site_url('employe') ?>"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
            <li><a href="<?= site_url('employe/create') ?>"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
            <li><a href="<?= site_url('employe/demandes') ?>"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
            <li><a href="<?= site_url('employe/profil') ?>"><i class="bi bi-person"></i> Mon profil</a></li>
        </ul>
    <?php elseif ($role == 'rh'): ?>
        <div class="sidebar-section">Menu</div>
        <ul class="sidebar-nav">
            <li><a href="<?= site_url('rh') ?>"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
            <li><a href="<?= site_url('rh/demandes') ?>"><i class="bi bi-inbox"></i> Demandes à traiter</a></li>
            <li><a href="<?= site_url('rh/historique') ?>"><i class="bi bi-archive"></i> Historique</a></li>
            <li><a href="<?= site_url('rh/soldes') ?>"><i class="bi bi-people"></i> Soldes employés</a></li>
        </ul>
    <?php elseif ($role == 'admin'): ?>
        <div class="sidebar-section">Gestion</div>
        <ul class="sidebar-nav">
            <li><a href="<?= site_url('admin') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
            <li><a href="<?= site_url('admin/demandes') ?>"><i class="bi bi-inbox"></i> Toutes les demandes</a></li>
            <li><a href="<?= site_url('admin/employes') ?>"><i class="bi bi-people"></i> Employés</a></li>
            <li><a href="<?= site_url('admin/departements') ?>"><i class="bi bi-building"></i> Départements</a></li>
            <li><a href="<?= site_url('admin/types-conge') ?>"><i class="bi bi-tags"></i> Types de congé</a></li>
            <li><a href="<?= site_url('admin/soldes') ?>"><i class="bi bi-sliders"></i> Soldes annuels</a></li>
        </ul>
    <?php endif; ?>

    <div class="sidebar-user">
        <div class="s-user-row">
            <div class="avatar av-green"><?= $initiales ?></div>
            <div>
                <div class="user-name"><?= $nom ?></div>
                <div class="user-role">
                    <?php if ($role == 'admin'): ?>Admin système
                    <?php elseif ($role == 'rh'): ?>Responsable RH
                    <?php else: ?>Employé
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?= site_url('logout') ?>" style="margin-left:auto;color:rgba(255,255,255,.25);font-size:1.1rem"
                title="Déconnexion">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
</aside>