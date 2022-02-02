<x-guest-layout title="ImportTransport">
    <main id="app" class="h-full overflow-y-auto">
        <freight-quote />
    </main>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&language=es&libraries=places"></script>
</x-guest-layout>