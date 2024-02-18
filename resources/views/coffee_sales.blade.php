<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <form action="{{route('coffee.add_sale')}}" id="record_sale" method="post">
                @csrf
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="product" class="block mb-1">Product</label>
                        <select id="product_id" name="product_id" class="form-select w-full" onchange="getSellingPrice()">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="quantity" class="block mb-1">Quantity</label>
                        <input type="number" id="qty" name="qty" class="form-input w-full" value="1"  onchange="getSellingPrice()"/>
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="unit_cost" class="block mb-1">Unit Cost (£)</label>
                        <input type="number" id="unit_cost" name="unit_cost" class="form-input w-full" placeholder="Unit Cost" step="0.01" min="0" value="0.0" onchange="getSellingPrice()" />
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="selling_price" class="block mb-1">Selling Price</label>
                        <input for="selling_price" type="text" id="selling_price" disabled class="form-input w-full" style="border: none;" value="£ 0.0" />
                        <input type="hidden" name="selling_price" id="selling_price_value">
                        <input type="hidden" name="profit_margin" id="profit_margin">
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="submit" class="block mb-1">&nbsp;</label>
                        <x-button type="button" class="ml-3 btn-blue" onclick="recordSale()">
                            Record Sale
                        </x-button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Previous ☕️ Sales') }}
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-auto border-collapse w-full">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2 bg-gray-200">Product</th>
                                <th class="border px-4 py-2 bg-gray-200">Quantity</th>
                                <th class="border px-4 py-2 bg-gray-200">Unit Cost</th>
                                <th class="border px-4 py-2 bg-gray-200">Selling Price</th>
                                <th class="border px-4 py-2 bg-gray-200">Sold At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($sales) > 0)
                            @foreach($sales as $sale)
                            <tr>
                                <td class="border px-4 py-2">{{ $sale->product->name }}</td>
                                <td class="border px-4 py-2">{{ $sale->qty }}</td>
                                <td class="border px-4 py-2">£ {{ number_format($sale->unit_cost, 2) }}</td>
                                <td class="border px-4 py-2">£ {{ number_format($sale->selling_price, 2) }}</td>
                                <td class="border px-4 py-2">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="3" class="border px-4 py-2">No Data Found.</td>
                            </tr>
                            @endif
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@push('footer-scripts')
<script>
    function getSellingPrice(){
        let qty = document.getElementById('qty').value;
        let unitCost = document.getElementById('unit_cost').value;
        let product_id = document.getElementById('product_id').value;
        let shippingCost = 10;

        if(qty && unitCost && qty >=1 && unitCost > 0 && product_id){
            $.ajax({
                    url: "{{route('coffee.get_product')}}",
                    type: "POST",
                    data: {
                        id: product_id,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(data){
                        if(data.success){
                            let sellingCost = (((qty * unitCost) / (1 - (data.data.profit_margin / 100))) + shippingCost);
                            document.getElementById('profit_margin').value = data.data.profit_margin;
                            document.getElementById('selling_price').value = '£ ' + parseFloat(sellingCost).toFixed(2);
                            document.getElementById('selling_price_value').value = parseFloat(sellingCost).toFixed(2);
                        }else{
                            alert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr);
                        console.error(status);
                        console.error(error);
                        alert(data.message);
                    }
                });
        }else{
            document.getElementById('profit_margin').value = 0;
            document.getElementById('selling_price').value = '£ ' + parseFloat(0).toFixed(2);
            document.getElementById('selling_price_value').value = parseFloat(0).toFixed(2);
        }
    }

    function recordSale(){
        let qty = document.getElementById('qty').value;
        let unitCost = document.getElementById('unit_cost').value;
        let product_id = document.getElementById('product_id').value;
        let shippingCost = 10;

        if(qty && unitCost && qty >=1 && unitCost > 0 && product_id){
            // Get the form element
            const form = document.getElementById('record_sale');
            
            // Submit the form
            form.submit();
        }else{
            alert('Please Enter Valid Details');
        }
    }
</script>
@endpush
</x-app-layout>


