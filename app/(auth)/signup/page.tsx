'use client';
import { useState, useEffect } from 'react';
import Image from 'next/image';
import Link from 'next/link';
import { createClient } from '@/lib/supabase/client';

export default function SignupPage() {
  const supabase = createClient();

  const [formData, setFormData] = useState({
    email: '',
    password: '',
    confirmPassword: '',
    firstName: '',
    lastName: '',
    role: 'PROFESSEUR' as 'PROFESSEUR' | 'COACH' | 'ADMIN_LIGUE',
    ligueId: '',
    etablissementId: '',
  });

  const [ligues, setLigues] = useState<any[]>([]);
  const [etablissements, setEtablissements] = useState<any[]>([]);
  const [filteredEtablissements, setFilteredEtablissements] = useState<any[]>([]);
  const [error, setError] = useState<string | null>(null);
  const [success, setSuccess] = useState(false);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    const fetchData = async () => {
      const [liguesRes, etablissementsRes] = await Promise.all([
        supabase.from('ligues').select('*').order('name'),
        supabase.from('etablissements').select('*, ligues(name)').order('name')
      ]);

      if (liguesRes.data) setLigues(liguesRes.data);
      if (etablissementsRes.data) setEtablissements(etablissementsRes.data);
    };

    fetchData();
  }, []);

  useEffect(() => {
    if (formData.ligueId && (formData.role === 'PROFESSEUR' || formData.role === 'COACH')) {
      const etablissementType = formData.role === 'PROFESSEUR' ? 'COLLEGE' : 'CLUB';
      setFilteredEtablissements(
        etablissements.filter((e) =>
          e.ligue_id === formData.ligueId && e.type === etablissementType
        )
      );
    } else {
      setFilteredEtablissements([]);
    }
  }, [formData.ligueId, formData.role, etablissements]);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
      ...(name === 'ligueId' || name === 'role' ? { etablissementId: '' } : {}),
    }));
  };

  const onSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);
    setLoading(true);

    if (!formData.firstName || !formData.lastName) {
      setError('Veuillez renseigner votre prénom et nom');
      setLoading(false);
      return;
    }

    if (!formData.email) {
      setError('Veuillez renseigner votre email');
      setLoading(false);
      return;
    }

    if (!formData.ligueId) {
      setError('Veuillez sélectionner une ligue');
      setLoading(false);
      return;
    }

    if ((formData.role === 'COACH' || formData.role === 'PROFESSEUR') && !formData.etablissementId) {
      setError(formData.role === 'PROFESSEUR' ? 'Veuillez sélectionner un collège' : 'Veuillez sélectionner un club');
      setLoading(false);
      return;
    }

    if (formData.password !== formData.confirmPassword) {
      setError('Les mots de passe ne correspondent pas');
      setLoading(false);
      return;
    }

    if (formData.password.length < 8) {
      setError('Le mot de passe doit contenir au moins 8 caractères');
      setLoading(false);
      return;
    }

    try {
      const res = await fetch('/api/auth/signup', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          email: formData.email,
          password: formData.password,
          full_name: `${formData.firstName} ${formData.lastName}`,
          role: formData.role,
          ligue_id: formData.ligueId || null,
          etablissement_id: formData.etablissementId || null,
        })
      });

      if (res.ok) {
        setSuccess(true);
        setTimeout(() => {
          window.location.href = '/login';
        }, 2000);
      } else {
        const j = await res.json().catch(() => ({}));
        setError(j?.error || 'Erreur lors de l\'inscription');
      }
    } catch (err) {
      setError('Erreur de connexion. Veuillez réessayer.');
    } finally {
      setLoading(false);
    }
  };

  if (success) {
    return (
      <main className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center">
          <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg className="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
              <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
            </svg>
          </div>
          <h2 className="text-2xl font-bold text-gray-900 mb-2">Inscription réussie !</h2>
          <p className="text-gray-600 mb-4">Votre compte a été créé avec succès.</p>
          <p className="text-sm text-gray-500">Redirection vers la page de connexion...</p>
        </div>
      </main>
    );
  }

  return (
    <main className="min-h-screen flex bg-gray-50">
      <div className="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800">
        <div className="absolute inset-0 opacity-20">
          <Image
            src="/img/images/bg_login.jpg"
            alt="Background"
            fill
            className="object-cover"
            priority
          />
        </div>
        <div className="relative z-10 flex flex-col justify-center items-center p-12 text-white">
          <div className="max-w-md">
            <h1 className="text-5xl font-bold mb-6">Rejoignez-nous</h1>
            <p className="text-xl text-blue-100 mb-8">
              Créez votre compte et accédez à la plateforme Rame en 5e
            </p>
            <div className="space-y-4">
              <div className="flex items-start space-x-3">
                <svg className="w-6 h-6 text-blue-300 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                </svg>
                <p className="text-blue-100">Inscription gratuite et rapide</p>
              </div>
              <div className="flex items-start space-x-3">
                <svg className="w-6 h-6 text-blue-300 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                </svg>
                <p className="text-blue-100">Accès complet aux fonctionnalités</p>
              </div>
              <div className="flex items-start space-x-3">
                <svg className="w-6 h-6 text-blue-300 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                </svg>
                <p className="text-blue-100">Support dédié</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div className="w-full max-w-md">
          <div className="mb-8 text-center lg:text-left">
            <div className="flex justify-center lg:justify-start mb-6">
              <div className="relative w-24 h-24">
                <Image
                  src="/img/logo/logo_scolaire.png"
                  alt="Logo"
                  fill
                  className="object-contain"
                  priority
                />
              </div>
            </div>
            <h2 className="text-3xl font-bold text-gray-900 mb-2">Créer un compte</h2>
            <p className="text-gray-600">Remplissez le formulaire pour vous inscrire</p>
          </div>

          <div className="bg-white rounded-2xl shadow-xl p-8">
            <form onSubmit={onSubmit} className="space-y-4">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label htmlFor="firstName" className="block text-sm font-semibold text-gray-700 mb-2">
                    Prénom *
                  </label>
                  <input
                    id="firstName"
                    name="firstName"
                    type="text"
                    value={formData.firstName}
                    onChange={handleChange}
                    className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    required
                    disabled={loading}
                  />
                </div>

                <div>
                  <label htmlFor="lastName" className="block text-sm font-semibold text-gray-700 mb-2">
                    Nom *
                  </label>
                  <input
                    id="lastName"
                    name="lastName"
                    type="text"
                    value={formData.lastName}
                    onChange={handleChange}
                    className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    required
                    disabled={loading}
                  />
                </div>
              </div>

              <div>
                <label htmlFor="email" className="block text-sm font-semibold text-gray-700 mb-2">
                  Adresse email *
                </label>
                <input
                  id="email"
                  name="email"
                  type="email"
                  value={formData.email}
                  onChange={handleChange}
                  className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                  required
                  disabled={loading}
                />
              </div>

              <div>
                <label htmlFor="role" className="block text-sm font-semibold text-gray-700 mb-2">
                  Rôle *
                </label>
                <select
                  id="role"
                  name="role"
                  value={formData.role}
                  onChange={handleChange}
                  className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                  required
                  disabled={loading}
                >
                  <option value="PROFESSEUR">Professeur (Collège)</option>
                  <option value="COACH">Coach (Club d'aviron)</option>
                  <option value="ADMIN_LIGUE">Administrateur de Ligue</option>
                </select>
              </div>

              <div>
                <label htmlFor="ligueId" className="block text-sm font-semibold text-gray-700 mb-2">
                  Ligue *
                </label>
                <select
                  id="ligueId"
                  name="ligueId"
                  value={formData.ligueId}
                  onChange={handleChange}
                  className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                  required
                  disabled={loading}
                >
                  <option value="">Sélectionnez une ligue</option>
                  {ligues.map((ligue) => (
                    <option key={ligue.id} value={ligue.id}>
                      {ligue.name}
                    </option>
                  ))}
                </select>
              </div>

              {(formData.role === 'COACH' || formData.role === 'PROFESSEUR') && (
                <div>
                  <label htmlFor="etablissementId" className="block text-sm font-semibold text-gray-700 mb-2">
                    {formData.role === 'PROFESSEUR' ? 'Collège *' : 'Club d\'aviron *'}
                  </label>
                  <select
                    id="etablissementId"
                    name="etablissementId"
                    value={formData.etablissementId}
                    onChange={handleChange}
                    className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    disabled={loading || !formData.ligueId}
                  >
                    <option value="">
                      {formData.role === 'PROFESSEUR' ? 'Sélectionnez un collège' : 'Sélectionnez un club'}
                    </option>
                    {filteredEtablissements.map((etab) => (
                      <option key={etab.id} value={etab.id}>
                        {etab.name}
                      </option>
                    ))}
                  </select>
                  {!formData.ligueId && (
                    <p className="text-xs text-gray-500 mt-1">Sélectionnez d'abord une ligue</p>
                  )}
                  {formData.ligueId && filteredEtablissements.length === 0 && (
                    <p className="text-xs text-orange-600 mt-1">
                      Aucun {formData.role === 'PROFESSEUR' ? 'collège' : 'club'} disponible pour cette ligue
                    </p>
                  )}
                </div>
              )}

              <div>
                <label htmlFor="password" className="block text-sm font-semibold text-gray-700 mb-2">
                  Mot de passe *
                </label>
                <input
                  id="password"
                  name="password"
                  type="password"
                  value={formData.password}
                  onChange={handleChange}
                  className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                  required
                  disabled={loading}
                  minLength={8}
                />
                <p className="text-xs text-gray-500 mt-1">Minimum 8 caractères</p>
              </div>

              <div>
                <label htmlFor="confirmPassword" className="block text-sm font-semibold text-gray-700 mb-2">
                  Confirmer le mot de passe *
                </label>
                <input
                  id="confirmPassword"
                  name="confirmPassword"
                  type="password"
                  value={formData.confirmPassword}
                  onChange={handleChange}
                  className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                  required
                  disabled={loading}
                  minLength={8}
                />
              </div>

              {error && (
                <div className="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                  <div className="flex items-center">
                    <svg className="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                      <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clipRule="evenodd" />
                    </svg>
                    <p className="text-sm text-red-700 font-medium">{error}</p>
                  </div>
                </div>
              )}

              <button
                type="submit"
                disabled={loading}
                className="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 rounded-xl transition duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
              >
                {loading ? (
                  <>
                    <svg className="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                      <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Création...
                  </>
                ) : (
                  'Créer mon compte'
                )}
              </button>
            </form>

            <div className="mt-6 text-center">
              <p className="text-gray-600">
                Vous avez déjà un compte ?{' '}
                <Link href="/login" className="text-blue-600 hover:text-blue-700 font-semibold">
                  Se connecter
                </Link>
              </p>
            </div>
          </div>
        </div>
      </div>
    </main>
  );
}
