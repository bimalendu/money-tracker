<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Expense;
use stdClass;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $year= null;

    function mount()
    {
        $this->year = $this->year ?? date("Y");
    }

    public function render()
    {
        $expenseData = Expense::where('user_id', auth()->user()->id)
                    ->whereYear('created_at',$this->year)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function($date) {
                        return Carbon::parse($date->created_at)->format('m');
                    })
                    ->toArray();

        
        
        $records = [];
        $column = 0;

        foreach($expenseData as $month_key => $expenses){
            
            $data = new stdClass();

            foreach($expenses as $expense){
                $data->values[] = $expense['price'];
                $data->labels[] = $expense['tags'];
            }

            $data->domain = new stdClass();
            $data->domain->column = $column;
            $data->type = "pie";
            $data->title = new StdClass();
            $data->title->text = "Expenses for ".date('M Y',strtotime($this->year."-".$month_key));
            
            $data->hole = .6;
            $data->textposition = "inside";
            $data->hoverinfo = 'label+percent';
            $data->automargin = true;
            $data->insidetextorientation = "radial";

            $records[] = $data;     
            $column++;

        }
        
        $title = "Annual Expense for ".$this->year;

        return view('dashboard',[
            "expenses" => json_encode($records),
            "title" => $title,
        ]);
    }

    public function updateYear($year)
    {
        $this->year = $year;
    }
}
