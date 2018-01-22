<table class="table">
    <thead>
        <tr>
            <th>S</th>
            <th>M</th>
            <th>L</th>
            <th>XL</th>
            <th>XXL</th>
            <th>XXXL</th>
            <th>XXXXL</th>
            <th>Not Filled</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $data->where('tshirt', 'S')->count() }}</td>
            <td>{{ $data->where('tshirt', 'M')->count() }}</td>
            <td>{{ $data->where('tshirt', 'L')->count() }}</td>
            <td>{{ $data->where('tshirt', 'XL')->count() }}</td>
            <td>{{ $data->where('tshirt', 'XXL')->count() }}</td>
            <td>{{ $data->where('tshirt', 'XXXL')->count() }}</td>
            <td>{{ $data->where('tshirt', 'XXXXL')->count() }}</td>
            <td>{{ $data->where('tshirt', null)->count() }}</td>
        </tr>
    </tbody>
</table>