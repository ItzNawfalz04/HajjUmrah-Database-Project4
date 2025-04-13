<x-filament-widgets::widget>
    <x-filament::section>
    <div class="w-full flex justify-between items-center p-1">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-gray-800">
                {{ __('welcome.greeting', ['name' => auth()->user()->name]) }}
            </h1>
            <p class="text-gray-600">
                <em>{{ __('welcome.welcome_message') }}</em>
            </p>
            
            <!-- Sign Out Button -->
            <form method="POST" action="{{ filament()->getLogoutUrl() }}">
                @csrf
                <button 
                    type="submit"
                    class="mt-2 bg-primary-500 hover:bg-primary-600 active:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-100"
                >
                    {{ __('welcome.sign_out') }}
                </button>
            </form>
        </div>
        
        <img 
            src="{{ asset('images/logo.png') }}" 
            alt="Company Logo" 
            style="height: 104px; width: auto;"
        >
    </div>
    </x-filament::section>
</x-filament-widgets::widget>
