<datalist id="currencies">
    @foreach ($currencies as $currency)
        <option value="{{ $currency->currency_code }}">{{ $currency->country }}</option>
    @endforeach
</datalist>