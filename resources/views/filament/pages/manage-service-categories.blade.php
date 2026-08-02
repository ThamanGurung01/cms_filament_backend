<x-filament-panels::page>
    <div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: flex-start; width: 100%;">
        
        <!-- Left Column: Form -->
        <div style="flex: 1 1 300px; max-width: 400px; width: 100%;">
            <x-filament::section>
                <x-slot name="heading">
                    {{ $editingId ? 'Edit Category' : 'Create Category' }}
                </x-slot>

                <form wire:submit="save">
                    {{ $this->form }}

                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                        <x-filament::button type="submit">
                            {{ $editingId ? 'Save Changes' : 'Create Category' }}
                        </x-filament::button>

                        @if ($editingId)
                            <x-filament::button color="gray" wire:click="cancel">
                                Cancel
                            </x-filament::button>
                        @endif
                    </div>
                </form>
            </x-filament::section>
        </div>

        <!-- Right Column: Table -->
        <div style="flex: 999 1 600px; width: 100%;">
            <x-filament::section>
                <x-slot name="heading">
                    All Categories
                </x-slot>

                {{ $this->table }}
            </x-filament::section>
        </div>

    </div>
</x-filament-panels::page>
