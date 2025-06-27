<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\Component;

class SearchSupplier extends Component
{
    public $searchText = '';
    public $results = [];
    public $hasResults = false;



    public function updatedSearchText()
    {
        if ($this->searchText == '') {
            $this->results = [];
            $this->hasResults = false;

        } else {

            $this->results = Supplier::join('users', 'suppliers.user_id', '=', 'users.id')
                ->join('contacts', 'users.contacts_id', '=', 'contacts.id')
                ->join('shipments', 'suppliers.id', '=', 'shipments.suppliers_id')
                ->groupBy('suppliers.id')
                ->select('suppliers.id', 'suppliers.SuppliersName', 'contacts.PhoneNumber', 'suppliers.ContactsPersonName', 'max(shipments.DateDelivery) as LastShipmentDate')
                ->where('suppliers.SuppliersName', 'like', '%' . $this->searchText . '%')
                ->get();
                $this->hasResults = !empty($this->results);
        }
    }

    public function clearResults()
    {
        $this->searchText = '';
        $this->results = [];
    }

    public function render()
    {
        return view('livewire.search-supplier', ['results' => $this->results]);
    }
}