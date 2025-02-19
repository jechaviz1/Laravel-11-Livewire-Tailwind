<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Invoices</h1>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Create invoice
                </button>
            </div>
        </div>

        <div class="mt-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                @php
                    $tabs = [
                        'all' => 'All invoices',
                        'draft' => 'Draft',
                        'outstanding' => 'Outstanding',
                        'past_due' => 'Past due',
                        'paid' => 'Paid',
                    ];
                @endphp

                @foreach ($tabs as $key => $label)
                    <button wire:click="setActiveTab('{{ $key }}')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm
                        {{ $activeTab === $key
                            ? 'border-indigo-500 text-indigo-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        }}">
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>

        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        Amount
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-sm font-semibold text-gray-900">
                                        Invoice Number
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-sm font-semibold text-gray-900">
                                        Customer
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-sm font-semibold text-gray-900">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-sm font-semibold text-gray-900">
                                        Created
                                    </th>
                                    <th scope="col" class="relative py-2 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm sm:pl-6">
                                            <div class="flex items-center">
                                                <span class="font-medium text-gray-900">
                                                    ${{ number_format($invoice['amount'], 2) }}
                                                </span>
                                                <span class="text-gray-500 ml-1">{{ $invoice['currency'] }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                            {{ $invoice['invoice_number'] }}
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                            {{ $invoice['customer_email'] }}
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm">
                                            <span @class([
                                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                'bg-gray-100 text-gray-800' => $invoice['status'] === 'draft',
                                                'bg-yellow-100 text-yellow-800' => $invoice['status'] === 'outstanding',
                                                'bg-green-100 text-green-800' => $invoice['status'] === 'paid',
                                                'bg-blue-100 text-blue-800' => $invoice['status'] === 'past_due',
                                            ])>
                                                {{ str_replace('_', ' ', ucfirst($invoice['status'])) }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($invoice['created_at'])->format('M j, g:i A') }}
                                        </td>
                                        <td class="whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <div>
                                                <button wire:click="toggleDropdown('{{ $invoice['id'] }}')"
                                                    class="text-gray-400 hover:text-gray-500 btn-toggle">
                                                    <span class="sr-only">Open options</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                    </svg>
                                                </button>

                                                @if ($openDropdownId === $invoice['id'])
                                                    <div class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none transform transition ease-out duration-100 drop-down hidden">
                                                        <h4 class="px-4 py-3 text-sm font-semibold text-gray-500 text-left uppercase">Actions</h4>
                                                        <button class="block w-full px-4 py-2 text-sm text-left text-blue-500 hover:bg-gray-100">
                                                            Download PDF
                                                        </button>
                                                        <button class="block w-full px-4 py-2 text-sm text-left text-blue-500 hover:bg-gray-100">
                                                            Duplicate Invoice
                                                        </button>
                                                        @if ($invoice['status'] === 'draft')
                                                            <button class="block w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-gray-100">
                                                                Delete draft
                                                            </button>
                                                        @endif
                                                        <hr class="my-2">
                                                        <h4 class="px-4 py-2 text-sm font-semibold text-gray-500 text-left uppercase">Connections</h4>
                                                        <button class="block w-full px-4 pt-2 pb-3 text-sm text-left text-blue-500 hover:bg-gray-100 flex items-center">
                                                            View customer
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" class="h-5 w-5 fill-current text-blue-700 ml-2">
                                                                <path d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@script
<script>
    Livewire.on('dropdown.show', (data) => {
        const openDropdownId = data[0].openDropdownId || null;
        if (openDropdownId !== null) {
            setTimeout(() => {
                const dropdowns = document.querySelectorAll('.drop-down');
                if (dropdowns.length > 0) {
                    dropdowns.forEach(dropdown => {
                        const btnToggle = dropdown.closest('td').querySelector('.btn-toggle');
                        const rect = btnToggle.getBoundingClientRect();
                        dropdown.style.left = `${rect.left + window.scrollX - 180}px`;
                        dropdown.style.top = `${rect.bottom + window.scrollY}px`;
                        dropdown.classList.remove('hidden');
                    });
                }
            }, 10);
        }
    });

    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.drop-down');
        const isClickInsideToggle = Array.from(document.querySelectorAll('.btn-toggle'))
            .some(btnToggle => btnToggle.contains(event.target));
        if (dropdown && !dropdown.contains(event.target) && !isClickInsideToggle) {
            @this.set('openDropdownId', null);
        }
    });
</script>
@endscript