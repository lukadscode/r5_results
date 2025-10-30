/*
  # Création du schéma initial pour Rame en 5e

  ## Vue d'ensemble
  Application de gestion scolaire avec système Padlet et suivi des performances d'aviron.
  Support multi-niveaux d'administration (SuperAdmin, Admin, Admin Ligue, Coach).

  ## 1. Tables principales

  ### users
  - Gestion des utilisateurs avec rôles hiérarchiques
  - Rôles : SUPERADMIN, ADMIN, ADMIN_LIGUE, COACH, ELEVE
  - Liaison avec auth.users de Supabase

  ### ligues
  - Regroupement géographique/organisationnel
  - Permet la gestion par Admin Ligue

  ### etablissements (clubs/collèges)
  - Rattachés à une ligue
  - Géré par les coaches

  ### saisons
  - Gestion annuelle des périodes d'activité
  - Une seule saison active à la fois (géré via trigger)

  ### classes
  - Rattachées à un établissement et une saison
  - Statut de validation par admin
  - Duplication possible sans résultats

  ### eleves
  - Membres d'une classe

  ### results
  - Résultats des performances
  - Lien avec événements externes

  ## 2. Tables Padlet

  ### padlet_themes
  - Thèmes principaux configurables

  ### padlet_subthemes
  - Sous-thèmes rattachés aux thèmes

  ### padlet_content
  - Contenu multimédia (texte, document, image, vidéo YouTube)

  ## 3. Sécurité
  - RLS activé sur toutes les tables
  - Politiques basées sur les rôles et les ligues
  - Contrôle d'accès granulaire par niveau hiérarchique
*/

-- Enable UUID extension
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Create custom types
DO $$ BEGIN
  CREATE TYPE user_role AS ENUM ('SUPERADMIN', 'ADMIN', 'ADMIN_LIGUE', 'COACH', 'ELEVE');
EXCEPTION
  WHEN duplicate_object THEN null;
END $$;

DO $$ BEGIN
  CREATE TYPE padlet_content_type AS ENUM ('TEXT', 'DOCUMENT', 'IMAGE', 'VIDEO_YOUTUBE');
EXCEPTION
  WHEN duplicate_object THEN null;
END $$;

DO $$ BEGIN
  CREATE TYPE classe_status AS ENUM ('DRAFT', 'SUBMITTED', 'VALIDATED', 'ARCHIVED');
EXCEPTION
  WHEN duplicate_object THEN null;
END $$;

