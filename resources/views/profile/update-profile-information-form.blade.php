<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Nombre -->
        @if (DB::table('users')->where('tipoUsuario', 'Administrador')->where('id', auth()->user()->id)->exists())
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.nombre" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>
        @else
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.nombre" required autocomplete="name" disabled />
            <x-input-error for="name" class="mt-2" />
        </div>
        @endif

        <!-- Apellido Paterno -->
        @if (DB::table('users')->where('tipoUsuario', 'Administrador')->where('id', auth()->user()->id)->exists())
        <div class="col-span-6 sm:col-span-4">
            <x-label for="apPaterno" value="Apellido Paterno" />
            <x-input id="apPaterno" type="text" class="mt-1 block w-full" wire:model.defer="state.apPaterno" required autocomplete="apPaterno" />
            <x-input-error for="apPaterno" class="mt-2" />
        </div>
        @else
        <div class="col-span-6 sm:col-span-4">
            <x-label for="apPaterno" value="Apellido Paterno" />
            <x-input id="apPaterno" type="text" class="mt-1 block w-full" wire:model.defer="state.apPaterno" required autocomplete="apPaterno" disabled />
            <x-input-error for="apPaterno" class="mt-2" />
        </div>
        @endif

        <!-- Apellido Materno -->
        @if (DB::table('users')->where('tipoUsuario', 'Administrador')->where('id', auth()->user()->id)->exists())
        <div class="col-span-6 sm:col-span-4">
            <x-label for="apMaterno" value="Apellido Materno" />
            <x-input id="apMaterno" type="text" class="mt-1 block w-full" wire:model.defer="state.apMaterno" required autocomplete="apMaterno" />
            <x-input-error for="apMaterno" class="mt-2" />
        </div>
        @else
        <div class="col-span-6 sm:col-span-4">
            <x-label for="apMaterno" value="Apellido Materno" />
            <x-input id="apMaterno" type="text" class="mt-1 block w-full" wire:model.defer="state.apMaterno" required autocomplete="apMaterno" disabled />
            <x-input-error for="apMaterno" class="mt-2" />
        </div>
        @endif

        <!-- Telefono -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="telefono" value="Telefono" />
            <x-input id="telefono" type="text" class="mt-1 block w-full" wire:model.defer="state.telefono" required autocomplete="telefono" />
            <x-input-error for="telefono" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
