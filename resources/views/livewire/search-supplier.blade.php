<!-- filepath: c:\Users\lukav\Herd\rijschoolvierkantewielen\resources\views\livewire\search-supplier.blade.php -->
<div class="w-3/4 m-auto">
    <div class="mt-2">
        <input id="supplierSearch" type="text" class="p-4 w-full border rounded-md bg-cool-gray-200 text-black"
            wire:model.live.debounce.300ms="searchText" placeholder="supplier met naam zoeken..." oninput="hideSQLTable(value)">
    </div>

    @if($hasResults)
    <!-- Include the search-supplier-result component and pass the results -->
    <table class="bg-[#FFF8E6] rounded-2xl table m-auto w-full text-[#4F4F4F] mt-10">
        <thead class="bg-[#CEEFC1]">
            <tr>
                <th class="border-r-2 border-[#D0D0D0]">Naam</th>
                <th class="border-r-2 border-[#D0D0D0]">Leerling nummer</th>
                <th class="border-r-2 border-[#D0D0D0]">Woonplaats</th>
                <th class="border-r-2 border-[#D0D0D0]">Wijzigen</th>
                <th class="">Verwijderen</th>
            </tr>
        </thead>
      
            @include('livewire.search-supplier-result', ['results' => $results])
        
    </table>
    @endif
</div>