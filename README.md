# Application de Gestion des Congés RH

Une application simple et efficace pour gérer les demandes de congés de vos employés.

---

## 
### 1. Installation
```bash
cd /("path racine de votre dossier")
composer install
```

### 2. Lancer l'application
```bash
php spark serve
```

Puis ouvrez votre navigateur sur : **http://localhost:8080**

---

##  Comptes de test

### Compte Admin
- **Email** : admin@example.com
- **Mot de passe** : admin123
- **Rôle** : Administrateur
- **Accès** : `/admin` - Gestion complète du système

### Compte Employé
- **Email** : employe@example.com
- **Mot de passe** : employe123
- **Rôle** : Employé
- **Accès** : `/employe` - Demande de congés

### Compte RH
- **Email** : rh@example.com
- **Mot de passe** : rh123
- **Rôle** : RH
- **Accès** : `/rh` - Approbation des demandes

---

##  Ce que vous pouvez faire

###  Si vous êtes Admin
- **Gestion des employés** : Ajouter, modifier, supprimer des employés
- **Gestion des départements** : Créer et gérer les départements
- **Types de congés** : Ajouter les types de congés (vacation, maladie, etc.)
- **Voir tous les absents** : Visualiser qui est absent aujourd'hui
- **Voir tous les soldes** : Vérifier les soldes de congés de chaque employé

###  Si vous êtes RH
- **Voir les demandes** : Lister toutes les demandes en attente
- **Approuver/Refuser** : Accepter ou refuser les demandes
- **Annuler les congés** : Annuler un congé approuvé (les jours sont recrédités)
- **Historique** : Voir tous les congés traités
- **Rapport des soldes** : Vérifier les jours disponibles par employé

###  Si vous êtes Employé
- **Demander un congé** : Soumettre une nouvelle demande
  -  Les dates doivent être **dans le futur**
  -  Vous devez avoir **assez de jours disponibles**
  -  Pas possible de demander des **congés qui se chevauchent**
- **Voir vos demandes** : Consulter l'historique de vos demandes
- **Annuler une demande** :
  - Si elle est **en attente** : simple suppression
  - Si elle est **approuvée** : les jours vous seront recrédités
- **Profil** : Voir vos infos et changer votre mot de passe

---

##  Comment ça marche les soldes ?

### Exemple concret
1. **Vous avez 25 jours** de congés annuels
2. **Vous demandez 5 jours** → État : "en attente"
3. **Le RH approuve** → **Vous perdez 5 jours** (vous en avez 20 restants)
4. **Plus tard, vous annulez** → **Vous regagnez 5 jours** (20 → 25)

### Règles importantes
-  Impossible de demander plus de jours que vous n'en avez
-  Impossible de demander pour des dates passées
-  Impossible de demander deux congés qui se chevauchent
-  Un congé "en attente" n'affecte **pas** vos jours (tant qu'il n'est pas approuvé)

---

##  Flux d'une demande

```
Employé crée une demande
        ↓
RH reçoit notification
        ↓
   Approuvé? → Congé approuvé + Solde débité
        ↓
   Refusé?  → Congé refusé + Aucun changement
        ↓
Employé peut annuler → Solde recédité (si approuvé)
```

---

##  Dépannage

### Je me suis trompé de mot de passe
- Demandez à l'admin de modifier votre compte

### Je n'ai pas de solde affiché
- L'admin doit créer le type de congé d'abord, puis l'ajouter pour vous

### Je ne peux pas annuler mon congé
- Seul le congé "approuvé" peut être annulé par l'employé
- Contactez votre RH sinon

---

##  Support

Si quelque chose ne fonctionne pas, consultez votre administrateur système.

---

