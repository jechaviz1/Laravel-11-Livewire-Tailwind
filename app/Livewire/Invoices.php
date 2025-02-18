<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;

class Invoices extends Component
{
    public string $activeTab = 'all';
    public ?string $openDropdownId = null;

    private array $sampleInvoices = [
        [
            'id' => '1',
            'amount' => 10.00,
            'currency' => 'USD',
            'invoice_number' => 'BF828438-0001',
            'customer_email' => 'michael@dundermifflin.com',
            'status' => 'draft',
            'created_at' => '2024-03-07T15:36:00',
            'due_date' => null,
        ],
        [
            'id' => '2',
            'amount' => 8.00,
            'currency' => 'USD',
            'invoice_number' => 'ECF27C97-0017',
            'customer_email' => 'alexander@stripe.com',
            'status' => 'paid',
            'created_at' => '2024-03-29T18:32:00',
            'due_date' => null,
        ],
        [
            'id' => '3',
            'amount' => 8.00,
            'currency' => 'USD',
            'invoice_number' => 'FAB3017-0017',
            'customer_email' => 'alexander@stripe.com',
            'status' => 'paid',
            'created_at' => '2024-03-29T18:30:00',
            'due_date' => null,
        ],
    ];

    public function getInvoicesProperty(): Collection
    {
        return collect($this->sampleInvoices)
            ->when($this->activeTab !== 'all', function ($collection) {
                return $collection->where('status', $this->activeTab);
            });
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function toggleDropdown(string $invoiceId): void
    {
        $this->openDropdownId = $this->openDropdownId === $invoiceId ? null : $invoiceId;
    }

    public function render()
    {
        return view('livewire.invoices', [
            'invoices' => $this->invoices,
        ]);
    }
}