-- Table: ligues
CREATE TABLE IF NOT EXISTS ligues (
  id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
  name text NOT NULL,
  code text UNIQUE NOT NULL,
  region text,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Table: etablissements
CREATE TABLE IF NOT EXISTS etablissements (
  id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
  name text NOT NULL,
  type text DEFAULT 'CLUB',
  ligue_id uuid REFERENCES ligues(id) ON DELETE CASCADE,
  address text,
  city text,
  postal_code text,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Table: users (extension de auth.users)
CREATE TABLE IF NOT EXISTS users (
  id uuid PRIMARY KEY REFERENCES auth.users(id) ON DELETE CASCADE,
  email text UNIQUE NOT NULL,
  full_name text NOT NULL,
  role user_role DEFAULT 'COACH',
  ligue_id uuid REFERENCES ligues(id) ON DELETE SET NULL,
  etablissement_id uuid REFERENCES etablissements(id) ON DELETE SET NULL,
  is_active boolean DEFAULT true,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Table: saisons
CREATE TABLE IF NOT EXISTS saisons (
  id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
  name text NOT NULL,
  start_date date NOT NULL,
  end_date date NOT NULL,
  is_active boolean DEFAULT false,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Trigger pour assurer qu'une seule saison est active
CREATE OR REPLACE FUNCTION ensure_single_active_saison()
RETURNS TRIGGER AS $$
BEGIN
  IF NEW.is_active = true THEN
    UPDATE saisons SET is_active = false WHERE id != NEW.id AND is_active = true;
  END IF;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_single_active_saison ON saisons;
CREATE TRIGGER trigger_single_active_saison
  BEFORE INSERT OR UPDATE ON saisons
  FOR EACH ROW
  EXECUTE FUNCTION ensure_single_active_saison();

-- Table: classes
CREATE TABLE IF NOT EXISTS classes (
  id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
  name text NOT NULL,
  niveau text,
  etablissement_id uuid NOT NULL REFERENCES etablissements(id) ON DELETE CASCADE,
  saison_id uuid NOT NULL REFERENCES saisons(id) ON DELETE CASCADE,
  coach_id uuid REFERENCES users(id) ON DELETE SET NULL,
  status classe_status DEFAULT 'DRAFT',
  validated_at timestamptz,
  validated_by uuid REFERENCES users(id) ON DELETE SET NULL,
  duplicated_from uuid REFERENCES classes(id) ON DELETE SET NULL,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Table: eleves
CREATE TABLE IF NOT EXISTS eleves (
  id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
  first_name text NOT NULL,
  last_name text NOT NULL,
  birth_date date,
  gender text,
  classe_id uuid NOT NULL REFERENCES classes(id) ON DELETE CASCADE,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Table: results
CREATE TABLE IF NOT EXISTS results (
  id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
  eleve_id uuid NOT NULL REFERENCES eleves(id) ON DELETE CASCADE,
  classe_id uuid NOT NULL REFERENCES classes(id) ON DELETE CASCADE,
  game_id text NOT NULL,
  score integer NOT NULL DEFAULT 0,
  time_seconds numeric(10, 2),
  details jsonb,
  external_event_id text UNIQUE,
  created_at timestamptz DEFAULT now()
);

-- Table: padlet_themes
CREATE TABLE IF NOT EXISTS padlet_themes (
  id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
  title text NOT NULL,
  description text,
  icon text,
  color text,
  display_order integer DEFAULT 0,
  is_visible boolean DEFAULT true,
  created_by uuid REFERENCES users(id) ON DELETE SET NULL,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Table: padlet_subthemes
CREATE TABLE IF NOT EXISTS padlet_subthemes (
  id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
  theme_id uuid NOT NULL REFERENCES padlet_themes(id) ON DELETE CASCADE,
  title text NOT NULL,
  description text,
  display_order integer DEFAULT 0,
  is_visible boolean DEFAULT true,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Table: padlet_content
CREATE TABLE IF NOT EXISTS padlet_content (
  id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
  subtheme_id uuid NOT NULL REFERENCES padlet_subthemes(id) ON DELETE CASCADE,
  title text NOT NULL,
  content_type padlet_content_type NOT NULL,
  text_content text,
  document_url text,
  image_url text,
  video_youtube_id text,
  display_order integer DEFAULT 0,
  is_published boolean DEFAULT false,
  created_by uuid REFERENCES users(id) ON DELETE SET NULL,
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Enable Row Level Security
ALTER TABLE ligues ENABLE ROW LEVEL SECURITY;
ALTER TABLE etablissements ENABLE ROW LEVEL SECURITY;
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE saisons ENABLE ROW LEVEL SECURITY;
ALTER TABLE classes ENABLE ROW LEVEL SECURITY;
ALTER TABLE eleves ENABLE ROW LEVEL SECURITY;
ALTER TABLE results ENABLE ROW LEVEL SECURITY;
ALTER TABLE padlet_themes ENABLE ROW LEVEL SECURITY;
ALTER TABLE padlet_subthemes ENABLE ROW LEVEL SECURITY;
ALTER TABLE padlet_content ENABLE ROW LEVEL SECURITY;

-- RLS Policies: ligues
CREATE POLICY "Ligues visible par tous les authentifiés"
  ON ligues FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Ligues modifiables par SUPERADMIN et ADMIN"
  ON ligues FOR ALL
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND users.role IN ('SUPERADMIN', 'ADMIN')
    )
  );

-- RLS Policies: etablissements
CREATE POLICY "Etablissements visibles par tous authentifiés"
  ON etablissements FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Etablissements modifiables par admins et admin_ligue de la ligue"
  ON etablissements FOR ALL
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND (
        users.role IN ('SUPERADMIN', 'ADMIN')
        OR (users.role = 'ADMIN_LIGUE' AND users.ligue_id = etablissements.ligue_id)
      )
    )
  );

-- RLS Policies: users
CREATE POLICY "Utilisateurs peuvent voir leur propre profil"
  ON users FOR SELECT
  TO authenticated
  USING (id = auth.uid());

CREATE POLICY "SUPERADMIN et ADMIN peuvent tout voir"
  ON users FOR SELECT
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users u
      WHERE u.id = auth.uid()
      AND u.role IN ('SUPERADMIN', 'ADMIN')
    )
  );

CREATE POLICY "ADMIN_LIGUE peut voir les users de sa ligue"
  ON users FOR SELECT
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users u
      WHERE u.id = auth.uid()
      AND u.role = 'ADMIN_LIGUE'
      AND u.ligue_id = users.ligue_id
    )
  );

CREATE POLICY "SUPERADMIN et ADMIN peuvent modifier les users"
  ON users FOR ALL
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users u
      WHERE u.id = auth.uid()
      AND u.role IN ('SUPERADMIN', 'ADMIN')
    )
  );

