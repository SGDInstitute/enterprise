<table class="table">
    <tr>
        <td>Wants Program</td>
        <td>{{ isset($data[1]) ? $data[1] : 0 }}</td>
    </tr>
    <tr>
        <td>Does not Want Program</td>
        <td>{{ isset($data[0]) ? $data[0] : 0 }}</td>
    </tr>
</table>