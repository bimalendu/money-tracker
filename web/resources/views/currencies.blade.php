<datalist id="currencies">
    @foreach ($currencies as $currency)
        <option value="{{ $currency->currency_code }}">{{ $currency->currency }}</option>
    @endforeach
</datalist>