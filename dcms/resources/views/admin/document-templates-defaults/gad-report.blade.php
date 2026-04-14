<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Accomplishment Report</title>
    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: A4 portrait;
            margin: 0.45in 0.55in;
        }

        body {
            margin: 0;
            background: #d6cfc4;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }

        .page {
            width: 8.27in;
            min-height: 11.69in;
            margin: 0 auto;
            padding: 0.2in 0.15in 0.25in;
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
            grid-template-columns: 110px 1fr 120px;
            align-items: start;
            gap: 12px;
            margin-bottom: 28px;
        }

        .logo-box,
        .right-logo-box {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 95px;
        }

        .logo-box img,
        .right-logo-box img {
            max-width: 95px;
            max-height: 95px;
            object-fit: contain;
            display: block;
        }

        .logo-fallback {
            width: 90px;
            height: 90px;
            border: 1px dashed #888;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 6px;
        }

        .header-text {
            text-align: left;
            line-height: 1.15;
            padding-top: 8px;
        }

        .header-text .line1 {
            font-size: 17px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .header-text .line2 {
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .header-text .line3,
        .header-text .line4,
        .header-text .line5 {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .report-title {
            text-align: center;
            margin: 18px 0 42px;
            line-height: 1.25;
        }

        .report-title .t1,
        .report-title .t2,
        .report-title .t3,
        .report-title .t4 {
            font-size: 15px;
            font-weight: 700;
            text-transform: none;
        }

        .report-title .t1 {
            text-transform: uppercase;
        }

        .report-title .t3 {
            text-transform: uppercase;
        }

        .table-wrap {
            margin: 0 auto 28px;
            width: 96%;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 12px;
        }

        table.report-table th,
        table.report-table td {
            border: 2px solid #000;
            padding: 5px 6px;
            text-align: center;
            vertical-align: middle;
            font-weight: 700;
        }

        table.report-table th.main-gad {
            font-size: 24px;
            letter-spacing: 0.02em;
        }

        table.report-table .left-label {
            text-align: center;
            font-weight: 700;
        }

        table.report-table .gender {
            width: 84px;
        }

        table.report-table th.col-small,
        table.report-table td.col-small {
            width: 92px;
        }

        table.report-table .col-small {
            width: 92px;
        }

        table.report-table .col-total {
            width: 78px;
        }

        table.report-table td.left-label {
            width: 128px;
            padding-left: 8px;
            padding-right: 8px;
        }

        table.report-table th:first-child,
        table.report-table td:first-child {
            width: 128px;
        }

        .signatory-row {
            margin-top: 28px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 50px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .sign-block {
            width: 44%;
        }

        .sign-label {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .sign-img {
            height: 100px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-end;
            justify-content: flex-start;
        }

        .sign-img img {
            max-width: 220px;
            max-height: 92px;
            object-fit: contain;
            display: block;
        }

        .sign-fallback {
            width: 220px;
            height: 74px;
            border: 1px dashed #888;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #666;
        }

        .sign-name {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.2;
        }

        .sign-role {
            font-size: 14px;
            font-weight: 700;
            line-height: 1.2;
        }

        .footer {
            margin-top: 96px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
        }

        .footer-left {
            font-size: 11px;
            line-height: 1.4;
            font-weight: 700;
        }

        .footer-left .tagline {
            margin-top: 12px;
            text-transform: uppercase;
        }

        .footer-right {
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

        .footer-right img {
            max-width: 140px;
            max-height: 100px;
            object-fit: contain;
            display: block;
        }

        .footer-logo-fallback {
            width: 120px;
            height: 80px;
            border: 1px dashed #888;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 11px;
            color: #666;
            padding: 4px;
        }

        @media print {
            body {
                background: #fff;
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
    <div class="page">

        <div class="header">
            <div class="logo-box">
                <img src="{{pup_logo}}" alt="PUP Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="logo-fallback" style="display:none;">PUP Logo</div>
            </div>

            <div class="header-text">
                <div class="line1">REPUBLIC OF THE PHILIPPINES</div>
                <div class="line2">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</div>
                <div class="line3">OFFICE OF THE VICE PRESIDENT FOR ADMINISTRATION</div>
                <div class="line4">MEDICAL SERVICES DEPARTMENT</div>
                <div class="line5">DENTAL SECTION</div>
            </div>

            <div class="right-logo-box">
                <img src="{{bagong_pilipinas_logo}}" alt="Bagong Pilipinas Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="logo-fallback" style="display:none;">Bagong Pilipinas Logo</div>
            </div>
        </div>

        <div class="report-title">
            <div class="t1">GAD</div>
            <div class="t2">Accomplishment Report</div>
            <div class="t3">as of {{report_month_year}}</div>
            <div class="t4">{{campus_name}}</div>
        </div>

        <div class="table-wrap">
            <table class="report-table">
                <tr>
                    <th class="main-gad" colspan="2" rowspan="2">GAD</th>
                    <th class="col-small">Students</th>
                    <th class="col-small">Faculty</th>
                    <th class="col-small">Administrative</th>
                    <th class="col-small">Dependent</th>
                    <th class="col-total">Total</th>
                </tr>
                <tr>
                    <td>{{header_students}}</td>
                    <td>{{header_faculty}}</td>
                    <td>{{header_administrative}}</td>
                    <td>{{header_dependent}}</td>
                    <td>{{header_total}}</td>
                </tr>

                <tr>
                    <td class="left-label" rowspan="2">{{gad_category_1}}</td>
                    <td class="gender">Male</td>
                    <td>{{cat1_male_students}}</td>
                    <td>{{cat1_male_faculty}}</td>
                    <td>{{cat1_male_administrative}}</td>
                    <td>{{cat1_male_dependent}}</td>
                    <td>{{cat1_male_total}}</td>
                </tr>
                <tr>
                    <td class="gender">Female</td>
                    <td>{{cat1_female_students}}</td>
                    <td>{{cat1_female_faculty}}</td>
                    <td>{{cat1_female_administrative}}</td>
                    <td>{{cat1_female_dependent}}</td>
                    <td>{{cat1_female_total}}</td>
                </tr>

                <tr>
                    <td class="left-label" rowspan="2">{{gad_category_2}}</td>
                    <td class="gender">Male</td>
                    <td>{{cat2_male_students}}</td>
                    <td>{{cat2_male_faculty}}</td>
                    <td>{{cat2_male_administrative}}</td>
                    <td>{{cat2_male_dependent}}</td>
                    <td>{{cat2_male_total}}</td>
                </tr>
                <tr>
                    <td class="gender">Female</td>
                    <td>{{cat2_female_students}}</td>
                    <td>{{cat2_female_faculty}}</td>
                    <td>{{cat2_female_administrative}}</td>
                    <td>{{cat2_female_dependent}}</td>
                    <td>{{cat2_female_total}}</td>
                </tr>

                <tr>
                    <td class="left-label" rowspan="2">{{gad_category_3}}</td>
                    <td class="gender">Male</td>
                    <td>{{cat3_male_students}}</td>
                    <td>{{cat3_male_faculty}}</td>
                    <td>{{cat3_male_administrative}}</td>
                    <td>{{cat3_male_dependent}}</td>
                    <td>{{cat3_male_total}}</td>
                </tr>
                <tr>
                    <td class="gender">Female</td>
                    <td>{{cat3_female_students}}</td>
                    <td>{{cat3_female_faculty}}</td>
                    <td>{{cat3_female_administrative}}</td>
                    <td>{{cat3_female_dependent}}</td>
                    <td>{{cat3_female_total}}</td>
                </tr>

                <tr>
                    <td class="left-label" colspan="2">TOTAL:</td>
                    <td>{{total_students}}</td>
                    <td>{{total_faculty}}</td>
                    <td>{{total_administrative}}</td>
                    <td>{{total_dependent}}</td>
                    <td>{{grand_total}}</td>
                </tr>
            </table>
        </div>

        <div class="signatory-row">
            <div class="sign-block">
                <div class="sign-label">Prepared by:</div>
                <div class="sign-img">
                    <img src="{{prepared_by_signature}}" alt="Prepared By Signature" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="sign-fallback" style="display:none;">Prepared By Signature</div>
                </div>
                <div class="sign-name">{{prepared_by}}</div>
                <div class="sign-role">{{prepared_by_role}}</div>
            </div>

            <div class="sign-block">
                <div class="sign-label">Submitted by:</div>
                <div class="sign-img">
                    <img src="{{submitted_by_signature}}" alt="Submitted By Signature" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="sign-fallback" style="display:none;">Submitted By Signature</div>
                </div>
                <div class="sign-name">{{submitted_by}}</div>
                <div class="sign-role">{{submitted_by_role}}</div>
            </div>
        </div>

        <div class="footer">
            <div class="footer-left">
                <div>PUP A. Mabini Campus, Anonas Street, Sta. Mesa, Manila 1016</div>
                <div>Direct Line: 335-1745 | Trunk Line: 335-1787 or 335-1777 local 311</div>
                <div>Website: www.pup.edu.ph | Email: medical@pup.edu.ph</div>
                <div class="tagline">THE COUNTRY’S 1st POLYTECHNICU</div>
            </div>

            <div class="footer-right">
                <img src="{{iab_logo}}" alt="ISO 9001 Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="footer-logo-fallback" style="display:none;">ISO Logo</div>
            </div>
        </div>

    </div>
</body>
</html>