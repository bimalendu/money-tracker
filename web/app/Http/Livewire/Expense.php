<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Expense as ExpenseModel;
use App\Models\Tags;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class Expense extends Component
{
    public $isModalOpen = 0, $tags=0, $selDate = '', $timePeriod = '';
    public ExpenseModel $expense;

    protected $rules = [
        'expense.name' => 'required',
        'expense.price' => 'required',
        'expense.user_id' => '',
        'expense.description' =>'',
        'expense.on_date' => 'required',
        'expense.tags' => '',
        
    ];
    
    public function render()
    {
        $date = Carbon::today();
        if(empty($this->selDate)){
            $this->selDate = $date->toDateString();
        }

        $this->timePeriod = $date;
        $this->timePeriod = $this->timePeriod->diffForHumans(Carbon::parse($this->selDate), [
            'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
            'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS,
        ]);

        $this->expenses = ExpenseModel::where('user_id', auth()->user()->id)->where('on_date',$this->selDate)->get();
        
        return view('livewire.expense.list',[
            "totalExpenses" => 0
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
        $this->expense->user_id = auth()->user()->id;
        $this->expense->save();

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($expense_id)
    {
        $expense = ExpenseModel::findOrFail($expense_id);
        $this->expense = $expense;
        $this->expense->price = format_money($this->expense->price);
        $this->openModalPopover();
    }
    
    public function delete($expense_id)
    {
        ExpenseModel::find($expense_id)->delete();
        session()->flash('message', 'Expense deleted.');
    }

    public function updateExpenseView(){
        $date = Carbon::today();
        $this->timePeriod = $date;
        $this->timePeriod = $this->timePeriod->diffForHumans(Carbon::parse($this->selDate), [
            'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
            'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS,
        ]);
        
        $this->expenses = ExpenseModel::where('user_id', auth()->user()->id)->where('on_date',$this->selDate)->get();
        
    }
}
