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
        [
            'id' => '4',
            'amount' => 15.00,
            'currency' => 'USD',
            'invoice_number' => 'GH567890-0004',
            'customer_email' => 'pam@dundermifflin.com',
            'status' => 'unpaid',
            'created_at' => '2024-04-01T10:00:00',
            'due_date' => '2024-04-15T10:00:00',
        ],
        [
            'id' => '5',
            'amount' => 20.00,
            'currency' => 'USD',
            'invoice_number' => 'IJ123456-0005',
            'customer_email' => 'jim@dundermifflin.com',
            'status' => 'outstanding',
            'created_at' => '2024-04-02T11:00:00',
            'due_date' => '2024-04-16T11:00:00',
        ],
        [
            'id' => '6',
            'amount' => 12.00,
            'currency' => 'USD',
            'invoice_number' => 'KL789012-0006',
            'customer_email' => 'dwight@dundermifflin.com',
            'status' => 'draft',
            'created_at' => '2024-04-03T12:00:00',
            'due_date' => null,
        ],
        [
            'id' => '7',
            'amount' => 18.00,
            'currency' => 'USD',
            'invoice_number' => 'MN345678-0007',
            'customer_email' => 'stanley@dundermifflin.com',
            'status' => 'past_due',
            'created_at' => '2024-04-04T13:00:00',
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
        $this->dispatch('dropdown.show', ['openDropdownId' => $this->openDropdownId]);
    }

    public function render()
    {
        return view('livewire.invoices', [
            'invoices' => $this->invoices,
        ]);
    }
}