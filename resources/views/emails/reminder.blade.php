<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reminder: Complete Your Onboarding</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; background-color: #ffffff;">
    <!-- Header with emailer banner - flush, no gap -->
    <tr>
        <td style="padding: 0; line-height: 0;">
            <img src="{{ config('constants.EMAILER_HEADER_LOGO') }}" alt="{{ config('constants.EVENT_NAME') }} {{ config('constants.EVENT_YEAR') }}" style="max-width: 100%; width: 100%; height: auto; display: block; border: 0; vertical-align: bottom;">
        </td>
    </tr>
    <!-- Body content -->
    <tr>
        <td style="padding: 20px; color: #333333; font-size: 16px; line-height: 1.5;">
            <h2 style="margin-top: 0; color: #333333;">Reminder: Complete Your Onboarding Form</h2>
            <p>Dear {{$data['name']}},</p>
            <p>
                We noticed that your application is still in progress. Please complete the onboarding form and submit your application for exhibition at
                <strong>{{$data['event_name']}}  {{$data['event_year']}}</strong> at your earliest convenience.
            </p>
            <p>
                If you have any questions or need further assistance, please do not hesitate to contact our support team.
            </p>
            <p>Thank you for your prompt attention to this matter.</p>
            <p>Best regards,</p>
            <p>{{$data['event_name']}}  {{$data['event_year']}} </p>
        </td>
    </tr>
    <!-- Footer with event name -->
</table>
</body>
</html>
