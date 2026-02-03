<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Confirmation</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f8;">
    @php
        $rsvpConfig = config('constants.rsvp', []);
        $eventName = config('constants.EVENT_NAME', 'Event');
        $eventYear = config('constants.EVENT_YEAR', date('Y'));
        $rsvpEventDate = $rsvp->ddate ?? ($rsvpConfig['event_date'] ?? null);
        $rsvpEventTime = $rsvp->ttime ?? ($rsvpConfig['event_time'] ?? '');
        $rsvpVenueName = $rsvpConfig['venue_name'] ?? '';
        $rsvpVenueAddress = $rsvpConfig['venue_address'] ?? '';
        $rsvpVenueFull = $rsvp->rsvp_location ?? ($rsvpConfig['venue_full'] ?? '');
        $rsvpNote = $rsvpConfig['note'] ?? '';
        $contactName = $rsvpConfig['contact_name'] ?? "Team {$eventName}";
        $contactAddress = $rsvpConfig['contact_address'] ?? '';
        $contactPhone = $rsvpConfig['contact_phone'] ?? '';
        $contactWebsite = $rsvpConfig['contact_website'] ?? '';
    @endphp

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f6f8; padding: 30px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden;">
                    
                    {{-- Header with Logo --}}
                    @if(config('constants.event_logo'))
                    <tr>
                        <td style="padding: 25px 30px; background-color: #ffffff; text-align: center;">
                            <img src="{{ config('constants.event_logo') }}"
                                 alt="{{ $eventName }} Logo"
                                 style="max-width: 180px; height: auto; display: inline-block;">
                        </td>
                    </tr>
                    @endif

                    {{-- Greeting Section --}}
                    <tr>
                        <td style="padding: 30px 30px 20px; background-color: #ffffff;">
                            <p style="margin: 0 0 15px; font-size: 16px; color: #333333; line-height: 1.6;">
                                Dear {{ $rsvp->name }},
                            </p>
                            <p style="margin: 0 0 15px; font-size: 16px; color: #333333; line-height: 1.6;">
                                Greetings from <strong>{{ $eventName }} {{ $eventYear }}</strong> !!
                            </p>
                            @if($rsvp->event_identity)
                            <p style="margin: 0 0 15px; font-size: 16px; color: #333333; line-height: 1.6;">
                                Thank you for RSVP on <strong style="color: #1e3a5f;">{{ $rsvp->event_identity }}</strong>
                            </p>
                            @else
                            <p style="margin: 0 0 15px; font-size: 16px; color: #333333; line-height: 1.6;">
                                Thank you for your RSVP!
                            </p>
                            @endif
                            <p style="margin: 0; font-size: 16px; color: #333333; line-height: 1.6;">
                                Mentioned below are the details of event for your kind reference
                            </p>
                        </td>
                    </tr>

                    {{-- Event Details Banner --}}
                    <tr>
                        <td style="padding: 0 30px 30px;">
                            {{-- Date & Time Bar --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-radius: 12px 12px 0 0; overflow: hidden;">
                                <tr>
                                    <td style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); padding: 15px 20px; text-align: center;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                            <tr>
                                                <td style="color: #ffffff; font-size: 15px; font-weight: 500; padding-right: 30px;">
                                                    📅 
                                                    @if($rsvpEventDate)
                                                        @if(is_string($rsvpEventDate))
                                                            {{ \Carbon\Carbon::parse($rsvpEventDate)->format('l, F jS, Y') }}
                                                        @else
                                                            {{ $rsvpEventDate->format('l, F jS, Y') }}
                                                        @endif
                                                    @else
                                                        Event Date TBA
                                                    @endif
                                                </td>
                                                <td style="color: #ffffff; font-size: 15px; font-weight: 500;">
                                                    🕐 {{ $rsvpEventTime ?: 'Time TBA' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- Venue Section --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);">
                                <tr>
                                    <td style="padding: 20px;">
                                        {{-- Venue --}}
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 15px;">
                                            <tr>
                                                <td width="30" valign="top" style="padding-top: 2px;">
                                                    <span style="color: #ef4444; font-size: 18px;">📍</span>
                                                </td>
                                                <td style="color: #ffffff; font-size: 14px; line-height: 1.6;">
                                                    @if($rsvpVenueName)
                                                        <strong style="font-size: 15px;">{{ $rsvpVenueName }}</strong><br>
                                                    @endif
                                                    {{ $rsvpVenueAddress ?: $rsvpVenueFull }}
                                                </td>
                                            </tr>
                                        </table>

                                        {{-- Note --}}
                                        @if($rsvpNote)
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="30" valign="top" style="padding-top: 2px;">
                                                    <span style="color: #60a5fa; font-size: 16px;">ℹ️</span>
                                                </td>
                                                <td>
                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: rgba(255,255,255,0.1); border-radius: 6px;">
                                                        <tr>
                                                            <td style="padding: 10px 15px; color: #ffffff; font-size: 14px;">
                                                                {{ $rsvpNote }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            {{-- Footer Signature --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #1a2e4a; border-radius: 0 0 12px 12px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 5px; color: #fbbf24; font-size: 15px; font-weight: 600;">
                                            Thank You,
                                        </p>
                                        <p style="margin: 0 0 15px; color: #ffffff; font-size: 14px;">
                                            {{ $contactName }}, Event Secretariat
                                        </p>
                                        <p style="margin: 0; color: #94a3b8; font-size: 13px; line-height: 1.7;">
                                            {!! nl2br(e($contactAddress)) !!}<br>
                                            Tel: {{ $contactPhone }}<br>
                                            Website: {{ $contactWebsite }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Looking Forward Message --}}
                    <tr>
                        <td style="padding: 0 30px 30px;">
                            <p style="margin: 0; font-size: 16px; color: #333333; line-height: 1.6;">
                                Looking forward to meet you.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 20px 30px; background-color: #f8f9fa; border-top: 1px solid #e5e7eb; text-align: center; font-size: 12px; color: #666666;">
                            <p style="margin: 0;">This is an automated email. Please do not reply to this message.</p>
                            <p style="margin: 10px 0 0; color: #999999;">
                                © {{ date('Y') }} {{ $eventName }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
