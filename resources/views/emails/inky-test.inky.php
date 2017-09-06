@extends('layouts.inky-email')

@section('content')
<container class="header">
    <row>
        <columns>
            <p class="text-center"><a href="/" class="browser-link">Can&#39;t see this? View in your browser.</a></p>
        </columns>
    </row>
</container>

<container class="logo-row">
    <spacer size="16"></spacer>

    <row>
        <columns large="4">
            <img alt="Midwest Institute for Sexuality and Gender Diversity"
                 src="https://sgdinstitute.org/storage/app/media/emails/logo-dark-text.png"/>
        </columns>
        <columns large="8">

        </columns>
    </row>
</container>

<container>

    <spacer size="16"></spacer>

    <row>
        <columns>
            <h1 class="text-center">The Institute</h1>
            <center>
                <img src="http://placehold.it/500x200">
            </center>

            <spacer size="16"></spacer>

            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa itaque illo doloribus soluta expedita dolores commodi fuga odit.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto reiciendis eos magni deleniti accusamus tempore, consectetur! Maxime amet, exercitationem nihil fugit eius esse voluptatum ab incidunt minima, saepe reiciendis ipsum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto reiciendis eos magni deleniti accusamus tempore, consectetur! Maxime amet, exercitationem nihil fugit eius esse voluptatum ab incidunt minima, saepe reiciendis ipsum.</p>

            <row>
                <columns large="6">
                    <h4>More Reading:</h4>
                    <ul>
                        <li><a href="#">Lorem Ipsum Dolor Sit Amet</a></li>
                        <li><a href="#">Lorem Ipsum Dolor Sit Amet</a></li>
                        <li><a href="#">Lorem Ipsum Dolor Sit Amet</a></li>
                    </ul>
                </columns>
                <columns>
                    <h4>Get Involved:</h4>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                    </ul>
                </columns>
            </row>

            <p><small>You received this email because you're signed up to get updates from us. <a href="#">Click here to unsubscribe.</a></small></p>
        </columns>
    </row>
</container>

<container class="logo-row">
    <spacer size="16"></spacer>

    <row>
        <columns large="4">
            <img alt="Midwest Institute for Sexuality and Gender Diversity"
                 src="https://sgdinstitute.org/storage/app/media/emails/logo-footer.png"/>
        </columns>
        <columns large="8">

        </columns>
    </row>
</container>

<container class="footer">
    <spacer size="16"></spacer>

    <row>
        <columns>
            <p>
                &copy; [currentyear]
                <a href="https://sgdinstitute.org/" target="_blank">Midwest Institute for Sexuality and Gender Diversity</a> |
                PO Box 1053, East Lansing, MI, 48826 |
                <a href="https://sgdinstitute.org/contact" target="_blank">Contact</a> |
                <a href="https://sgdinstitute.org" target="_blank">sgdinstitute.org</a>
            </p>
        </columns>
    </row>
</container>

@endsection