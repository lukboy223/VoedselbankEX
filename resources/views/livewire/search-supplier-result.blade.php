<!-- filepath: c:\Users\lukav\Herd\rijschoolvierkantewielen\resources\views\livewire\search-student-result.blade.php -->
<tbody>
    @if(empty($results[0]))
    <tr>
        <td class="bg-[#F88080] text-center" colspan="6">
            Geen levereanciers gevonden met die naam.
        </td>
    </tr>
    @else
    @foreach($results as $supplier)
    <tr>
        <td class="p-1 border-t-2 border-[#D0D0D0]"><a class="underline"
                href="{{route('supplier.show', $supplier->id)}} ">{{$supplier->SuppliersName}}</a></td>
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
            <button type="button" class="p-1 bg-[#F88080] 2xl:w-2/3 w-full m-auto block text-center delete-btn"
                data-supplier-id="{{ $supplier->id }}" data-supplier-name="{{ $supplier->SuppliersName }}">
                Verwijderen
            </button>
        </td>
    </tr>
    @endforeach
    @endif
</tbody>
