# Rame en 5e - Application Next.js

Application complète de gestion scolaire avec modules Padlet et Rame en 5e, utilisant Supabase comme backend.

## Fonctionnalités

### Authentification Multi-niveaux
- **SUPERADMIN** : Accès complet à toute l'application
- **ADMIN** : Gestion des saisons, ligues, établissements et validation des classes
- **ADMIN_LIGUE** : Gestion et visualisation des données de sa ligue
- **COACH** : Gestion de ses classes et élèves
- **ELEVE** : Consultation de ses résultats

### Module Padlet
- Création de thèmes et sous-thèmes configurables
- Gestion de contenus multimédias (texte, images, documents, vidéos YouTube)
- Système de publication/brouillon
- Interface d'administration complète
- Navigation hiérarchique thème > sous-thème > contenu

### Module Rame en 5e
- Gestion des saisons (une seule active à la fois)
- Organisation par ligues et établissements
- Création et gestion de classes par les coaches
- Système de validation des classes par les admins
- Duplication de classes (sans résultats)
- Suivi des résultats et performances
- Statistiques avancées

### Espace Public
- Classement des classes avec plusieurs modes de tri :
  - Moyenne pondérée (performance 60% + participation 40%)
  - Score total
  - Meilleur temps
  - Participation
- Filtrage par ligue
- Mise en évidence du podium

## Technologies

- **Next.js 14** (App Router)
- **Supabase** (PostgreSQL + Auth + RLS)
- **TailwindCSS** pour le design
- **React Query** pour la gestion des données
- **TypeScript**

## Installation

```bash
# Installer les dépendances
npm install

# Configurer les variables d'environnement
# Le fichier .env est déjà configuré avec votre instance Supabase

# Lancer en développement
npm run dev

# Build pour production
npm run build

# Démarrer en production
npm run start
```

## Structure de la Base de Données

### Tables principales
- `users` : Utilisateurs avec rôles hiérarchiques
- `ligues` : Regroupements géographiques/organisationnels
- `etablissements` : Clubs ou collèges rattachés à une ligue
- `saisons` : Périodes d'activité annuelles
- `classes` : Classes avec statut de validation
- `eleves` : Élèves rattachés à une classe
- `results` : Résultats des performances

### Tables Padlet
- `padlet_themes` : Thèmes principaux
- `padlet_subthemes` : Sous-thèmes rattachés aux thèmes
- `padlet_content` : Contenus multimédias

## Sécurité

- **Row Level Security (RLS)** activé sur toutes les tables
- Politiques d'accès basées sur les rôles
- Contrôle granulaire par niveau hiérarchique (ligue > établissement > classe)
- Authentification Supabase avec gestion des sessions

## Migration vers MariaDB

Pour migrer vers votre propre serveur MariaDB :

1. **Exporter le schéma** depuis Supabase :
   ```sql
   -- Le schéma se trouve dans supabase/migrations/
   ```

2. **Adapter le schéma** pour MariaDB :
   - Remplacer `uuid_generate_v4()` par `UUID()`
   - Ajuster les types PostgreSQL (uuid → CHAR(36), timestamptz → TIMESTAMP, jsonb → JSON)
   - Convertir les ENUM en tables de référence ou CHECK constraints

3. **Migrer l'authentification** :
   - Implémenter votre propre système d'auth
   - Ou utiliser une bibliothèque comme Passport.js
   - Maintenir la structure de la table `users`

4. **Adapter le code** :
   - Remplacer les appels `@supabase/supabase-js` par votre ORM (Prisma, TypeORM, etc.)
   - Implémenter les checks de sécurité au niveau applicatif
   - Les RLS policies deviennent des vérifications dans vos API routes

## Routes principales

- `/` : Redirection vers login ou select-module
- `/login` : Page de connexion
- `/select-module` : Choix entre Padlet et Rame en 5e
- `/padlet/dashboard` : Dashboard Padlet
- `/padlet/admin` : Administration Padlet (ADMIN uniquement)
- `/rame/dashboard` : Dashboard Rame en 5e
- `/rame/admin` : Administration Rame (ADMIN uniquement)
- `/public/classements` : Classements publics

## Données de test

Des données de démonstration ont été insérées :
- 1 ligue (Île-de-France)
- 1 établissement de test
- 1 saison active (2024-2025)
- 3 thèmes Padlet avec sous-thèmes et contenus

Pour créer un utilisateur admin, utilisez Supabase Dashboard ou l'API signup avec :
```typescript
{
  email: "admin@example.com",
  password: "votreMotDePasse",
  full_name: "Admin Test",
  role: "SUPERADMIN"
}
```

## Support

Pour toute question ou problème, référez-vous à la documentation de Supabase :
- https://supabase.com/docs
- https://nextjs.org/docs
