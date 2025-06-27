<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klanten Overzicht') }}
        </h2>
    </x-slot>

    <main class="mt-10">
        @if ($errors->has('general'))
        <div role="alert" class="w-11/12 m-auto bg-red-200 text-red-900 px-6 py-4 rounded-lg mb-6">
            {{ $errors->first('general') }}
        </div>
        @endif

        <section class="w-full">
            <div class="bg-[#838383] w-1/3 p-4 rounded-r-lg">
                <h3 class="text-2xl text-white text-end">
                    Klanten beheren
                </h3>
            </div>
        </section>

        <section class="my-10">
            <table class="bg-[#FFF8E6] rounded-2xl w-11/12 m-auto text-[#4F4F4F] text-sm">
                <thead class="bg-[#CEEFC1]">
                    <tr>
                        <th class="border-r-2 border-[#D0D0D0] p-2">Gezinsnaam</th>
                        <th class="border-r-2 border-[#D0D0D0]">Adres</th>
                        <th class="border-r-2 border-[#D0D0D0]">Telefoonnummer</th>
                        <th class="border-r-2 border-[#D0D0D0]">E-mailadres</th>
                        <th class="border-r-2 border-[#D0D0D0]">Wijzigen</th>
                        <th>Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @if($customers->isEmpty())
                    <tr>
                        <td colspan="9" class="bg-[#F88080] text-center py-4">
                            Geen klanten gevonden.
                        </td>
                    </tr>
                    @else
                    @foreach($customers as $customer)
                    <tr>
                        <td class="p-2 border-t-2 border-[#D0D0D0]">{{ $customer->GezinsNaam }}</td>
                        <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0]">
                            {{ $customer->Straat }} {{ $customer->Huisnummer }}, {{ $customer->Zipcode }} {{ $customer->Plaats }}
                        </td>
                        <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0]">{{ $customer->Telefoonnummer }}</td>
                        <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0]">{{ $customer->Email }}</td>
                        <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0] text-center">
                            <a href="#" class="block bg-[#9BC8F2] text-white rounded px-2 py-1">Wijzigen</a>
                        </td>
                        <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0] text-center">
                            <a href="#" class="block bg-[#F88080] text-white rounded px-1 py-1">Verwijderen</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </section>

        <div class="w-full flex justify-center my-6">
            <a href="#" class="bg-[#B5D2AA] text-white text-xl px-6 py-3 rounded shadow">
                Klant toevoegen
            </a>
        </div>

        <section>
            {{ $customers->links() }}
        </section>
    </main>
</x-app-layout>