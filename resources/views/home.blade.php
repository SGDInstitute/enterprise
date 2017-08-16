@extends('layouts.app')

@section('hero')
<section class="hero">
  <div class="container">
    <div class="hero-titles">
      <h1>Event Title</h1>
      <h2>Event SubTitle</h2>
    </div>
  </div>
  <div class="hero-bar clearfix">
    <div class="container">
      <div class="pull-left">
        Start at
        <br />
        End at
      </div>
      <div class="pull-right">
        Location
        <br />
        City, State
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
