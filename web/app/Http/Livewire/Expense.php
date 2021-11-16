<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Expense as ExpenseModel;
use App\Models\Tags;

class Expense extends Component
{
    public $isModalOpen = 0;
    public ExpenseModel $expense;

    protected $rules = [
        'expense.name' => 'required',
        'expense.amount' => 'required',
        'expense.description' =>'',
        'expense.on_date' => 'required',
        'expense.tags' => '',
        
    ];
    
    public function render()
    {
        $this->expenses = ExpenseModel::all();
        return view('livewire.expense.list');
    }

    public function create(){
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->expense = new ExpenseModel;
        $this->tags = Tags::all();
        $this->expense->on_date = date('Y-m-d',strtotime("now"));
    }

    public function store()
    {
        $this->validate();

        $tag = trim($this->expense->tags);
        if(!empty($tag)){
            Tags::updateOrCreate([
                "name" => $tag
            ],
            [
                "name" => $tag
            ]);
        }
        
        session()->flash('message', isset($this->expense->id) ? 'Expense updated.' : 'Expense created.');
        $this->expense->save();

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($expense_id)
    {
        $expense = ExpenseModel::findOrFail($expense_id);
        $this->expense = $expense;
        $this->openModalPopover();
    }
    
    public function delete($expense_id)
    {
        ExpenseModel::find($expense_id)->delete();
        session()->flash('message', 'Expense deleted.');
    }
}
