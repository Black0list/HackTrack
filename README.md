# 📘 Documentation API - Hackathon Management

## 🚀 Introduction
Cette API permet de gérer les éditions annuelles d'un hackathon, les équipes, les projets soumis et les évaluations des jurys. Conçue avec **Laravel** et **PostgreSQL**, elle utilise **JWT** pour l'authentification et fournit une interface **RESTful**.

## 🛠️ Prérequis
- PHP >= 8.0
- Laravel 9
- PostgreSQL
- Composer
- Node.js & npm

## 🧑‍💻 Installation

### 1. **Cloner le projet**
```bash
git clone https://github.com/Black0list/HackTrack.git
cd HackTrack
```

### 2. **Installer les dépendances**
```bash
composer install
npm install && npm run dev
```

### 3. **Configurer l'environnement**
```bash
cp .env.example .env
```
📄 **Modifier le fichier `.env`** avec les informations de votre base de données PostgreSQL :
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=hackathon_db
DB_USERNAME=postgres
DB_PASSWORD=password
```

### 4. **Générer la clé de l'application**
```bash
php artisan key:generate
```

### 5. **Exécuter les migrations**
```bash
php artisan migrate 
```

### 6. **Lancer le serveur**
```bash
php artisan serve
```

---

## 🌐 Endpoints API

### 🔐 **1. Authentification & Gestion des Rôles**

- **POST** `/api/register` : Inscription utilisateur
- **POST** `/api/login` : Connexion utilisateur
- **POST** `/api/logout` : Déconnexion utilisateur *(JWT requis)*
- **GET** `/api/user` : Détails de l'utilisateur authentifié *(JWT requis)*
- **POST** `/api/user/{user}/role/{role}` : Attribuer un rôle à un utilisateur *(Admin uniquement)*

📦 **Exemple de réponse :**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "johndoe@example.com",
    "role": {
        "id" : 2,
        "role_name" : "participant"
    },
  },
  "token": "eyJhbGciOiJIUzI1..."
}
```

---

### 🗓 **2. Gestion des Éditions**

- **GET** `/api/hackathons` : Liste des éditions
- **POST** `/api/hackathon/create` : Créer une édition *(Admin uniquement)*
- **PUT** `/api/hackathon/{hackathon}/update` : Modifier une édition *(Admin uniquement)*
- **DELETE** `/api/hackathon/{hackathon}/delete` : Supprimer une édition *(Admin uniquement)*

---

### 👥 **3. Gestion des Équipes**

- **POST** `/api/teams/{team}/register` : Inscription d'une équipe *(Compétiteur)*
- **POST** `/api/teams/{team}/approve` : Valider une équipe *(Admin)*
- **POST** `/api/teams/{team}/reject` : Rejeter une équipe *(Admin)*
- **POST** `/api/teams/{team}` : Rejoindre une équipe
- **GET** `/api/teams/{team}` : Voir les détails d'une équipe
- **GET** `/api/teams` : Liste des équipes
- **PUT** `/api/teams/{team}` : Modifier les informations d'une équipe
- **DELETE** `/api/teams/{team}` : Supprimer une équipe

---

### 🏁 **4. Gestion des Thèmes et Règles**

- **GET** `/api/themes` : Liste des thèmes
- **POST** `/api/themes` : Créer un thème
- **PUT** `/api/themes/{theme}` : Mettre à jour un thème
- **DELETE** `/api/themes/{theme}` : Supprimer un thème
- **GET** `/api/rules` : Liste des règles
- **POST** `/api/rules` : Créer une règle
- **PUT** `/api/rules/{rule}` : Modifier une règle
- **DELETE** `/api/rules/{rule}` : Supprimer une règle

---

### 🧑‍⚖️ **5. Gestion des Jurys**

- **GET** `/api/juries` : Liste des jurys *(Admin uniquement)*
- **POST** `/api/juries` : Ajouter un jury *(Admin uniquement)*
- **PUT** `/api/juries/{jury}` : Mettre à jour un jury *(Admin uniquement)*
- **DELETE** `/api/juries/{jury}` : Supprimer un jury *(Admin uniquement)*

---

### 🏆 **6. Évaluation des Projets**

- **POST** `/api/note/{team}` : Noter un projet *(Jury uniquement)*

---

## ⚠️ Gestion des Erreurs

L'API utilise des **codes HTTP standards** pour indiquer les erreurs.

- `400` : Requête invalide
- `401` : Non authentifié
- `403` : Accès refusé
- `404` : Ressource non trouvée
- `500` : Erreur interne du serveur

📦 **Exemple d'erreur :**
```json
{
  "error": "Unauthorized access. Please log in."
}
```

---

## 🧪 Tests API

Importez la collection **Postman** fournie pour tester les endpoints. Assurez-vous d'utiliser le **token JWT** pour les requêtes authentifiées.

---

## ✨ Auteur
Ce projet a été développé par **HADOUI ABDELKEBIR**.
- 📧 Contact : contact.abdelkebir@gmail.com
- 🔗 GitHub : [Black0list](https://github.com/Black0list)

