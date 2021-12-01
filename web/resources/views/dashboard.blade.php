<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                Graphs to be populated here
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.1.1/d3.min.js" integrity="sha512-COTaPOlz12cG4fSfcBsxZsjauBAyldqp+8FQUM/dZHm+ts/jR4AFoJhCqxy8K10Jrf3pojfsbq7fAPTb1XaVkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</x-app-layout>