import { createClient } from './supabase/server';

export async function getUserFromRequest() {
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

export async function requireAuth() {
  const user = await getUserFromRequest();
  return user;
}

export async function requireRole(roles: Array<'SUPERADMIN' | 'ADMIN' | 'ADMIN_LIGUE' | 'COACH' | 'ELEVE'>) {
  const user = await getUserFromRequest();
  if (!user) return { allowed: false as const, user: null };
  if (!roles.includes(user.role as any)) return { allowed: false as const, user };
  return { allowed: true as const, user };
}
