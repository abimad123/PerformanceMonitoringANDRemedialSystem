<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Welcome to PMRS! To get started, please complete your profile details below. This helps your teachers track your progress accurately.') }}
    </div>

    <form method="POST" action="{{ route('complete-profile.store') }}">
        @csrf

        <!-- Class -->
        <div>
            <x-input-label for="class" :value="__('Class')" />
            <x-text-input id="class" class="block mt-1 w-full" type="text" name="class" :value="old('class')" required autofocus placeholder="e.g. 10th Standard" />
            <x-input-error :messages="$errors->get('class')" class="mt-2" />
        </div>

        <!-- Section -->
        <div class="mt-4">
            <x-input-label for="section" :value="__('Section')" />
            <x-text-input id="section" class="block mt-1 w-full" type="text" name="section" :value="old('section')" required placeholder="e.g. A" />
            <x-input-error :messages="$errors->get('section')" class="mt-2" />
        </div>

        <!-- Roll Number -->
        <div class="mt-4">
            <x-input-label for="roll_number" :value="__('Roll Number')" />
            <x-text-input id="roll_number" class="block mt-1 w-full" type="text" name="roll_number" :value="old('roll_number')" required placeholder="e.g. 101" />
            <x-input-error :messages="$errors->get('roll_number')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required placeholder="e.g. +91 9876543210" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Complete Profile') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
