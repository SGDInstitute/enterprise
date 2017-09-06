<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="email.css">
    <!-- <style> -->

</head>
<body>
<table class="body">
    <tr>
        <td class="center" align="center" valign="top">
            <center>
                <container class="header">
                    <row>
                        <columns>
                            <p class="text-center"><a href="/" class="browser-link">Can&#39;t see this? View in your
                                    browser.</a></p>
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
                            @yield('content')
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
                                <a href="https://sgdinstitute.org/" target="_blank">Midwest Institute for Sexuality and
                                    Gender Diversity</a> |
                                PO Box 1053, East Lansing, MI, 48826 |
                                <a href="https://sgdinstitute.org/contact" target="_blank">Contact</a> |
                                <a href="https://sgdinstitute.org" target="_blank">sgdinstitute.org</a>
                            </p>
                        </columns>
                    </row>
                </container>
            </center>
        </td>
    </tr>
</table>
<!-- prevent Gmail on iOS font size manipulation -->
<div style="display:none; white-space:nowrap; font:15px courier; line-height:0;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
</div>
</body>
</html>

