import { NextRequest, NextResponse } from 'next/server';
import { createClient } from '@/lib/supabase/server';

export async function POST(req: NextRequest) {
  const { email, password, full_name, role, ligue_id, etablissement_id } = await req.json();

  if (!email || !password || !full_name) {
    return NextResponse.json({ error: 'Champs manquants' }, { status: 400 });
  }

  const supabase = await createClient();

  const { data: authData, error: authError} = await supabase.auth.signUp({
    email,
    password,
    options: {
      emailRedirectTo: `${req.headers.get('origin')}/login`,
      data: {
        full_name,
        role: role || 'COACH',
        ligue_id,
        etablissement_id,
      }
    }
  });

  if (authError) {
    console.error('Auth signup error:', authError);
    return NextResponse.json({ error: authError.message }, { status: 400 });
  }

  if (!authData.user) {
    return NextResponse.json({ error: 'Erreur lors de la création du compte' }, { status: 400 });
  }

  const userData: any = {
    id: authData.user.id,
    email,
    full_name,
    role: role || 'COACH',
  };

  if (ligue_id) {
    userData.ligue_id = ligue_id;
  }

  if (etablissement_id) {
    userData.etablissement_id = etablissement_id;
  }

  const { error: profileError } = await supabase
    .from('users')
    .insert(userData);

  if (profileError) {
    console.error('Profile creation error:', profileError);
    return NextResponse.json({ error: `Erreur lors de la création du profil: ${profileError.message}` }, { status: 400 });
  }

  return NextResponse.json({
    ok: true,
    user: authData.user,
    message: authData.user.identities && authData.user.identities.length === 0
      ? 'Un compte existe déjà avec cet email'
      : 'Compte créé avec succès'
  });
}
