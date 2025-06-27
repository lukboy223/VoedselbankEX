<!-- filepath: c:\Users\lukav\Herd\voedselbank-maaskantje\resources\views\suppliers\show.blade.php -->
<x-app-layout>
   
    <div class="bg-[#838383] w-1/3 p-4 rounded-r-lg">
        <h3 class="w-full text-end text-2xl text-white">
            Leverancier beheren
        </h3>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#FFF8E6] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-[#4F4F4F]">
                    @if(isset($supplier))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Leverancier Informatie -->
                            <div class="p-4 rounded-lg border-2 border-[#D0D0D0]">
                                <h4 class="text-lg font-semibold mb-4 text-[#4F4F4F] bg-[#B5D2AA] rounded-lg text-center">Leverancier Informatie</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="font-medium text-[#4F4F4F]">Leverancier naam:</span>
                                        <span class="ml-2">{{ $supplier->SuppliersName }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-[#4F4F4F]">Contactpersoon:</span>
                                        <span class="ml-2">{{ $supplier->ContactsPersonName }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-[#4F4F4F]">Email:</span>
                                        <span class="ml-2">{{ $supplier->Email }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-[#4F4F4F]">Telefoon:</span>
                                        <span class="ml-2">{{ $supplier->PhoneNumber }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Adresgegevens -->
                            <div class=" p-4 rounded-lg border-2 border-[#D0D0D0]">
                                <h4 class="text-lg font-semibold mb-4 text-[#4F4F4F] bg-[#B5D2AA] rounded-lg text-center">Adresgegevens</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="font-medium text-[#4F4F4F]">Straatnaam:</span>
                                        <span class="ml-2">{{ $supplier->Streetname }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-[#4F4F4F]">Huisnummer:</span>
                                        <span class="ml-2">{{ $supplier->Housenumber }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-[#4F4F4F]">Postcode:</span>
                                        <span class="ml-2">{{ $supplier->ZipCode }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-[#4F4F4F]">Plaats:</span>
                                        <span class="ml-2">{{ $supplier->Place }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Levering Informatie -->
                            <div class="p-4 rounded-lg md:col-span-2 border-2 border-[#D0D0D0]">
                                <h4 class="text-lg font-semibold mb-4 text-[#4F4F4F] bg-[#B5D2AA] rounded-lg text-center">Levering Informatie</h4>
                                <div>
                                    <span class="font-medium text-[#4F4F4F]">Laatste leverdatum:</span>
                                    <span class="ml-2">
                                        @if($supplier->LastShipmentDate)
                                            {{$supplier->LastShipmentDate}}
                                        @else
                                            Geen leveringen
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Actie knoppen -->
                        <div class="mt-6 flex space-x-4">
                            <a href="{{ route('supplier.index') }}" 
                               class="bg-[#B5D2AA] text-white font-bold py-2 px-4 rounded">
                                Terug naar overzicht
                            </a>
                            <a href="{{ route('supplier.edit', $supplier->id) }}" 
                               class="bg-[#9BC8F2] text-white font-bold py-2 px-4 rounded">
                                Bewerken
                            </a>
                        </div>
                    @else
                        <div class="text-center text-[#4F4F4F]">
                            <p>Leverancier gegevens konden niet worden geladen.</p>
                            <a href="{{ route('supplier.index') }}" 
                               class="mt-4 inline-block bg-[#B5D2AA] text-white font-bold py-2 px-4 rounded">
                                Terug naar overzicht
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>