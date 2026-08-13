<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Request Approved</title>
</head>
<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, Helvetica, sans-serif; color:#222222;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f4f4; padding:30px 15px;">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="max-width:620px; background:#ffffff; border-radius:10px; overflow:hidden;">

                <tr>
                    <td style="background:#5d0606; padding:28px 30px; text-align:center;">
                        <h1 style="margin:0; color:#ffffff; font-size:24px;">
                            PUP Taguig Dental Clinic
                        </h1>

                        <p style="margin:8px 0 0; color:#f3dddd; font-size:14px;">
                            Dental Management System
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:32px 30px;">

                        <h2 style="margin:0 0 18px; font-size:22px; color:#1f2937;">
                            Document Request Approved
                        </h2>

                        <p style="margin:0 0 16px; line-height:1.6;">
                            Hello
                            <strong>{{ $documentRequest->patient?->name ?? 'Patient' }}</strong>,
                        </p>

                        <p style="margin:0 0 22px; line-height:1.6;">
                            Your document request has been approved and is now ready for pickup at the
                            PUP Taguig Dental Clinic.
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="border-collapse:collapse; background:#f9fafb; border-radius:8px;">

                            <tr>
                                <td style="padding:12px 16px; border-bottom:1px solid #e5e7eb; width:42%;">
                                    <strong>Reference Number</strong>
                                </td>
                                <td style="padding:12px 16px; border-bottom:1px solid #e5e7eb;">
                                    {{ $documentRequest->reference_number ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 16px; border-bottom:1px solid #e5e7eb;">
                                    <strong>Document Type</strong>
                                </td>
                                <td style="padding:12px 16px; border-bottom:1px solid #e5e7eb;">
                                    {{ $documentRequest->document_type ?? 'Document' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 16px; border-bottom:1px solid #e5e7eb;">
                                    <strong>Purpose</strong>
                                </td>
                                <td style="padding:12px 16px; border-bottom:1px solid #e5e7eb;">
                                    {{ $documentRequest->purpose ?: 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 16px;">
                                    <strong>Status</strong>
                                </td>
                                <td style="padding:12px 16px;">
                                    <strong style="color:#166534;">Approved</strong>
                                </td>
                            </tr>

                        </table>

                        <p style="margin:22px 0 0; line-height:1.6; color:#4b5563;">
                            Please present the necessary identification or supporting information when claiming your document.
                        </p>

                        <p style="margin:24px 0 0; line-height:1.6;">
                            Thank you,<br>
                            <strong>PUP Taguig Dental Clinic</strong>
                        </p>

                    </td>
                </tr>

                <tr>
                    <td style="padding:18px 30px; background:#f9fafb; text-align:center; color:#6b7280; font-size:12px;">
                        This is an automated email. Please do not reply to this message.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>