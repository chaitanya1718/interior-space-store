<h1>Satya Interiors Invoice</h1>
<p><strong>Order:</strong> {{ $order->getKey() }}</p>
<p><strong>Customer:</strong> {{ $order->customer['name'] ?? '' }}</p>
<p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

<table width="100%" cellpadding="8" cellspacing="0" border="1">
    <thead>
        <tr>
            <th align="left">Item</th>
            <th align="right">Qty</th>
            <th align="right">Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item['name'] ?? 'Product' }}</td>
                <td align="right">{{ $item['quantity'] ?? 1 }}</td>
                <td align="right">{{ \App\Support\Money::inr($item['line_total'] ?? 0) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Total:</strong> {{ \App\Support\Money::inr($order->subtotal) }}</p>
<p><strong>Payment:</strong> {{ $order->payment['method'] ?? 'Cash on Delivery' }} - {{ $order->payment['status'] ?? 'pending' }}</p>
<p>Thank you for shopping with Satya Interiors.</p>
