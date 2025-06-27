<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klant bewerken') }}
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
                    Klant bewerken
                </h3>
            </div>
        </section>

        <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="mt-6 w-11/12 m-auto">
            @csrf
            @method('PATCH')

            <div class="bg-[#FFF8E6] rounded-2xl p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-[#4F4F4F] text-sm">
                <!-- Adresgegevens -->
                <div>
                    <h3 class="bg-[#CEEFC1] px-3 py-2 rounded-md font-semibold mb-4">
                        Adresgegevens
                    </h3>

                    <div class="mb-4">
                        <label class="block mb-1">Straatnaam</label>
                        <input type="text" name="Streetname" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('Streetname', $customer->Streetname) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Huisnummer</label>
                        <input type="text" name="Housenumber" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('Housenumber', $customer->Housenumber) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Plaats</label>
                        <input type="text" name="Place" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('Place', $customer->Place) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Postcode</label>
                        <input type="text" name="Zipcode" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('Zipcode', $customer->Zipcode) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Telefoonnummer</label>
                        <input type="tel" name="PhoneNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('PhoneNumber', $customer->PhoneNumber) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">E-mailadres</label>
                        <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('email', $customer->email) }}">
                    </div>
                </div>

                <!-- Algemene gegevens -->
                <div>
                    <h3 class="bg-[#CEEFC1] px-3 py-2 rounded-md font-semibold mb-4">
                        Algemene gegevens
                    </h3>

                    <div class="mb-4">
                        <label class="block mb-1">Gezinsnaam</label>
                        <input type="text" name="GezinsNaam" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('GezinsNaam', $customer->GezinsNaam) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Aantal volwassenen</label>
                        <input type="number" name="AmountAdults" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('AmountAdults', $customer->AmountAdults) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Aantal kinderen</label>
                        <input type="number" name="AmoundChilderen" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('AmoundChilderen', $customer->AmoundChilderen) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Aantal baby’s</label>
                        <input type="number" name="Amountbabies" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('Amountbabies', $customer->Amountbabies) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Wensen</label>
                        <textarea name="Wishes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('Wishes', $customer->Wishes) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-8">
                <button type="submit" class="bg-[#B5D2AA] hover:bg-[#A4C69A] text-white text-lg px-6 py-2 rounded shadow">
                    Wijzigingen opslaan
                </button>
                <a href="{{ route('customers.index') }}" class="bg-[#B5D2AA] hover:bg-[#A4C69A] text-white text-lg px-6 py-2 rounded shadow">
                    Terug naar overzicht
                </a>
            </div>
        </form>
    </main>
</x-app-layout>