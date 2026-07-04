<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Rôle -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Je suis un')" />
            <select name="role" id="role"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>
                    👤 Client — Je veux prendre des RDV
                </option>
                <option value="prestataire" {{ old('role') === 'prestataire' ? 'selected' : '' }}>
                    👨‍💼 Prestataire — Je propose des services
                </option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Catégorie (prestataire seulement) -->
        <div class="mt-4" id="category-field" style="display:none;">
            <x-input-label for="category" :value="__('Type de service')" />
            <select name="category" id="category"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Choisir --</option>
                <option value="coiffeur">✂️ Coiffeur</option>
                <option value="dentiste">🦷 Dentiste</option>
                <option value="coach">💪 Coach</option>
                <option value="medecin">🩺 Médecin</option>
                <option value="autre">🔧 Autre</option>
            </select>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Message prestataire -->
        <div id="prestataire-msg" class="mt-4 p-3 rounded-lg text-sm" 
             style="display:none; background:#ede9ff; color:#553c9a;">
            ⚠️ Votre compte sera activé après validation par l'admin.
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900"
               href="{{ route('login') }}">
                Déjà inscrit?
            </a>
            <x-primary-button class="ms-4">
                S'inscrire
            </x-primary-button>
        </div>
    </form>

    <!-- Script afficher/cacher category -->
    <script>
        const roleSelect = document.getElementById('role');
        const categoryField = document.getElementById('category-field');
        const prestataireMsg = document.getElementById('prestataire-msg');

        roleSelect.addEventListener('change', function() {
            if (this.value === 'prestataire') {
                categoryField.style.display = 'block';
                prestataireMsg.style.display = 'block';
            } else {
                categoryField.style.display = 'none';
                prestataireMsg.style.display = 'none';
            }
        });
    </script>
</x-guest-layout>