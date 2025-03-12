# TP_Symfony_ToDoTask_MARLY_MMI3

# Gestion des Tâches - API Symfony

Une application web en **Symfony** permettant de **gérer des tâches** avec une interface utilisateur et une API REST.

---

## Fonctionnalités
 Ajouter, modifier et supprimer des tâches  
 Marquer une tâche comme "terminée" ou "en cours"  
 Filtrer les tâches par statut  
 Interface utilisateur moderne avec **Bootstrap**  
 API REST complète pour l'intégration avec d'autres services  

---

## Installation

### 1 **Cloner le projet**

git clone https://github.com/NicoMarly/TP_Symfony_ToDoTask_MARLY_MMI3.git
cd tache-api

### 2 Installer les dépendances

composer install

### 3 Configurer la base de données

DATABASE_URL="mysql://user:password@127.0.0.1:3306/tache_db"
Créer la base de données et exécuter les migrations :

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

### 4 Lancer le serveur

symfony server:start
L'application sera accessible sur http://127.0.0.1:8000.

### API REST - Documentation

## 1. Récupérer toutes les tâches

GET /api/tasks

# Réponse :

[
    {
        "id": 1,
        "title": "Faire les courses",
        "description": "Acheter du pain et du lait",
        "status": false,
        "created_at": "2024-03-12T12:00:00"
    }
]

## 2. Récupérer une tâche spécifique

GET /api/tasks/{id}

# Réponse :

{
    "id": 1,
    "title": "Faire les courses",
    "description": "Acheter du pain et du lait",
    "status": false,
    "created_at": "2024-03-12T12:00:00"
}

## 3. Créer une tâche

POST /api/tasks
Content-Type: application/json

# Corps de la requête :

{
    "title": "Nouvelle tâche",
    "description": "Aller à la salle de sport",
    "status": false
}

# Réponse :

{
    "id": 2,
    "title": "Nouvelle tâche",
    "description": "Aller à la salle de sport",
    "status": false,
    "created_at": "2024-03-12T14:30:00"
}

## 4. Modifier une tâche

PUT /api/tasks/{id}
Content-Type: application/json

# Corps de la requête :

{
    "status": true
}

# Réponse :

{
    "id": 1,
    "title": "Faire les courses",
    "description": "Acheter du pain et du lait",
    "status": true,
    "created_at": "2024-03-12T12:00:00"
}

## 5. Supprimer une tâche

DELETE /api/tasks/{id}

# Réponse :

{
    "message": "Tâche supprimée avec succès"
}
