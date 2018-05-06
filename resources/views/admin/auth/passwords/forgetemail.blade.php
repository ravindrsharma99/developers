<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thirdeye</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body style="color: #000000; font-size: 16px; font-weight: 400; font-family: PingFangHK, sans-serif; margin: 0;">

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td height="20"></td>
    </tr>
    <tr>
        <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="700px" style="border:thin;border-color:#1aadaa; border-style:solid;">
                <tr>
                    <td><center>
                            <h1><b>Thirdeye</b></h1>
                        </center>
                        <hr style="border: 0; width: 40%; color: #183D6B; background-color: #1aadaa;	height: 2px;">
                        <div style="padding:10px 0px 10px 20px">
                            <p>Dear <b>{{$name}} </b>, You have requested to reset your password. Please use the  following password to log in. After log in, please go to Profile page to change your password.</p>
                        </div>
                        <div style="padding:10px 10px 10px 20px; background-color:#1aadaa; color:#ffffff; font-size:16px; font-family: PingFangHK-SemiBold, sans-serif;"> Details </div>
                        <div style="padding:10px 10px 10px 20px;">
                            <table>
                                <tr>
                                    <td style="width:50%">Name:</td>
                                    <td>{{$name}}</td>
                                </tr>
                                <tr>
                                    <td style="width:50%">Email:</td>
                                    <td>{{$email}}</td>
                                </tr>
                                <tr>
                                    <td>Password:</td>
                                    <td>{{$pass}}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table></td>
    </tr>
</table>

</body>
</html>
