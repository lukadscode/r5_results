/*
  # Permettre l'insertion d'utilisateurs lors de l'inscription
  
  1. Modifications
    - Ajoute une policy INSERT pour permettre au service role de créer des utilisateurs
    - Ajoute une policy INSERT pour permettre à un utilisateur authentifié de créer son propre profil
    
  Note: Cette policy est essentielle pour le processus d'inscription
*/

-- Permettre à un utilisateur nouvellement créé d'insérer son propre profil
CREATE POLICY "Utilisateurs peuvent créer leur propre profil"
  ON users
  FOR INSERT
  TO authenticated
  WITH CHECK (id = auth.uid());

-- Permettre aux SUPERADMIN et ADMIN de créer des utilisateurs
CREATE POLICY "SUPERADMIN et ADMIN peuvent créer des users"
  ON users
  FOR INSERT
  TO authenticated
  WITH CHECK (
    EXISTS (
      SELECT 1 FROM users u
      WHERE u.id = auth.uid()
      AND u.role IN ('SUPERADMIN', 'ADMIN')
    )
  );
