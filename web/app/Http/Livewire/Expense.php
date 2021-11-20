<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Expense as ExpenseModel;
use App\Models\Tags;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Livewire\WithPagination;

class Expense extends Component
{
    use WithPagination;

    public $isModalOpen = 0, $tags=0, $selDate = '', $searchQuery='', $itemsPerPage = 0;
    public ExpenseModel $expense;

    protected $rules = [
        'expense.name' => 'required',
        'expense.price' => 'required',
        'expense.user_id' => '',
        'expense.description' =>'',
        'expense.on_date' => 'required',
        'expense.tags' => '',
        
    ];

    public function mount()
    {
        $this->selDate = Carbon::now()->format('Y-m-d');
        $this->itemsPerPage = 5;
    }
    
    public function render()
    {
        $expenses = ExpenseModel::where('user_id', auth()->user()->id)
                    ->when($this->selDate!='', function($query) {
                        $query->whereDate('on_date', $this->selDate);
                    })
                    ->when($this->searchQuery!='', function($query) {
                        $query->where('name', 'like', '%'.$this->searchQuery.'%');
                        $query->orWhere('tags', 'like', '%'.$this->searchQuery.'%');
                    })
                    ->paginate($this->itemsPerPage);

        return view('livewire.expense.list',[
            "totalExpenses" => 0,
            "expenses" => $expenses,
            "timePeriod" => "Today's",
        ]);
    }

    public function create(){
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
        $this->tags = Tags::where('user_id', auth()->user()->id)->get();
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->expense = new ExpenseModel;
        $this->expense->on_date = date('Y-m-d',strtotime("now"));
    }

    public function store()
    {
        $this->validate();

        $tag = trim($this->expense->tags);
        if(!empty($tag)){
            Tags::updateOrCreate([
                "name" => $tag,
                "user_id" => auth()->user()->id
            ],
            [
                "name" => $tag,
                "user_id" => auth()->user()->id
            ]);
        }
        
        session()->flash('message', isset($this->expense->id) ? 'Expense updated.' : 'Expense created.');
        $this->expense->price = floatval($this->expense->price);
        $this->expense->user_id = auth()->user()->id;
        $this->expense->save();

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($expense_id)
    {
        $expense = ExpenseModel::findOrFail($expense_id);
        $this->expense = $expense;
        $this->expense->price = round($this->expense->price,2);
        $this->openModalPopover();
    }
    
    public function delete($expense_id)
    {
        ExpenseModel::find($expense_id)->delete();
        session()->flash('message', 'Expense deleted.');
    }

    
}
