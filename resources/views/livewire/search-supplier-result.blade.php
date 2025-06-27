<!-- filepath: c:\Users\lukav\Herd\rijschoolvierkantewielen\resources\views\livewire\search-student-result.blade.php -->
<tbody>
    @if(empty($results[0]))
    <tr>
        <td class="bg-[#F88080] text-center" colspan="5">
            Geen levereanciers gevonden met die naam.
        </td>
    </tr>
    @else
    @foreach($results as $result)
    <tr>
        <td class="p-1 border-t-2 border-[#D0D0D0]">{{$result->firstname}} {{$result->infix}}
            {{$result->lastname}}</td>
        <td class="p-1 border-t-2 border-l-2 border-[#D0D0D0]">{{$result->relation_number}}</td>
        <td class="p-1 border-t-2 border-l-2 border-[#D0D0D0]">{{$result->contact_place}}</td>
        <td class="p-1 border-t-2 border-x-2 border-[#D0D0D0] text-white"><a href=""
                class="p-1 bg-[#9BC8F2] 2xl:w-1/2 w-full m-auto block text-center ">Wijzigen</a></td>
        <td class="p-1 border-t-2 border-[#D0D0D0] text-white"><a href=""
                class="p-1 bg-[#F88080] 2xl:w-1/2 w-full m-auto block text-center ">Verwijderen</a></td>
    </tr>
    @endforeach
    @endif
</tbody>