<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Expense;

class Dashboard extends Component
{
   public Expense $expense;

    public function render()
    {
        $expenses = Expense::where('user_id', auth()->user()->id)->get()->toArray();
        $data = [];
        foreach($expenses as $expense){
            $record = [];
            $record['date'] = $expense['on_date'];
            $record['amount'] = $expense['price']; 

            $data[] = $record;
        }
        
        return view('dashboard',[
            "expenses" => json_encode($data),
        ]);
    }
}
