<x-app-layout>
    <main class="mt-10">
        <section class=" w-full">

            <div class="bg-[#838383] w-1/3 p-4 rounded-r-lg">
                <h3 class="w-full text-end text-2xl text-white">
                    Leveranciers beheren
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

            <div class="w-full flex justify-center">

                <a href="{{ route('supplier.create') }}"
                    class=" bg-[#B5D2AA] rounded text-white text-2xl p-4">Toevoegen
                </a>
            </div>
        </section>


        <section class="my-10">
            @livewire('search-supplier')
        </section>
        <section class="my-10" id="tableSQL">

            <table class="bg-[#FFF8E6] rounded-2xl table m-auto w-3/4 text-[#4F4F4F]">
                <thead class="bg-[#CEEFC1] ">
                    <tr>
                        <th class=" border-r-2 border-[#D0D0D0]">Bedrijfs naam</th>
                        <th class=" border-r-2 border-[#D0D0D0]">Contact persoon</th>
                        <th class=" border-r-2 border-[#D0D0D0]">Telefoon nummer</th>
                        <th class=" border-r-2 border-[#D0D0D0]">Eerst volgende levering</th>
                        <th class=" border-r-2 border-[#D0D0D0]">Wijzigen</th>
                        <th class="">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @if($suppliers->IsEmpty())
                    <tr>
                        <td class="bg-[#F88080] text-center" colspan="5">
                            Geen supplieren gevonden, probeer het later opnieuw
                        </td>
                    </tr>
                    @else
                    @foreach($suppliers as $supplier)
                    <tr>
                        <td class="p-1 border-t-2 border-[#D0D0D0]"><a class="underline" href="{{route('supplier.show', $supplier->id)}} ">{{$supplier->SuppliersName}}</a></td>
                        <td class="p-1 border-t-2 border-l-2 border-[#D0D0D0]">{{$supplier->ContactsPersonName}}</td>
                        <td class="p-1 border-t-2 border-l-2 border-[#D0D0D0]">{{$supplier->PhoneNumber}}</td>
                        <td class="p-1 border-t-2 border-l-2 border-[#D0D0D0]">
                            @if($supplier->LastShipmentDate)
                                {{$supplier->LastShipmentDate}}
                            @else
                                Geen leveringen
                            @endif
                        </td>
                        <td class="p-1 border-t-2 border-x-2 border-[#D0D0D0] text-white"><a
                                href="{{ route('supplier.edit', $supplier->id) }}"
                                class="p-1 bg-[#9BC8F2] 2xl:w-2/3 w-full m-auto block text-center ">Wijzigen</a></td>
                        <td class="p-1 border-t-2 border-[#D0D0D0] text-white">
                            <button type="button"
                                class="p-1 bg-[#F88080] 2xl:w-2/3 w-full m-auto block text-center delete-btn"
                                data-supplier-id="{{ $supplier->id }}"
                                data-supplier-name="{{ $supplier->SuppliersName }}">
                                Verwijderen
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

        </section>
        <section class="m-10">

            {{$suppliers->links()}}
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