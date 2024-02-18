<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <form action="{{route('coffee.add_sale')}}" method="post">
                @csrf
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="quantity" class="block mb-1">Quantity</label>
                        <input type="number" id="qty" name="qty" class="form-input w-full" value="1" />
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="unit_cost" class="block mb-1">Unit Cost (£)</label>
                        <input type="number" id="unit_cost" name="unit_cost" class="form-input w-full" placeholder="Unit Cost" step="0.01" min="0" value="0.0" onchange="getSellingPrice()" />
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="selling_price" class="block mb-1">Selling Price</label>
                        <input for="selling_price" type="text" id="selling_price" disabled class="form-input w-full" style="border: none;" value="£ 0.0" />
                        <input type="hidden" name="selling_price" id="selling_price_value">
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="submit" class="block mb-1">&nbsp;</label>
                        <x-button class="ml-3 btn-blue">
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
                                <th class="border px-4 py-2 bg-gray-200">Quantity</th>
                                <th class="border px-4 py-2 bg-gray-200">Unit Cost</th>
                                <th class="border px-4 py-2 bg-gray-200">Selling Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($sales) > 0)
                            @foreach($sales as $sale)
                            <tr>
                                <td class="border px-4 py-2">{{ $sale->qty }}</td>
                                <td class="border px-4 py-2">£ {{ number_format($sale->unit_cost, 2) }}</td>
                                <td class="border px-4 py-2">£ {{ number_format($sale->selling_price, 2) }}</td>
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
        let profitMargin = 25;
        let shippingCost = 10;
        console.log(qty);
        if(qty && unitCost && qty >=1 && unitCost > 0){
            let sellingCost = (((qty * unitCost) / (1 - (profitMargin / 100))) + shippingCost)
            document.getElementById('selling_price').value = '£ ' + parseFloat(sellingCost).toFixed(2);
            document.getElementById('selling_price_value').value = parseFloat(sellingCost).toFixed(2);
        }else{
            alert('Please Enter Appropriate Values.')
        }
    }
</script>
@endpush
</x-app-layout>


