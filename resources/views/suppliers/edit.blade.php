<x-app-layout>

    
    <main class="mt-10">
        <section class="w-full">
            <div class="bg-[#838383] w-1/3 p-4 rounded-r-lg">
                <h3 class="w-full text-end text-2xl text-white">
                    Leverancier wijzigen
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
            
            <div class="w-full flex justify-center mt-8">
                <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" class="bg-[#FFF8E6] rounded-2xl p-6 w-3/4 text-[#4F4F4F]">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- supplier personal information -->
                        <div class="col-span-1">
                            <h4 class="text-xl mb-4 font-semibold bg-[#CEEFC1] p-2 rounded">Leverancier gegevens</h4>
                            
                            <div class="mb-4">
                                <label for="SuppliersName" class="block mb-1">Bedrijfsnaam</label>
                                <input type="text" name="SuppliersName" id="SuppliersName" value="{{ old('SuppliersName', $supplier->SuppliersName) }}" required 
                                    class="w-full border-gray-300 rounded-md @error('firstname') border-red-500 @enderror">
                                @error('SuppliersName')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="ContactsPersonName" class="block mb-1">Naam contact persoon</label>
                                <input type="text" name="ContactsPersonName" id="ContactsPersonName" value="{{ old('ContactsPersonName', $supplier->ContactsPersonName) }}" required
                                    class="w-full border-gray-300 rounded-md @error('infix') border-red-500 @enderror">
                                @error('ContactsPersonName')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            
                            
                            <!-- Relation number field removed as it's now auto-generated -->
                        </div>
                        
                        <!-- Address information -->
                        <div class="col-span-1">
                            <h4 class="text-xl mb-4 font-semibold bg-[#CEEFC1] p-2 rounded">Adresgegevens</h4>
                            
                            <div class="mb-4">
                                <label for="street_name" class="block mb-1">Straat*</label>
                                <input type="text" name="street_name" id="street_name" value="{{ old('street_name', $supplier->Streetname) }}" required 
                                    class="w-full border-gray-300 rounded-md @error('street_name') border-red-500 @enderror">
                                @error('street_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label for="house_number" class="block mb-1">Huisnummer*</label>
                                    <input type="text" name="house_number" id="house_number" value="{{ old('house_number', $supplier->Housenumber) }}" required 
                                        class="w-full border-gray-300 rounded-md @error('house_number') border-red-500 @enderror">
                                    @error('house_number')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="addition" class="block mb-1">Toevoeging</label>
                                    <input type="text" name="addition" id="addition" value="{{ old('addition', $supplier->Addition) }}" 
                                        class="w-full border-gray-300 rounded-md @error('addition') border-red-500 @enderror">
                                    @error('addition')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="postal_code" class="block mb-1">Postcode*</label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $supplier->ZipCode) }}" required 
                                    class="w-full border-gray-300 rounded-md @error('postal_code') border-red-500 @enderror">
                                @error('postal_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="place" class="block mb-1">Woonplaats*</label>
                                <input type="text" name="place" id="place" value="{{ old('place', $supplier->Place) }}" required 
                                    class="w-full border-gray-300 rounded-md @error('place') border-red-500 @enderror">
                                @error('place')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Contact information -->
                        <div class="col-span-1 md:col-span-2">
                            <h4 class="text-xl mb-4 font-semibold bg-[#CEEFC1] p-2 rounded">Contactgegevens</h4>
                            
                            <div class="mb-4">
                                <label for="email" class="block mb-1">E-mail*</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $supplier->Email) }}" required 
                                    class="w-full border-gray-300 rounded-md @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="phone" class="block mb-1">Telefoonnummer*</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $supplier->PhoneNumber) }}" required 
                                    class="w-full border-gray-300 rounded-md @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Password fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div class="mb-4">
                                    <label for="password" class="block mb-1">Wachtwoord*</label>
                                    <input type="password" name="password" id="password" 
                                        class="w-full border-gray-300 rounded-md @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password_confirmation" class="block mb-1">Wachtwoord bevestigen*</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                        class="w-full border-gray-300 rounded-md">
                                </div>
                            </div>
                            
                            
                            
                            
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-6 pt-4 border-t border-[#D0D0D0]">
                        <a href="{{ route('supplier.index') }}" 
                            class="bg-[#F88080] text-white py-2 px-6 rounded hover:bg-opacity-90">
                            Annuleren
                        </a>
                        <button type="submit" 
                            class="bg-[#B5D2AA] text-white py-2 px-6 rounded hover:bg-opacity-90">
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</x-app-layout>
