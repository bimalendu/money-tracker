<div>
<x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
         {{ __('Overview ') }} 
        </h2> 
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <p class="mt-5">
                          <label for="selYear">Year: </label>
                          <input type="number" id="selYear" wire:model="year" list="year" max="{{ date('Y') }}" min="1900" />
                          <datalist id="year">
                                @php
                                  for($i=1950;$i<=date('Y');$i++){
                                    echo '<option value="'.$i.'">';
                                  }
                                @endphp
                          </datalist>
                        </p>
                        
                        <div id="myDiv"></div>                      
                </div>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.plot.ly/plotly-2.6.3.min.js'></script>
<script>

var data = {!! $expenses !!};

var layout = {
  title: "{{ $title }}",
  margin: {"t": 30, "b": 30, "l": 0, "r": 0},
  showlegend: false,
  grid: {rows: 1, columns: 2}
};


Plotly.newPlot('myDiv', data, layout);

document.addEventListener("DOMContentLoaded", () => {

        Livewire.hook('element.updated', (el, component) => {
            layout.title = component.serverMemo.data.graphTitle;
            let graphData = JSON.parse(component.serverMemo.data.graphData);

            if(graphData.length > 0){
                Plotly.newPlot('myDiv', graphData, layout);
            }else{
              document.getElementById('myDiv').innerHTML = `<p class="mt-5">
              Sorry, no data is available for this year.
              </p>`;
            }
            
        });

});
</script>
</div>