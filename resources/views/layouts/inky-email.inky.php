<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <!-- <style> -->

    <style>
        body,
        html,
        .body {
            background: #BBBEC0 !important;
        }

        .container.header {
            background: #BBBEC0;
        }

        .body-drip {
            border-top: 8px solid #663399;
        }

        .header {
            background: #8a8a8a;
        }

        .header .columns {
            padding-bottom: 0;
        }

        .header p {
            color: #fff;
            padding-top: 15px;
        }

        .header .wrapper-inner {
            padding: 20px;
        }

        .header .container {
            background: transparent;
        }

        table.button.facebook table td {
            background: #3B5998 !important;
            border-color: #3B5998;
        }

        table.button.twitter table td {
            background: #1daced !important;
            border-color: #1daced;
        }

        table.button.google table td {
            background: #DB4A39 !important;
            border-color: #DB4A39;
        }

        .wrapper.secondary {
            background: #f3f3f3;
        }

        .text-center {
            text-align: center;
        }

        .header a {
            color: #ffffff;
        }

        .header .browser-link {
            font-size: 12px;
        }

        .logo-row {
            background: #e7ebed !important;
        }

        .footer {
            background: #546163 !important;
            color: #ffffff;
        }

        .footer a {
            color: #ffffff;
        }

        .footer p {
            color: #ffffff;
            font-size: 10px;
        }
    </style>
</head>
<body>
<table class="body">
    <tr>
        <td class="center" align="center" valign="top">
            <center>
                @yield('content')
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

