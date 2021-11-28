
<x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $timePeriod}} {{ __('Income ') }} 
        </h2> 
</x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
             @if (session()->has('message'))
            <div class="px-4 py-3 my-3 text-teal-900 bg-teal-100 border-t-4 border-teal-500 rounded-b shadow-md"
                role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif
            <div wire:loading>
                    Please Wait, Loading Data...
            </div>
            <div class="px-4 py-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">
           
                <input type="text" wire:model="searchQuery" class="mt-2 mb-4 form-input" placeholder="Search">
                <input type="date" wire:model="selDate" class="mt-2 mb-4 form-input" placeholder="Choose Date" max="@php echo date("Y-m-d"); @endphp">
                <select wire:model="itemsPerPage" class="form-input">
                    <optgroup label="No. of items per page">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="0">All</option>
                    </optgroup>
                </select>
                
           
                <button wire:click="create()"
                    class="inline-flex float-right px-4 py-2 my-4 text-base font-bold text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700">
                    Add Income
                </button>
               
                
                <table class="w-full table-fixed">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Item</th>
                            <th class="px-4 py-2 text-left">Price</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomeRecords as $income)
                        <tr>
                            <td class="px-4 py-2 border">
                                <h3>{{ $income->name }}</h3>
                                <p class="mx-3">
                                    <small>{!! nl2br($income->description) !!}</small>
                                </p>
                            </td>
                            <td class="px-4 py-2 border">
                                @php
                                    echo format_money($income->price);
                                @endphp
                            </td>
                            <td class="px-4 py-2 border">
                                <button wire:click="edit({{ $income->id }})"
                                    class="flex px-4 py-2 text-gray-900 bg-gray-500 cursor-pointer">Edit</button>
                                <button onclick="return confirm('Do you want to delete this income ?') || event.stopImmediatePropagation()"wire:click="delete({{ $income->id }})"
                                    class="flex px-4 py-2 text-gray-900 bg-red-100 cursor-pointer">Delete</button>
                            </td>
                        </tr>
                        @endforeach

                        @if($totalIncome > 0)
                        <tr>
                            <td colspan="3" class="border">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="1" class="px-4 py-2 text-right border"><strong> {{ __('Total Incomes') }}</stromg></td>
                            <td colspan="2" class="px-4 py-2 border"> 
                                
                                    <strong>
                                        @php
                                            echo format_money($totalIncome);
                                        @endphp
                                    </strong>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        @else
                        <tr>
                            @if($searchQuery!='')
                                <td colspan="3" class="px-4 py-2 text-center borde">No results found for <q>{{ $searchQuery }}</q></td>
                            @else
                                <td colspan="3" class="px-4 py-2 text-center border">Please add income to view them here</td>
                            @endif
                            
                        </tr>
                        @endif
                    </tbody>
                </table>
                {{ $income->links() }}
                @if($isModalOpen)
                    @include('livewire.income.create')
                @endif
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
    

