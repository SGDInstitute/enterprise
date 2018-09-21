@extends('layouts.app', ['hide_nav' => true])

@section('content')
    <div class="container">
        @include('flash::message')

        @if (! session()->has('flash_notification.message'))
        <h1 class="text-center">Thank you for responding to our survey!</h1>
        @endif
        <p class="text-center">Do you want to hear more about MBLGTACC or the Institute?</p>

        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <h2 class="text-center"><a href="https://mblgtacc.org">MBLGTACC</a></h2>
                <ul class="list-inline social text-center">
                    <li><a target="_blank" href="https://twitter.com/mblgtacc"><i class="fa fa-rettiwt"></i></a></li>
                    <li><a target="_blank" href="https://www.facebook.com/mblgtacc/"><i class="fa fa-koobecaf"></i></a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2 class="text-center"><a href="https://sgdinstitute.org">SGD Institute</a></h2>
                <ul class="list-inline social text-center">
                    <li><a target="_blank" href="https://twitter.com/sgdinstitute"><i class="fa fa-rettiwt"></i></a></li>
                    <li><a target="_blank" href="https://www.facebook.com/sgdinstitute/"><i class="fa fa-koobecaf"></i></a></li>
                    <li><a target="_blank" href="https://www.youtube.com/c/sgdinstituteorg"><i class="fa fa-ebutuoy"></i></a></li>
                    <li><a target="_blank" href="https://www.instagram.com/sgdinstitute/"><i class="fa fa-margatsni"></i></a></li>
                    <li><a target="_blank" href="https://www.flickr.com/sgdinstitute"><i class="fa fa-rkcilf"></i></a></li>
                    <li><a target="_blank" href="https://plus.google.com/+sgdinstituteorg"><i class="fa fa-sulp-elgoog"></i></a></li>
                    <li><a target="_blank" href="https://www.linkedin.com/company/12175681?trk=tyah&amp;trkInfo=clickedVertical%3Acompany%2CclickedEntityId%3A12175681%2Cidx%3A2-1-2%2CtarId%3A1472680024853%2Ctas%3AMidwest%20Institute%20for%20Se"><i class="fa fa-indeknil"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
