<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nieuwe klant toevoegen') }}
        </h2>
    </x-slot>

    <main class="mt-10">
        @if ($errors->any())
        <div role="alert" class="w-11/12 m-auto bg-red-200 text-red-900 px-6 py-4 rounded-lg mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <section class="w-full">
            <div class="bg-[#838383] w-1/3 p-4 rounded-r-lg">
                <h3 class="text-2xl text-white text-end">
                    Klant toevoegen
                </h3>
            </div>
        </section>

        <form action="{{ route('customers.store') }}" method="POST" class="mt-6 w-11/12 m-auto">
            @csrf

            <div class="bg-[#FFF8E6] rounded-2xl p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-[#4F4F4F] text-sm">
                <!-- Adres gegevens -->
                <div>
                    <h3 class="bg-[#CEEFC1] px-3 py-2 rounded-md font-semibold mb-4">
                        Adresgegevens
                    </h3>

                    <div class="mb-4">
                        <label class="block mb-1">Straatnaam</label>
                        <input type="text" name="Streetname" placeholder="Lindelaan..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Huisnummer</label>
                        <input type="text" name="Housenumber" placeholder="12..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Toevoeging</label>
                        <input type="text" name="toevoeging" placeholder="B..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Plaats</label>
                        <input type="text" name="Place" placeholder="Amersfoort..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Postcode</label>
                        <input type="text" name="Zipcode" placeholder="3811AB..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                </div>

                <!-- Algemene gegevens -->
                <div>
                    <h3 class="bg-[#CEEFC1] px-3 py-2 rounded-md font-semibold mb-4">
                        Algemene gegevens
                    </h3>

                    <div class="mb-4">
                        <label class="block mb-1">Gezinsnaam</label>
                        <input type="text" name="GezinsNaam" placeholder="De Vries..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Telefoonnummer</label>
                        <input type="tel" name="PhoneNumber" placeholder="06 12345678..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">E-mailadres</label>
                        <input type="email" name="Email" placeholder="voorbeeld@gmail.com..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-8">
                <button type="submit" class="bg-[#B5D2AA] hover:bg-[#A4C69A] text-white text-lg px-6 py-2 rounded shadow">
                    Klant opslaan
                </button>
                <a href="{{ route('customers.index') }}" class="bg-[#B5D2AA] hover:bg-[#A4C69A] text-white text-lg px-6 py-2 rounded shadow">
                    Terug naar overzicht
                </a>
            </div>
        </form>
    </main>
</x-app-layout>