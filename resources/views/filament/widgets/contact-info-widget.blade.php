<x-filament-widgets::widget>
    <x-filament::section>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-4 p-6">
            <div class="space-y-2">
                <img 
                    src="{{ asset('images/logo.png') }}" 
                    alt="Company Logo" 
                    style="height: 128px; width: auto;"
                >
                <p class="font-semibold text-gray-800">{{ __('contact_info.company_name') }}</p>
                <p class="text-gray-600">{{ __('contact_info.address') }}</p>
            </div>

            <div class="space-y-2">
                <p class="font-semibold text-gray-800">{{ __('contact_info.operating_hours') }}</p>
                <p class="text-gray-600">{{ __('contact_info.hours') }}</p>
                <p class="font-semibold text-gray-800">{{ __('contact_info.phone_number') }}</p>
                <p class="text-gray-600">+603 2789 1133</p>
                <p class="text-gray-600">+6019 345 1174</p>
                <p class="font-semibold text-gray-800">{{ __('contact_info.email') }}</p>
                <p class="text-gray-600">salam@feldatravel.com.my</p>
            </div>

            <div class="space-y-2">
                <p class="font-semibold text-gray-800">{{ __('contact_info.follow_us') }}</p>
                <div class="flex flex-wrap justify-start gap-4">  
                    <a href="https://www.facebook.com/FeldaTravel" class="text-gray-600 hover:text-primary-600 transition duration-300">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                    <a href="https://www.instagram.com/feldatravel/?hl=en" class="text-gray-600 hover:text-primary-600 transition duration-300">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/feldatravel/" class="text-gray-600 hover:text-primary-600 transition duration-300">
                        <i class="fab fa-linkedin fa-lg"></i>
                    </a>
                </div>
                <p class="text-gray-600 text-sm mt-4">{{ __('contact_info.copyright') }}</p>
                <p class="font-semibold text-gray-800 text-sm mt-0">{{ __('contact_info.company_info') }}</p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
