<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="mt-6 flex items-center justify-end">
            <x-filament::button type="submit" size="lg">
                Save Homepage Settings
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
