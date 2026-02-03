<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Confirmation</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f6f8;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f6f8; padding: 20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="padding: 25px 30px; background-color: #ffffff; border-radius: 8px 8px 0 0; text-align: center;">
                            <img src="https://prawaas.com/img/logo-5a.png"
                                 alt="Prawaas Logo"
                                 style="max-width: 220px; height: auto; display: inline-block;">
                        </td>
                    </tr>
                  
                    <tr>
                        <td style="padding: 30px;">
                            <p style="margin: 0 0 20px; font-size: 16px; color: #333333; line-height: 1.6;">
                                Dear {{ $rsvp->name }},
                            </p>
                            <p style="margin: 0 0 20px; font-size: 16px; color: #333333; line-height: 1.6;">
                                Thank you for confirming your attendance for <strong>{{ config('constants.EVENT_NAME', 'Event') }} {{ config('constants.EVENT_YEAR', date('Y')) }}</strong>.
                            </p>
                            <p style="margin: 0 0 20px; font-size: 16px; color: #333333; line-height: 1.6;">
                                We look forward to seeing you at the event.
                            </p>
                            <div style="background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 20px; margin: 25px 0; border-radius: 4px;">
                                <h2 style="margin: 0 0 15px; font-size: 18px; color: #667eea; font-weight: bold;">Your RSVP Details</h2>
                                <table role="presentation" width="100%" cellpadding="5" cellspacing="0">
                                    <tr><td style="width: 40%; font-weight: bold; color: #555555;">Name:</td><td>{{ $rsvp->name }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Organisation:</td><td>{{ $rsvp->org ?? '—' }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Designation:</td><td>{{ $rsvp->desig ?? '—' }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Email:</td><td>{{ $rsvp->email }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Contact:</td><td>{{ $rsvp->full_phone ?: '—' }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">City:</td><td>{{ $rsvp->city ?? '—' }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Country:</td><td>{{ $rsvp->country ?? '—' }}</td></tr>
                                    @if($rsvp->event_identity)
                                    <tr><td style="font-weight: bold; color: #555555;">Event:</td><td>{{ $rsvp->event_identity }}</td></tr>
                                    @endif
                                    @if($rsvp->rsvp_location)
                                    <tr><td style="font-weight: bold; color: #555555;">Location:</td><td>{{ $rsvp->rsvp_location }}</td></tr>
                                    @endif
                                    @if($rsvp->ddate)
                                    <tr><td style="font-weight: bold; color: #555555;">Date & Time:</td><td>{{ $rsvp->formatted_date_time }}</td></tr>
                                    @endif
                                    @if($rsvp->association_name)
                                    <tr><td style="font-weight: bold; color: #555555;">Association:</td><td>{{ $rsvp->association_name }}</td></tr>
                                    @endif
                                </table>
                            </div>
                            <p style="margin: 20px 0 0; font-size: 16px; color: #333333; line-height: 1.6;">
                                Best regards,<br>
                                <strong>{{ config('constants.EVENT_NAME', 'Event') }} Team</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px; background-color: #f8f9fa; border-radius: 0 0 8px 8px; text-align: center; font-size: 12px; color: #666666;">
                            <p style="margin: 0;">This is an automated email. Please do not reply to this message.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