-- RLS Policies: saisons
CREATE POLICY "Saisons visibles par tous authentifiés"
  ON saisons FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Saisons modifiables par SUPERADMIN et ADMIN"
  ON saisons FOR ALL
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND users.role IN ('SUPERADMIN', 'ADMIN')
    )
  );

-- RLS Policies: classes
CREATE POLICY "Classes visibles selon rôle et ligue"
  ON classes FOR SELECT
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users u
      LEFT JOIN etablissements e ON classes.etablissement_id = e.id
      WHERE u.id = auth.uid()
      AND (
        u.role IN ('SUPERADMIN', 'ADMIN')
        OR (u.role = 'ADMIN_LIGUE' AND u.ligue_id = e.ligue_id)
        OR (u.role = 'COACH' AND u.etablissement_id = classes.etablissement_id)
        OR classes.coach_id = u.id
      )
    )
  );

CREATE POLICY "COACH peut créer des classes pour son établissement"
  ON classes FOR INSERT
  TO authenticated
  WITH CHECK (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND (
        users.role IN ('SUPERADMIN', 'ADMIN')
        OR (users.role = 'COACH' AND users.etablissement_id = classes.etablissement_id)
      )
    )
  );

CREATE POLICY "COACH peut modifier ses classes non validées"
  ON classes FOR UPDATE
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND (
        users.role IN ('SUPERADMIN', 'ADMIN')
        OR (users.role = 'COACH' AND coach_id = users.id AND status = 'DRAFT')
      )
    )
  )
  WITH CHECK (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND (
        users.role IN ('SUPERADMIN', 'ADMIN')
        OR (users.role = 'COACH' AND coach_id = users.id)
      )
    )
  );

CREATE POLICY "COACH peut supprimer ses classes non validées"
  ON classes FOR DELETE
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND (
        users.role IN ('SUPERADMIN', 'ADMIN')
        OR (users.role = 'COACH' AND coach_id = users.id AND status = 'DRAFT')
      )
    )
  );

-- RLS Policies: eleves
CREATE POLICY "Eleves visibles selon accès classe"
  ON eleves FOR SELECT
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM classes c
      LEFT JOIN etablissements e ON c.etablissement_id = e.id
      LEFT JOIN users u ON u.id = auth.uid()
      WHERE eleves.classe_id = c.id
      AND (
        u.role IN ('SUPERADMIN', 'ADMIN')
        OR (u.role = 'ADMIN_LIGUE' AND u.ligue_id = e.ligue_id)
        OR (u.role = 'COACH' AND u.etablissement_id = c.etablissement_id)
        OR c.coach_id = u.id
      )
    )
  );

CREATE POLICY "COACH peut gérer les élèves de ses classes"
  ON eleves FOR ALL
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM classes c
      LEFT JOIN users u ON u.id = auth.uid()
      WHERE eleves.classe_id = c.id
      AND (
        u.role IN ('SUPERADMIN', 'ADMIN')
        OR c.coach_id = u.id
      )
    )
  );

