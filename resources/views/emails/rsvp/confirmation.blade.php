<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Confirmation - Prawaas 5.0 Curtain Raiser</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f6f8;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f6f8; padding: 20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    {{-- Logo Header --}}
                    <tr>
                        <td style="padding: 25px 30px; background-color: #ffffff; border-radius: 8px 8px 0 0; text-align: center;">
                            <img src="https://prawaas.com/img/logo-5a.png"
                                 alt="Prawaas Logo"
                                 style="max-width: 220px; height: auto; display: inline-block;">
                        </td>
                    </tr>
                  
                    {{-- Main Content --}}
                    <tr>
                        <td style="padding: 30px;">
                            {{-- Greeting --}}
                            <p style="margin: 0 0 20px; font-size: 16px; color: #333333; line-height: 1.6;">
                                Dear {{ $rsvp->name }},
                            </p>
                            
                            {{-- Thank You Message --}}
                            <p style="margin: 0 0 25px; font-size: 16px; color: #333333; line-height: 1.6;">
                                Thank you for submitting your RSVP for the <strong>Prawaas 5.0 Curtain Raiser</strong>.
                            </p>
                            
                            {{-- Your RSVP Details Section --}}
                            <div style="background-color: #f8f9fa; border-left: 4px solid #1e3a5f; padding: 20px; margin: 0 0 25px; border-radius: 4px;">
                                <h2 style="margin: 0 0 15px; font-size: 18px; color: #1e3a5f; font-weight: bold;">Your RSVP Details</h2>
                                <table role="presentation" width="100%" cellpadding="5" cellspacing="0">
                                    <tr><td style="width: 40%; font-weight: bold; color: #555555;">Name:</td><td style="color: #333333;">{{ $rsvp->name }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Organisation:</td><td style="color: #333333;">{{ $rsvp->org ?? '—' }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Designation:</td><td style="color: #333333;">{{ $rsvp->desig ?? '—' }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Email:</td><td style="color: #333333;">{{ $rsvp->email }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Contact:</td><td style="color: #333333;">{{ $rsvp->full_phone ?: '—' }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">City:</td><td style="color: #333333;">{{ $rsvp->city ?? '—' }}</td></tr>
                                    <tr><td style="font-weight: bold; color: #555555;">Country:</td><td style="color: #333333;">{{ $rsvp->country ?? '—' }}</td></tr>
                                    @if($rsvp->association_name)
                                    <tr><td style="font-weight: bold; color: #555555;">Association:</td><td style="color: #333333;">{{ $rsvp->association_name }}</td></tr>
                                    @endif
                                    @if($rsvp->registration_type)
                                    <tr><td style="font-weight: bold; color: #555555;">Registration Type:</td><td style="color: #333333;">{{ $rsvp->registration_type }}@if($rsvp->registration_type === 'Other' && $rsvp->registration_type_other) ({{ $rsvp->registration_type_other }})@endif</td></tr>
                                    @endif
                                </table>
                            </div>
                            
                            {{-- Curtain Raiser Details Section --}}
                            <div style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); padding: 25px; margin: 0 0 25px; border-radius: 8px; color: #ffffff;">
                                <h2 style="margin: 0 0 20px; font-size: 18px; color: #ffd700; font-weight: bold;">Curtain Raiser Details:</h2>
                                
                                <p style="margin: 0 0 15px; font-size: 15px; line-height: 1.6;">
                                    <strong style="color: #ffd700;">Date & Time:</strong><br>
                                    Monday, 16 February 2026 | 6:00 PM onwards
                                </p>
                                
                                <p style="margin: 0 0 15px; font-size: 15px; line-height: 1.6;">
                                    <strong style="color: #ffd700;">Venue:</strong><br>
                                    Inspiration Hall, Crowne Plaza Ahmedabad City Centre<br>
                                    S.G. Highway, Near Shapath-V, Ahmedabad – 380015
                                </p>
                                
                                <p style="margin: 0; font-size: 15px; line-height: 1.6;">
                                    <strong style="color: #ffd700;">Note:</strong> The function will be followed by high tea.
                                </p>
                            </div>
                            
                            {{-- Contact Information Section --}}
                            <div style="margin: 0 0 25px;">
                                <p style="margin: 0 0 15px; font-size: 16px; color: #333333; font-weight: bold;">
                                    For more information, please get in touch with:
                                </p>
                                
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td width="50%" style="vertical-align: top; padding-right: 10px;">
                                            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; border-left: 3px solid #1e3a5f;">
                                                <p style="margin: 0 0 5px; font-size: 14px; color: #1e3a5f; font-weight: bold;">For Industry</p>
                                                <p style="margin: 0; font-size: 14px; color: #333333; line-height: 1.6;">
                                                    Ms. Sneha Singh<br>
                                                    Mobile: +91 - 76762 68577<br>
                                                    Email: <a href="mailto:sneha.singh@mmactiv.com" style="color: #1e3a5f;">sneha.singh@mmactiv.com</a>
                                                </p>
                                            </div>
                                        </td>
                                        <td width="50%" style="vertical-align: top; padding-left: 10px;">
                                            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; border-left: 3px solid #1e3a5f;">
                                                <p style="margin: 0 0 5px; font-size: 14px; color: #1e3a5f; font-weight: bold;">For Operators</p>
                                                <p style="margin: 0; font-size: 14px; color: #333333; line-height: 1.6;">
                                                    Mr. Siddiq Gandhi<br>
                                                    Mobile: +91 99790 19191
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            {{-- Footer Signature --}}
                            <p style="margin: 0; font-size: 16px; color: #333333; line-height: 1.6;">
                                Thank you,<br>
                                <strong>Team Prawaas 5.0</strong>
                            </p>
                        </td>
                    </tr>
                    
                    {{-- Footer --}}
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
