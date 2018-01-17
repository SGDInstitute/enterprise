@extends('layouts.admin')

@section('content')
    <div class="row">
        <form class="form-inline">
            <div class="form-group">
                <label class="sr-only" for="exampleInputEmail3">Report Type</label>
                <select name="report" id="report" class="form-control">
                    <option value="accessability">Accessability</option>
                    <option value="tshirt">T-shirt</option>
                    <option value="orders">Orders</option>
                </select>
            </div>
            <button type="submit" class="btn btn-default">Run Report</button>
        </form>
    </div>
@endsection