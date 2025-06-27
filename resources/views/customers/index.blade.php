<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klanten Overzicht') }}
        </h2>
    </x-slot>

    <main class="mt-10">
        <section class=" w-full">

            <div class="bg-[#838383] w-1/3 p-4 rounded-r-lg">
                <h3 class="w-full text-end text-2xl text-white">
                    Klanten beheren
                </h3>
            </div>
            @if(session('success'))
            <div class="bg-[#B5D2AA] w-1/3 p-4 rounded-r-lg mt-4">
                <h3 class="w-full text-end text-2xl text-white">
                    {{ session('success') }}
                </h3>
            </div>
            @elseif(session('error'))
            <div class="bg-[#F88080] w-1/3 p-4 rounded-r-lg mt-4">
                <h3 class="w-full text-end text-2xl text-white">
                    {{ session('error') }}
                </h3>
            </div>
            @endif


            <section class="my-10">
                <table class="bg-[#FFF8E6] rounded-2xl w-11/12 m-auto text-[#4F4F4F] text-sm">
                    <thead class="bg-[#CEEFC1]">
                        <tr>
                            <th class="border-r-2 border-[#D0D0D0] p-2">Gezinsnaam</th>
                            <th class="border-r-2 border-[#D0D0D0]">Adres</th>
                            <th class="border-r-2 border-[#D0D0D0]">Telefoonnummer</th>
                            <th class="border-r-2 border-[#D0D0D0]">E-mailadres</th>
                            <th class="border-r-2 border-[#D0D0D0]">Volwassenen</th>
                            <th class="border-r-2 border-[#D0D0D0]">Kinderen</th>
                            <th class="border-r-2 border-[#D0D0D0]">Baby's</th>
                            <th class="border-r-2 border-[#D0D0D0]">Wensen</th>
                            <th class="border-r-2 border-[#D0D0D0]">Aangemaakt</th>
                            <th class="border-r-2 border-[#D0D0D0]">Bijgewerkt</th>
                            <th class="border-r-2 border-[#D0D0D0]">Wijzigen</th>
                            <th>Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($customers->isEmpty())
                        <tr>
                            <td colspan="13" class="bg-[#F88080] text-center py-4">
                                Geen klanten gevonden, probeer het later opnieuw.
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
                            <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0]">{{ $customer->AmountAdults }}</td>
                            <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0]">{{ $customer->AmoundChilderen }}</td>
                            <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0]">{{ $customer->Amountbabies }}</td>
                            <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0]">{{ $customer->Wishes }}</td>
                            <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0]">{{ \Carbon\Carbon::parse($customer->Created_at)->format('d-m-Y H:i') }}</td>
                            <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0]">{{ \Carbon\Carbon::parse($customer->Updated_at)->format('d-m-Y H:i') }}</td>
                            <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0] text-center">
                                <a href="{{ route('customers.edit', $customer->id) }}" class="block bg-[#9BC8F2] text-white rounded px-2 py-1">Wijzigen</a>
                            </td>
                            <td class="p-2 border-t-2 border-l-2 border-[#D0D0D0] text-center">
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze klant wilt verwijderen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white rounded px-2 py-1">
                                        Verwijderen
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>

            </section>

            <div class="w-full flex justify-center my-6">
                <a href="{{ route('customers.create') }}" class="bg-[#B5D2AA] text-white text-xl px-6 py-3 rounded shadow">
                    Klant toevoegen
                </a>
            </div>

            <section>
                {{ $customers->links() }}
            </section>
    </main>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <div class="flex flex-col">
                <h2 class="text-xl font-bold mb-4 text-[#4F4F4F]">Leverancier verwijderen</h2>
                <p class="mb-6 text-gray-700">
                    Weet je zeker dat je <span id="supplierName" class="font-semibold"></span> wilt verwijderen?
                    Deze actie kan niet ongedaan gemaakt worden.
                </p>

                <div class="flex justify-end space-x-4">
                    <button type="button" id="cancelDelete"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                        Annuleren
                    </button>

                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-[#F88080] text-white px-4 py-2 rounded hover:bg-red-700">
                            Verwijderen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get DOM elements
        const deleteModal = document.getElementById('deleteModal');
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const cancelDelete = document.getElementById('cancelDelete');
        const deleteForm = document.getElementById('deleteForm');
        const supplierNameSpan = document.getElementById('supplierName');

        // Add click event listeners to all delete buttons
        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Get supplier info from data attributes
                const SupplierId = button.getAttribute('data-supplier-id');
                const supplierName = button.getAttribute('data-supplier-name');
                console.log(SupplierId, supplierName);

                // Update modal content
                supplierNameSpan.textContent = supplierName;
                deleteForm.action = `/leveranciers/${SupplierId}/delete`;

                // Show modal
                deleteModal.classList.remove('hidden');
            });
        });

        // Hide modal when cancel button is clicked
        cancelDelete.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
        });

        // Hide modal when clicking outside of it
        deleteModal.addEventListener('click', (e) => {
            if (e.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>