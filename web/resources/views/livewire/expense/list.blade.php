    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todays Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
           
                <button wire:click="create()"
                    class="my-4 inline-flex  float-right rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">
                    Add Expense
                </button>
                @if($isModalOpen)
                @include('livewire.expense.create')
                @endif
                <table class="table-fixed w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Item</th>
                            <th class="px-4 py-2 text-left">Price</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalExpenses = 0;
                        @endphp
                        @foreach($expenses as $expense)
                        <tr>
                            <td class="border px-4 py-2">
                                <h3>{{ $expense->name }}</h3>
                                <p>
                                    <small>{{ $expense->description }}</small>
                                </p>
                            </td>
                            <td class="border px-4 py-2">{{ $expense->price}}</td>
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $expense->id }})"
                                    class="flex px-4 py-2 bg-gray-500 text-gray-900 cursor-pointer">Edit</button>
                                <button wire:click="delete({{ $expense->id }})"
                                    class="flex px-4 py-2 bg-red-100 text-gray-900 cursor-pointer">Delete</button>
                            </td>
                        </tr>
                        @php
                        $totalExpenses += $expense->price;
                        @endphp
                        @endforeach

                        @if($totalExpenses > 0)
                        <tr>
                            <td colspan="3" class="border">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="1" class="border px-4 py-2 text-right"><strong> {{ __('Total Expenses') }}</stromg></td>
                            <td colspan="2" class="border px-4 py-2"> <mark><strong >{{ $totalExpenses }} {{ __('INR') }}</strong></mark></td>
                            
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="3" class="border text-center px-4 py-2">Please add expenses to view them here</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>

