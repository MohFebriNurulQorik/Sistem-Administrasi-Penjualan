<section class="space-y-6">

    <header>
        <h2 class="text-xl font-black text-slate-800">
            Delete Account
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data you wish to retain.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 rounded-2xl font-bold"
    >
        Delete Account
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        <form method="post" action="{{ route('profile.destroy') }}"
              class="p-6 bg-white rounded-2xl">

            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-slate-800">
                Are you sure you want to delete your account?
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                This action is permanent. Please enter your password to confirm deletion.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">

                <x-secondary-button
                    x-on:click="$dispatch('close')"
                    class="px-5 py-2 rounded-xl"
                >
                    Cancel
                </x-secondary-button>

                <x-danger-button class="px-6 py-2 rounded-xl font-bold">
                    Delete Account
                </x-danger-button>

            </div>

        </form>

    </x-modal>
</section>