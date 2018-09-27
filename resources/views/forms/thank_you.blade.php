@extends('layouts.app', ['hide_nav' => true])

@section('content')
    <div class="container">
        @include('flash::message')

        @if (! session()->has('flash_notification.message'))
        <h1 class="text-center">Thank you for responding to our form!</h1>
        @endif
        <p class="text-center">Do you want to hear more about MBLGTACC or the Institute?</p>

        <div class="row mx-auto mt-16">
            <div class="col-sm">
                <h2 class="text-center text-grey-darker">MBLGTACC</h2>
                <ul class="list-inline text-center">
                    <li class="list-inline-item"><a target="_blank" href="https://twitter.com/mblgtacc"><i class="fab fa-2x fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://www.facebook.com/mblgtacc/"><i class="fab fa-2x fa-facebook"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://www.instagram.com/mblgtacc/"><i class="fab fa-2x fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://mblgtacc.org"><i class="fas fa-2x fa-browser"></i></a></li>
                </ul>
            </div>
            <div class="col-sm">
                <h2 class="text-center text-grey-darker">SGD Institute</h2>
                <ul class="list-inline text-center">
                    <li class="list-inline-item"><a target="_blank" href="https://twitter.com/sgdinstitute"><i class="fab fa-2x fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://www.facebook.com/sgdinstitute/"><i class="fab fa-2x fa-facebook"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://www.youtube.com/c/sgdinstituteorg"><i class="fab fa-2x fa-youtube"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://www.instagram.com/sgdinstitute/"><i class="fab fa-2x fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://www.flickr.com/sgdinstitute"><i class="fab fa-2x fa-flickr"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://plus.google.com/+sgdinstituteorg"><i class="fab fa-2x fa-google-plus"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://www.linkedin.com/company/12175681?trk=tyah&amp;trkInfo=clickedVertical%3Acompany%2CclickedEntityId%3A12175681%2Cidx%3A2-1-2%2CtarId%3A1472680024853%2Ctas%3AMidwest%20Institute%20for%20Se"><i class="fab fa-2x fa-linkedin"></i></a></li>
                    <li class="list-inline-item"><a target="_blank" href="https://sgdinstitute.org"><i class="fas fa-2x fa-browser"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
