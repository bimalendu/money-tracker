
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="fixed inset-0 z-10 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
               
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="">
                        <h2 class="mb-4 text-xl font-semibold leading-tight text-gray-800">
                            {{ __('Add Income') }}
                        </h2>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1"
                                class="block mb-2 text-sm font-bold text-gray-700"><abbr title="Please enter the name of income source">Name</abbr></label>
                            <input type="text"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="exampleFormControlInput1" placeholder="Name of the item" wire:model.lazy="income.name" required>
                            @error('income.name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2"
                                class="block mb-2 text-sm font-bold text-gray-700"><abbr title="Please enter more information about the income source">Description</abbr></label>
                            <textarea
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="exampleFormControlInput2" wire:model.lazy="income.description"
                                placeholder="More information about the income source"></textarea>
                            @error('income.description') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput3"
                                class="block mb-2 text-sm font-bold text-gray-700"><abbr title="Please enter the amount earned">Amount({{ currency_symbol()}})</abbr></label>
                            <input type="text"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="exampleFormControlInput3" placeholder="Amount earned" wire:model.lazy="income.price" required>
                            @error('income.price') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div> 
                        <div class="mb-4">
                            <label for="exampleFormControlInput4"
                                class="block mb-2 text-sm font-bold text-gray-700"><abbr title="Please mention a category for the income source">Tags</abbr></label>
                            <input type="text"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="exampleFormControlInput4" placeholder="Income Source Category" wire:model.lazy="income.tags" list="tags">
                            <datalist id="tags">
                                @foreach($tags as $tag)
                                    <option value="{{ ucwords($tag->name) }}">
                                @endforeach
                            </datalist>
                            @error('income.tags') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>      
                        <div class="mb-4">
                            <label for="exampleFormControlInput5"
                                class="block mb-2 text-sm font-bold text-gray-700">Purchased on</label>
                            <input type="date"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="exampleFormControlInput5" placeholder="Date" wire:model.lazy="income.on_date" required>
                            @error('income.on_date') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>                   
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="store()" type="button"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-bold leading-6 text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green sm:text-sm sm:leading-5">
                            Save
                        </button>
                    </span>
                    <span class="flex w-full mt-3 rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeModalPopover()" type="button"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-bold leading-6 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5">
                            Close
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>


