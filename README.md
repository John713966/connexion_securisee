# Application de Connexion PHP
# Notez bien la page main.php est generer par IA
## Description
Cette application est un système de connexion sécurisé développé en PHP avec une interface utilisateur moderne.

## ⚠️ Note Importante
**La page `main.php` (dashboard) a été générée par intelligence artificielle (AI).** Elle contient une interface complète avec :
- Authentification par session
- Connexion à la base de données
- Tableau de bord avec statistiques
- Profil utilisateur
- Barre de navigation latérale
- Actions rapides
- Suivi d'activité
- Monitoring du système

## Structure du Projet

```
/
├── README.md
├── compose.yml
├── nginx.conf
├── login.php
└── code/
    ├── index.html      # Page de connexion
    ├── main.php        # Dashboard (généré par IA)
    ├── css/
    │   ├── bootstrap.min.css
    │   └── style.css
    ├── js/
    │   ├── jquery.min.js
    │   ├── bootstrap.min.js
    │   ├── popper.js
    │   └── main.js
    ├── images/
    │   └── bg.jpg
    ├── scss/
    │   └── (fichiers SCSS)
    └── traitement/
        ├── connexion.php    # Connexion à la base de données
        ├── login.php        # Traitement de la connexion
        └── logout.php       # Déconnexion
```

## Fonctionnalités

### Page de Connexion (index.html)
- Design moderne avec Bootstrap
- Validation des formulaires
- Messages d'erreur

### Dashboard (main.php) - *Généré par IA*
- 🎯 Affichage du profil utilisateur
- 📊 Statistiques en temps réel
- 👤 Informations utilisateur depuis la base de données
- ⚡ Actions rapides
- 🕐 Activité récente
- 💻 État du système
- 🚪 Déconnexion sécurisée

### Sécurité
- Hachage de mots de passe avec `password_hash()` et `password_verify()`
- Protection CSRF
- Validation des entrées
- Sessions PHP sécurisées

## Installation

### Prérequis
- PHP 7.4+
- MySQL/MariaDB
- Nginx ou Apache
- Docker (optionnel)

### Avec Docker
```bash
docker-compose up -d
```

### Configuration Manuelle
1. Modifier `code/traitement/connexion.php` avec vos identifiants de base de données
2. Importer la base de données
3. Configurer votre serveur web

## Base de Données

### Table users
```sql
CREATE TABLE users (
    id_users INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Technologies Utilisées

- **Frontend** : HTML5, CSS3, Bootstrap 5, JavaScript
- **Backend** : PHP 7.4+
- **Base de Données** : MySQL
- **Serveur** : Nginx avec PHP-FPM
- **Conteneurisation** : Docker

## Auteurs

- Interface dashboard : Générée par Intelligence Artificielle
- Conception originale : Colorlib Template

## Licence

Ce projet est sous licence MIT.

## Remerciements

- [Colorlib](https://colorlib.com) pour le template
- [Bootstrap](https://getbootstrap.com) pour le framework CSS
- [BlackboxAI](https://blackbox.ai) pour la génération du dashboard

---

**Date de création** : 2024
**Version** : 1.0.0