-- RLS Policies: results
CREATE POLICY "Résultats visibles selon accès classe"
  ON results FOR SELECT
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM classes c
      LEFT JOIN etablissements e ON c.etablissement_id = e.id
      LEFT JOIN users u ON u.id = auth.uid()
      WHERE results.classe_id = c.id
      AND (
        u.role IN ('SUPERADMIN', 'ADMIN')
        OR (u.role = 'ADMIN_LIGUE' AND u.ligue_id = e.ligue_id)
        OR (u.role = 'COACH' AND u.etablissement_id = c.etablissement_id)
        OR c.coach_id = u.id
      )
    )
  );

CREATE POLICY "Résultats insérables via API"
  ON results FOR INSERT
  TO authenticated
  WITH CHECK (true);

-- RLS Policies: padlet_themes
CREATE POLICY "Themes Padlet visibles par tous authentifiés"
  ON padlet_themes FOR SELECT
  TO authenticated
  USING (is_visible = true OR EXISTS (
    SELECT 1 FROM users WHERE users.id = auth.uid() AND users.role IN ('SUPERADMIN', 'ADMIN')
  ));

CREATE POLICY "Themes Padlet modifiables par SUPERADMIN et ADMIN"
  ON padlet_themes FOR ALL
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND users.role IN ('SUPERADMIN', 'ADMIN')
    )
  );

-- RLS Policies: padlet_subthemes
CREATE POLICY "Subthemes Padlet visibles par tous authentifiés"
  ON padlet_subthemes FOR SELECT
  TO authenticated
  USING (is_visible = true OR EXISTS (
    SELECT 1 FROM users WHERE users.id = auth.uid() AND users.role IN ('SUPERADMIN', 'ADMIN')
  ));

CREATE POLICY "Subthemes Padlet modifiables par SUPERADMIN et ADMIN"
  ON padlet_subthemes FOR ALL
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND users.role IN ('SUPERADMIN', 'ADMIN')
    )
  );

-- RLS Policies: padlet_content
CREATE POLICY "Contenu Padlet publié visible par tous"
  ON padlet_content FOR SELECT
  TO authenticated
  USING (is_published = true OR EXISTS (
    SELECT 1 FROM users WHERE users.id = auth.uid() AND users.role IN ('SUPERADMIN', 'ADMIN')
  ));

CREATE POLICY "Contenu Padlet modifiable par SUPERADMIN et ADMIN"
  ON padlet_content FOR ALL
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users
      WHERE users.id = auth.uid()
      AND users.role IN ('SUPERADMIN', 'ADMIN')
    )
  );

-- Indexes pour performance
CREATE INDEX IF NOT EXISTS idx_etablissements_ligue ON etablissements(ligue_id);
CREATE INDEX IF NOT EXISTS idx_users_ligue ON users(ligue_id);
CREATE INDEX IF NOT EXISTS idx_users_etablissement ON users(etablissement_id);
CREATE INDEX IF NOT EXISTS idx_users_role ON users(role);
CREATE INDEX IF NOT EXISTS idx_classes_etablissement ON classes(etablissement_id);
CREATE INDEX IF NOT EXISTS idx_classes_saison ON classes(saison_id);
CREATE INDEX IF NOT EXISTS idx_classes_coach ON classes(coach_id);
CREATE INDEX IF NOT EXISTS idx_classes_status ON classes(status);
CREATE INDEX IF NOT EXISTS idx_eleves_classe ON eleves(classe_id);
CREATE INDEX IF NOT EXISTS idx_results_eleve ON results(eleve_id);
CREATE INDEX IF NOT EXISTS idx_results_classe ON results(classe_id);
CREATE INDEX IF NOT EXISTS idx_results_external_event ON results(external_event_id);
CREATE INDEX IF NOT EXISTS idx_padlet_subthemes_theme ON padlet_subthemes(theme_id);
CREATE INDEX IF NOT EXISTS idx_padlet_content_subtheme ON padlet_content(subtheme_id);
