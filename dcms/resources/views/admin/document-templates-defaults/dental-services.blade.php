<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Services - Dental Treatment Record</title>
    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: A4 landscape;
            margin: 0.28in 0.28in;
        }

        body {
            margin: 0;
            background: #f1f1f1;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }

        .preview-stage {
            padding: 16px 0 24px;
        }

        .page {
            width: 11.69in;
            min-height: 8.27in;
            margin: 0 auto;
            padding: 0.14in 0.12in 0.12in;
            background: #fff;
        }

        @media screen {
            .page {
                border: 1px solid #d1d5db;
                box-shadow: 0 8px 28px rgba(15, 23, 42, 0.12);
            }
        }

        .header {
            display: grid;
            grid-template-columns: 90px 1fr 200px;
            align-items: start;
            gap: 8px;
            margin-bottom: 12px;
        }

        .logo-box,
        .right-logo-box {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 66px;
        }

        .logo-box img,
        .right-logo-box img {
            max-width: 70px;
            max-height: 70px;
            object-fit: contain;
            display: block;
        }

        .logo-fallback {
            width: 66px;
            height: 66px;
            border: 1px dashed #888;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 9px;
            color: #666;
            padding: 4px;
        }

        .header-center {
            text-align: center;
            line-height: 1.15;
            padding-top: 2px;
        }

        .header-center .line1 {
            font-size: 12px;
            font-weight: 700;
        }

        .header-center .line2 {
            font-size: 18px;
            font-weight: 400;
            text-transform: uppercase;
            margin-top: 2px;
            letter-spacing: 0.1px;
        }

        .header-center .line3 {
            font-size: 12px;
            font-weight: 700;
            margin-top: 4px;
        }

        .right-panel {
            display: grid;
            grid-template-columns: 58px 130px;
            align-items: end;
            justify-items: end;
            column-gap: 8px;
            padding-top: 4px;
        }

        .code-box {
            border: 1px solid #000;
            min-height: 38px;
            width: 130px;
            padding: 4px 6px;
            font-size: 9px;
            line-height: 1.2;
            font-weight: 700;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel .right-logo-box {
            min-height: 58px;
            align-items: flex-end;
            justify-content: flex-end;
        }

        .right-panel .right-logo-box img {
            max-width: 58px;
            max-height: 58px;
        }

        table.record-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 10px;
        }

        table.record-table th,
        table.record-table td {
            border: 1px solid #000;
            padding: 2px 3px;
            vertical-align: middle;
        }

        table.record-table th {
            text-align: center;
            font-weight: 800;
            line-height: 1.15;
            white-space: normal;
        }

        table.record-table thead tr:first-child th {
            height: 34px;
            vertical-align: middle;
        }

        table.record-table thead tr:nth-child(2) th {
            height: 30px;
            font-size: 9px;
            line-height: 1.05;
            padding: 1px 2px;
            vertical-align: middle;
        }

        table.record-table td {
            height: 30px;
            font-weight: 700;
        }

        .row-num { width: 40px; text-align: center; }
        .col-date { width: 86px; text-align: center; }
        .col-time { width: 48px; text-align: center; }
        .col-name { width: 188px; }
        .col-course { width: 84px; }
        .col-age { width: 38px; text-align: center; }
        .col-gad-small { width: 42px; text-align: center; }
        .col-email { width: 100px; }
        .col-contact { width: 84px; }
        .col-time-processed { width: 58px; text-align: center; }
        .col-processing-time { width: 58px; text-align: center; }
        .col-emergency { width: 58px; text-align: center; }
        .col-signature { width: 96px; text-align: center; }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .tight {
            font-size: 9px;
            line-height: 1.1;
        }

        .gad-head {
            font-size: 11px;
            letter-spacing: 0.1em;
        }

        .signature-cell img {
            max-width: 110px;
            max-height: 24px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .sig-fallback-small {
            width: 100px;
            height: 22px;
            border: 1px dashed #888;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #666;
        }

        .page,
        .page * {
            font-weight: 400 !important;
        }

        @media print {
            body {
                background: #fff;
            }

            .preview-stage {
                padding: 0;
            }

            .page {
                margin: 0;
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="preview-stage">
    <div class="page">

        <div class="header">
            <div class="logo-box">
                <img src="{{pup_logo}}" alt="PUP Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="logo-fallback" style="display:none;">PUP Logo</div>
            </div>

            <div class="header-center">
                <div class="line1">Polytechnic University of the Philippines</div>
                <div class="line2">DENTAL SERVICES</div>
                <div class="line3">Dental Treatment Record</div>
            </div>

            <div class="right-panel">
                <div class="right-logo-box">
                    <img src="{{bagong_pilipinas_logo}}" alt="Bagong Pilipinas Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="logo-fallback" style="display:none;">Bagong Pilipinas Logo</div>
                </div>

                <div class="code-box">
                    <div>{{form_code}}</div>
                    <div>Rev. {{revision_no}}</div>
                    <div>{{revision_date}}</div>
                </div>
            </div>
        </div>

        <table class="record-table">
            <thead>
                <tr>
                    <th class="row-num"></th>
                    <th class="col-date">DATE</th>
                    <th class="col-time">TIME<br>IN</th>
                    <th class="col-name">NAME OF PATIENT<br><span class="tight">(Surname, First Name, Middle Initial)</span></th>
                    <th class="col-course">COURSE / YR AND SECTION / DEPARTMENT</th>
                    <th class="col-age">AGE</th>
                    <th colspan="4" class="gad-head">G A D</th>
                    <th class="col-email">E-mail Address</th>
                    <th class="col-contact">Contact Number</th>
                    <th class="col-time-processed">Time<br>Processed</th>
                    <th class="col-processing-time">Processing<br>Time</th>
                    <th class="col-emergency">Emergency<br>Case</th>
                    <th class="col-emergency">Non-Emergency<br>Case</th>
                    <th class="col-signature">SIGNATURE</th>
                </tr>
                <tr>
                    <th class="row-num"></th>
                    <th class="col-date"></th>
                    <th class="col-time"></th>
                    <th class="col-name"></th>
                    <th class="col-course"></th>
                    <th class="col-age"></th>
                    <th class="col-gad-small">Male</th>
                    <th class="col-gad-small">Female</th>
                    <th class="col-gad-small tight">Senior Citizen</th>
                    <th class="col-gad-small">PWD</th>
                    <th class="col-email"></th>
                    <th class="col-contact"></th>
                    <th class="col-time-processed"></th>
                    <th class="col-processing-time"></th>
                    <th class="col-emergency"></th>
                    <th class="col-emergency"></th>
                    <th class="col-signature"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="row-num">1</td>
                    <td class="center">{{date_1}}</td>
                    <td class="center">{{time_in_1}}</td>
                    <td class="left">{{patient_name_1}}</td>
                    <td class="left">{{course_section_department_1}}</td>
                    <td class="center">{{age_1}}</td>
                    <td class="center">{{male_1}}</td>
                    <td class="center">{{female_1}}</td>
                    <td class="center">{{senior_citizen_1}}</td>
                    <td class="center">{{pwd_1}}</td>
                    <td class="left">{{email_address_1}}</td>
                    <td class="center">{{contact_number_1}}</td>
                    <td class="center">{{time_processed_1}}</td>
                    <td class="center">{{processing_time_1}}</td>
                    <td class="center">{{emergency_case_1}}</td>
                    <td class="center">{{non_emergency_case_1}}</td>
                    <td class="signature-cell">{{signature_1}}</td>
                </tr>
                <tr>
                    <td class="row-num">2</td>
                    <td class="center">{{date_2}}</td>
                    <td class="center">{{time_in_2}}</td>
                    <td class="left">{{patient_name_2}}</td>
                    <td class="left">{{course_section_department_2}}</td>
                    <td class="center">{{age_2}}</td>
                    <td class="center">{{male_2}}</td>
                    <td class="center">{{female_2}}</td>
                    <td class="center">{{senior_citizen_2}}</td>
                    <td class="center">{{pwd_2}}</td>
                    <td class="left">{{email_address_2}}</td>
                    <td class="center">{{contact_number_2}}</td>
                    <td class="center">{{time_processed_2}}</td>
                    <td class="center">{{processing_time_2}}</td>
                    <td class="center">{{emergency_case_2}}</td>
                    <td class="center">{{non_emergency_case_2}}</td>
                    <td class="signature-cell">{{signature_2}}</td>
                </tr>
                <tr>
                    <td class="row-num">3</td>
                    <td class="center">{{date_3}}</td>
                    <td class="center">{{time_in_3}}</td>
                    <td class="left">{{patient_name_3}}</td>
                    <td class="left">{{course_section_department_3}}</td>
                    <td class="center">{{age_3}}</td>
                    <td class="center">{{male_3}}</td>
                    <td class="center">{{female_3}}</td>
                    <td class="center">{{senior_citizen_3}}</td>
                    <td class="center">{{pwd_3}}</td>
                    <td class="left">{{email_address_3}}</td>
                    <td class="center">{{contact_number_3}}</td>
                    <td class="center">{{time_processed_3}}</td>
                    <td class="center">{{processing_time_3}}</td>
                    <td class="center">{{emergency_case_3}}</td>
                    <td class="center">{{non_emergency_case_3}}</td>
                    <td class="signature-cell">{{signature_3}}</td>
                </tr>
                <tr>
                    <td class="row-num">4</td>
                    <td class="center">{{date_4}}</td>
                    <td class="center">{{time_in_4}}</td>
                    <td class="left">{{patient_name_4}}</td>
                    <td class="left">{{course_section_department_4}}</td>
                    <td class="center">{{age_4}}</td>
                    <td class="center">{{male_4}}</td>
                    <td class="center">{{female_4}}</td>
                    <td class="center">{{senior_citizen_4}}</td>
                    <td class="center">{{pwd_4}}</td>
                    <td class="left">{{email_address_4}}</td>
                    <td class="center">{{contact_number_4}}</td>
                    <td class="center">{{time_processed_4}}</td>
                    <td class="center">{{processing_time_4}}</td>
                    <td class="center">{{emergency_case_4}}</td>
                    <td class="center">{{non_emergency_case_4}}</td>
                    <td class="signature-cell">{{signature_4}}</td>
                </tr>
                <tr>
                    <td class="row-num">5</td>
                    <td class="center">{{date_5}}</td>
                    <td class="center">{{time_in_5}}</td>
                    <td class="left">{{patient_name_5}}</td>
                    <td class="left">{{course_section_department_5}}</td>
                    <td class="center">{{age_5}}</td>
                    <td class="center">{{male_5}}</td>
                    <td class="center">{{female_5}}</td>
                    <td class="center">{{senior_citizen_5}}</td>
                    <td class="center">{{pwd_5}}</td>
                    <td class="left">{{email_address_5}}</td>
                    <td class="center">{{contact_number_5}}</td>
                    <td class="center">{{time_processed_5}}</td>
                    <td class="center">{{processing_time_5}}</td>
                    <td class="center">{{emergency_case_5}}</td>
                    <td class="center">{{non_emergency_case_5}}</td>
                    <td class="signature-cell">{{signature_5}}</td>
                </tr>
                <tr>
                    <td class="row-num">6</td>
                    <td class="center">{{date_6}}</td>
                    <td class="center">{{time_in_6}}</td>
                    <td class="left">{{patient_name_6}}</td>
                    <td class="left">{{course_section_department_6}}</td>
                    <td class="center">{{age_6}}</td>
                    <td class="center">{{male_6}}</td>
                    <td class="center">{{female_6}}</td>
                    <td class="center">{{senior_citizen_6}}</td>
                    <td class="center">{{pwd_6}}</td>
                    <td class="left">{{email_address_6}}</td>
                    <td class="center">{{contact_number_6}}</td>
                    <td class="center">{{time_processed_6}}</td>
                    <td class="center">{{processing_time_6}}</td>
                    <td class="center">{{emergency_case_6}}</td>
                    <td class="center">{{non_emergency_case_6}}</td>
                    <td class="signature-cell">{{signature_6}}</td>
                </tr>
                <tr>
                    <td class="row-num">7</td>
                    <td class="center">{{date_7}}</td>
                    <td class="center">{{time_in_7}}</td>
                    <td class="left">{{patient_name_7}}</td>
                    <td class="left">{{course_section_department_7}}</td>
                    <td class="center">{{age_7}}</td>
                    <td class="center">{{male_7}}</td>
                    <td class="center">{{female_7}}</td>
                    <td class="center">{{senior_citizen_7}}</td>
                    <td class="center">{{pwd_7}}</td>
                    <td class="left">{{email_address_7}}</td>
                    <td class="center">{{contact_number_7}}</td>
                    <td class="center">{{time_processed_7}}</td>
                    <td class="center">{{processing_time_7}}</td>
                    <td class="center">{{emergency_case_7}}</td>
                    <td class="center">{{non_emergency_case_7}}</td>
                    <td class="signature-cell">{{signature_7}}</td>
                </tr>
                <tr>
                    <td class="row-num">8</td>
                    <td class="center">{{date_8}}</td>
                    <td class="center">{{time_in_8}}</td>
                    <td class="left">{{patient_name_8}}</td>
                    <td class="left">{{course_section_department_8}}</td>
                    <td class="center">{{age_8}}</td>
                    <td class="center">{{male_8}}</td>
                    <td class="center">{{female_8}}</td>
                    <td class="center">{{senior_citizen_8}}</td>
                    <td class="center">{{pwd_8}}</td>
                    <td class="left">{{email_address_8}}</td>
                    <td class="center">{{contact_number_8}}</td>
                    <td class="center">{{time_processed_8}}</td>
                    <td class="center">{{processing_time_8}}</td>
                    <td class="center">{{emergency_case_8}}</td>
                    <td class="center">{{non_emergency_case_8}}</td>
                    <td class="signature-cell">{{signature_8}}</td>
                </tr>
                <tr>
                    <td class="row-num">9</td>
                    <td class="center">{{date_9}}</td>
                    <td class="center">{{time_in_9}}</td>
                    <td class="left">{{patient_name_9}}</td>
                    <td class="left">{{course_section_department_9}}</td>
                    <td class="center">{{age_9}}</td>
                    <td class="center">{{male_9}}</td>
                    <td class="center">{{female_9}}</td>
                    <td class="center">{{senior_citizen_9}}</td>
                    <td class="center">{{pwd_9}}</td>
                    <td class="left">{{email_address_9}}</td>
                    <td class="center">{{contact_number_9}}</td>
                    <td class="center">{{time_processed_9}}</td>
                    <td class="center">{{processing_time_9}}</td>
                    <td class="center">{{emergency_case_9}}</td>
                    <td class="center">{{non_emergency_case_9}}</td>
                    <td class="signature-cell">{{signature_9}}</td>
                </tr>
                <tr>
                    <td class="row-num">10</td>
                    <td class="center">{{date_10}}</td>
                    <td class="center">{{time_in_10}}</td>
                    <td class="left">{{patient_name_10}}</td>
                    <td class="left">{{course_section_department_10}}</td>
                    <td class="center">{{age_10}}</td>
                    <td class="center">{{male_10}}</td>
                    <td class="center">{{female_10}}</td>
                    <td class="center">{{senior_citizen_10}}</td>
                    <td class="center">{{pwd_10}}</td>
                    <td class="left">{{email_address_10}}</td>
                    <td class="center">{{contact_number_10}}</td>
                    <td class="center">{{time_processed_10}}</td>
                    <td class="center">{{processing_time_10}}</td>
                    <td class="center">{{emergency_case_10}}</td>
                    <td class="center">{{non_emergency_case_10}}</td>
                    <td class="signature-cell">{{signature_10}}</td>
                </tr>
                <tr>
                    <td class="row-num">11</td>
                    <td class="center">{{date_11}}</td>
                    <td class="center">{{time_in_11}}</td>
                    <td class="left">{{patient_name_11}}</td>
                    <td class="left">{{course_section_department_11}}</td>
                    <td class="center">{{age_11}}</td>
                    <td class="center">{{male_11}}</td>
                    <td class="center">{{female_11}}</td>
                    <td class="center">{{senior_citizen_11}}</td>
                    <td class="center">{{pwd_11}}</td>
                    <td class="left">{{email_address_11}}</td>
                    <td class="center">{{contact_number_11}}</td>
                    <td class="center">{{time_processed_11}}</td>
                    <td class="center">{{processing_time_11}}</td>
                    <td class="center">{{emergency_case_11}}</td>
                    <td class="center">{{non_emergency_case_11}}</td>
                    <td class="signature-cell">{{signature_11}}</td>
                </tr>
                <tr>
                    <td class="row-num">12</td>
                    <td class="center">{{date_12}}</td>
                    <td class="center">{{time_in_12}}</td>
                    <td class="left">{{patient_name_12}}</td>
                    <td class="left">{{course_section_department_12}}</td>
                    <td class="center">{{age_12}}</td>
                    <td class="center">{{male_12}}</td>
                    <td class="center">{{female_12}}</td>
                    <td class="center">{{senior_citizen_12}}</td>
                    <td class="center">{{pwd_12}}</td>
                    <td class="left">{{email_address_12}}</td>
                    <td class="center">{{contact_number_12}}</td>
                    <td class="center">{{time_processed_12}}</td>
                    <td class="center">{{processing_time_12}}</td>
                    <td class="center">{{emergency_case_12}}</td>
                    <td class="center">{{non_emergency_case_12}}</td>
                    <td class="signature-cell">{{signature_12}}</td>
                </tr>
                <tr>
                    <td class="row-num">13</td>
                    <td class="center">{{date_13}}</td>
                    <td class="center">{{time_in_13}}</td>
                    <td class="left">{{patient_name_13}}</td>
                    <td class="left">{{course_section_department_13}}</td>
                    <td class="center">{{age_13}}</td>
                    <td class="center">{{male_13}}</td>
                    <td class="center">{{female_13}}</td>
                    <td class="center">{{senior_citizen_13}}</td>
                    <td class="center">{{pwd_13}}</td>
                    <td class="left">{{email_address_13}}</td>
                    <td class="center">{{contact_number_13}}</td>
                    <td class="center">{{time_processed_13}}</td>
                    <td class="center">{{processing_time_13}}</td>
                    <td class="center">{{emergency_case_13}}</td>
                    <td class="center">{{non_emergency_case_13}}</td>
                    <td class="signature-cell">{{signature_13}}</td>
                </tr>
                <tr>
                    <td class="row-num">14</td>
                    <td class="center">{{date_14}}</td>
                    <td class="center">{{time_in_14}}</td>
                    <td class="left">{{patient_name_14}}</td>
                    <td class="left">{{course_section_department_14}}</td>
                    <td class="center">{{age_14}}</td>
                    <td class="center">{{male_14}}</td>
                    <td class="center">{{female_14}}</td>
                    <td class="center">{{senior_citizen_14}}</td>
                    <td class="center">{{pwd_14}}</td>
                    <td class="left">{{email_address_14}}</td>
                    <td class="center">{{contact_number_14}}</td>
                    <td class="center">{{time_processed_14}}</td>
                    <td class="center">{{processing_time_14}}</td>
                    <td class="center">{{emergency_case_14}}</td>
                    <td class="center">{{non_emergency_case_14}}</td>
                    <td class="signature-cell">{{signature_14}}</td>
                </tr>
                <tr>
                    <td class="row-num">15</td>
                    <td class="center">{{date_15}}</td>
                    <td class="center">{{time_in_15}}</td>
                    <td class="left">{{patient_name_15}}</td>
                    <td class="left">{{course_section_department_15}}</td>
                    <td class="center">{{age_15}}</td>
                    <td class="center">{{male_15}}</td>
                    <td class="center">{{female_15}}</td>
                    <td class="center">{{senior_citizen_15}}</td>
                    <td class="center">{{pwd_15}}</td>
                    <td class="left">{{email_address_15}}</td>
                    <td class="center">{{contact_number_15}}</td>
                    <td class="center">{{time_processed_15}}</td>
                    <td class="center">{{processing_time_15}}</td>
                    <td class="center">{{emergency_case_15}}</td>
                    <td class="center">{{non_emergency_case_15}}</td>
                    <td class="signature-cell">{{signature_15}}</td>
                </tr>
            </tbody>
        </table>

    </div>
    </div>
</body>
</html>