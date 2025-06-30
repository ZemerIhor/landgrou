<form wire:submit.prevent="saveAddress" class="bg-white p-6 rounded-xl border">
    <h3 class="text-lg font-semibold mb-4">Персональные данные</h3>

    <div class="space-y-4">
        <x-input.group label="Имя" :error="$errors->first('shipping.first_name')">
            <input wire:model="shipping.first_name" type="text" class="w-full border-gray-300 rounded">
        </x-input.group>

        <x-input.group label="Фамилия" :error="$errors->first('shipping.last_name')">
            <input wire:model="shipping.last_name" type="text" class="w-full border-gray-300 rounded">
        </x-input.group>

        <x-input.group label="Телефон" :error="$errors->first('shipping.contact_phone')">
            <input wire:model="shipping.contact_phone" type="text" class="w-full border-gray-300 rounded">
        </x-input.group>

        <x-input.group label="Email" :error="$errors->first('shipping.contact_email')">
            <input wire:model="shipping.contact_email" type="email" class="w-full border-gray-300 rounded">
        </x-input.group>
    </div>

    <div class="flex justify-end mt-6">
        <button type="submit" class="px-6 py-3 rounded-xl bg-green-600 text-white hover:bg-green-700">
            Продолжить
        </button>
    </div>
</form>
