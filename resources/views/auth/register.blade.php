<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- NIP -->
        <div>
            <x-input-label for="nip" :value="__('Nip')" />
            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip')" required
                autofocus autocomplete="nip" />
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                required autofocus autocomplete="address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Position -->
        <div>
            <x-input-label for="position" :value="__('Position')" />
            <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')"
                required autofocus autocomplete="position" />
            <x-input-error :messages="$errors->get('position')" class="mt-2" />
        </div>

        <!-- Company ID : masih belum diambil request data-->
        <div>
            <x-input-label for="company_id" :value="__('Company Name')" />
            {{-- @foreach ($companies as $company) --}}
            <x-input id="company_id" name="company_id" type="select" :options="$companies->pluck('name', 'id')->toArray()" :value="old('company_id')" />
            {{-- @endforeach --}}
            <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
        </div>

        <!-- Role : harusnya enum -->
        <div>
            <x-input-label for="role_id" :value="__('Role Name')" />
            {{-- @foreach ($companies as $company) --}}
            <x-input id="role_id" name="role_id" type="select" :options="$roles->pluck('name', 'id')->toArray()" :value="old('role_id')" />
            {{-- @endforeach --}}
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
