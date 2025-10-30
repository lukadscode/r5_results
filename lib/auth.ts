import { createClient } from './supabase/server';

export async function getCurrentUser() {
  const supabase = await createClient();

  const {
    data: { user: authUser },
  } = await supabase.auth.getUser();

  if (!authUser) return null;

  const { data: user } = await supabase
    .from('users')
    .select('*')
    .eq('id', authUser.id)
    .maybeSingle();

  return user;
}

export function requireRole(user: { role: string } | null, roles: string[]) {
  if (!user) return false;
  return roles.includes(user.role);
}


