<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Expense as ExpenseModel;

class Expense extends Component
{
    public $expense_id,$name,$description,$amount,$date,$tags;
    public $isModalOpen = 0;
    
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
        $this->name = '';
        $this->description = '';
        $this->amount = '';
        $this->date = '';
        $this->tags = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);
    
        ExpenseModel::updateOrCreate(['id' => $this->id], [
            'name' => $this->name,
            'description' => $this->description,
            'amount' => $this->amount,
            'date' => $this->date,
            'tags' => $this->tags,
        ]);

        session()->flash('message', $this->id ? 'Expense updated.' : 'Expense created.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($expense_id)
    {
        $expense = ExpenseModel::findOrFail($expense_id);
        $this->id = $expense_id;
        $this->name = $expense->name;
        $this->description = $expense->description;
        $this->amount = $expense->amount;
        $this->tags = $expense->tags;
        $this->date = $expense->created_at;
        $this->openModalPopover();
    }
    
    public function delete($expense_id)
    {
        ExpenseModel::find($expense_id)->delete();
        session()->flash('message', 'Expense deleted.');
    }
}
