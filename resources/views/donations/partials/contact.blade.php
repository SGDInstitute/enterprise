<table class="table">
    <tbody>
    <tr>
        <td class="w-48">Name</td>
        <td>{{ $donation->name }}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{ $donation->email }}</td>
    </tr>
    @if($donation->company)
        <tr>
            <td>Company Name</td>
            <td>{{ $donation->company }}</td>
        </tr>
        <tr>
            <td>Tax ID</td>
            <td>{{ $donation->tax_id }}</td>
        </tr>
    @endif
    </tbody>
</table>