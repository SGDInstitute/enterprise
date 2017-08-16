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
<section class="description">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <span class="description-title">Event Description</span>
        <ul class="fa-ul">
          <li><i class="fa-li fa fa-clock-o" aria-hidden="true"></i>Event Start At to Event End At</li>
          <li><i class="fa-li fa fa-map-marker" aria-hidden="true"></i>Event Location City, State</li>
        </ul>
        <div class="description-content">
          <p>
            Bacon ipsum dolor amet rump andouille landjaeger ham shoulder. Tenderloin pork loin salami, jowl beef ribs corned beef swine bacon ground round pastrami ham hock cow kielbasa tail kevin. Bacon beef doner picanha, hamburger filet mignon sausage tail short loin pork loin. Kevin ham hock meatloaf biltong turducken brisket. Tail cupim ham hock cow landjaeger chuck sausage sirloin ground round bresaola beef ribs prosciutto meatloaf andouille. Chuck turducken sausage pig, kevin drumstick short ribs bacon rump leberkas ball tip cupim alcatra shank shoulder.
          </p>
          <p>
            Burgdoggen short ribs picanha, brisket beef ribs doner strip steak pork chop chuck ham ham hock. Short loin boudin burgdoggen doner cupim, picanha tri-tip strip steak bresaola chuck. Alcatra bacon tri-tip chicken, cupim pig meatball jowl shoulder salami corned beef. Landjaeger beef ribs chuck, pork chop leberkas bacon hamburger flank shankle beef. Tail swine prosciutto, short loin capicola picanha ham frankfurter doner. Tail t-bone strip steak salami leberkas.
          </p>
        </div>
      </div>
      <div class="col-md-4">
        @include('components.app.tickets')
      </div>
    </div>
  </div>
</section>
@endsection
