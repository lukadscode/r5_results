/*
  # Autoriser la lecture publique des ligues et établissements
  
  1. Modifications
    - Ajoute des policies pour permettre la lecture publique (anon) des ligues
    - Ajoute des policies pour permettre la lecture publique (anon) des établissements
    
  Note: Ces données doivent être accessibles sur la page d'inscription 
  qui est accessible sans authentification
*/

-- Permettre la lecture publique des ligues
CREATE POLICY "Ligues visibles publiquement"
  ON ligues
  FOR SELECT
  TO anon
  USING (true);

-- Permettre la lecture publique des établissements
CREATE POLICY "Etablissements visibles publiquement"
  ON etablissements
  FOR SELECT
  TO anon
  USING (true);
