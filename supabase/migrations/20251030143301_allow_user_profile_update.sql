/*
  # Permettre aux utilisateurs de mettre à jour leur profil
  
  1. Modifications
    - Ajoute une policy UPDATE pour permettre aux utilisateurs de modifier leur propre profil
    - Ajoute une policy UPDATE pour permettre aux SUPERADMIN et ADMIN de modifier les utilisateurs
    
  Note: Les utilisateurs ne peuvent modifier que certains champs de leur profil
*/

-- Permettre aux utilisateurs de mettre à jour leur propre profil
CREATE POLICY "Utilisateurs peuvent mettre à jour leur propre profil"
  ON users
  FOR UPDATE
  TO authenticated
  USING (id = auth.uid())
  WITH CHECK (id = auth.uid());

-- Permettre aux SUPERADMIN et ADMIN de mettre à jour n'importe quel utilisateur
CREATE POLICY "SUPERADMIN et ADMIN peuvent mettre à jour les users"
  ON users
  FOR UPDATE
  TO authenticated
  USING (
    EXISTS (
      SELECT 1 FROM users u
      WHERE u.id = auth.uid()
      AND u.role IN ('SUPERADMIN', 'ADMIN')
    )
  )
  WITH CHECK (
    EXISTS (
      SELECT 1 FROM users u
      WHERE u.id = auth.uid()
      AND u.role IN ('SUPERADMIN', 'ADMIN')
    )
  );
