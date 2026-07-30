<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Daily Treatment Record</title>
	<style>
		* {
			box-sizing: border-box;
		}

		@page {
			size: legal landscape;
			margin: 0.42in 0.45in;
		}

		body {
			margin: 0;
			background: #d6cfc4;
			font-family: Arial, Helvetica, sans-serif;
			color: #000;
		}

		.preview-stage {
			padding: 18px 0 28px;
		}

		.page {
			width: 14in;
			min-height: 8.5in;
			margin: 0 auto;
			padding: 0.18in 0.2in 0.24in;
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
			grid-template-columns: 120px 1fr 120px;
			gap: 10px;
			align-items: center;
			margin-bottom: 10px;
		}

		.logo-box,
		.right-logo-box {
			display: flex;
			justify-content: center;
			align-items: flex-start;
			min-height: 84px;
		}

		.logo-box img,
		.right-logo-box img {
			max-width: 88px;
			max-height: 88px;
			object-fit: contain;
			display: block;
		}

		.logo-fallback {
			width: 82px;
			height: 82px;
			border: 1px dashed #888;
			display: flex;
			align-items: center;
			justify-content: center;
			text-align: center;
			font-size: 10px;
			color: #666;
			padding: 4px;
		}

		.header-text {
			text-align: left;
			line-height: 1.05;
			padding-top: 0;
			padding-left: 2px;
		}

		.header-text .line1,
		.header-text .line2,
		.header-text .line3,
		.header-text .line4,
		.header-text .line5 {
			font-weight: 700;
			text-transform: uppercase;
		}

		.header-text .line1 { font-size: 13px; letter-spacing: 0.2px; }
		.header-text .line2 { font-size: 13px; margin-top: 2px; }
		.header-text .line3 { font-size: 12px; margin-top: 1px; }
		.header-text .line4 { font-size: 13px; margin-top: 1px; }
		.header-text .line5 { font-size: 13px; margin-top: 2px; }

		.report-title {
			text-align: center;
			margin: 4px 0 14px;
			line-height: 1.1;
		}

		.report-title .title {
			font-size: 22px;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.3px;
		}

		.report-title .subtitle {
			margin-top: 4px;
			font-size: 12px;
			font-weight: 700;
			text-transform: uppercase;
		}

		.table-wrap {
			margin-top: 10px;
		}

		table.report-table {
			width: 100%;
			border-collapse: collapse;
			table-layout: fixed;
			font-size: 10px;
		}

		table.report-table th,
		table.report-table td {
			border: 1.5px solid #000;
			padding: 4px 5px;
			vertical-align: middle;
		}

		table.report-table th {
			text-align: center;
			font-weight: 700;
			text-transform: uppercase;
			line-height: 1.05;
		}

		.col-date { width: 105px; }
		.col-patient { width: 170px; }
		.col-contact { width: 170px; }
		.col-office { width: 95px; }
		.col-gender { width: 70px; }
		.col-treatment { width: auto; }
		.col-processed { width: 100px; }
		.col-minutes { width: 110px; }
		.col-signature { width: 104px; }

		td.center {
			text-align: center;
			font-weight: 700;
		}

		td.left {
			text-align: left;
			font-weight: 700;
		}

		.footer {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 36px;
			margin-top: 22px;
			align-items: end;
		}

		.sign-block {
			min-height: 140px;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			justify-content: flex-end;
			gap: 6px;
		}

		.sign-label {
			font-size: 12px;
			font-weight: 700;
		}

		.sign-image {
			height: 72px;
			max-width: 180px;
			display: block;
			object-fit: contain;
		}

		.sign-image.prepared {
			margin-left: 6px;
		}

		.sign-name {
			font-size: 12px;
			font-weight: 700;
			text-transform: uppercase;
		}

		.sign-role {
			font-size: 11px;
		}

		.footer-band {
			display: grid;
			grid-template-columns: 1fr auto;
			gap: 16px;
			align-items: end;
			margin-top: 18px;
		}

		.footer-left {
			font-size: 11px;
			line-height: 1.25;
		}

		.footer-left .tagline {
			margin-top: 10px;
			font-size: 24px;
			font-weight: 700;
			font-family: Georgia, 'Times New Roman', serif;
		}

		.footer-logos {
			display: flex;
			align-items: flex-end;
			gap: 10px;
			justify-content: flex-end;
		}

		.footer-logos img {
			display: block;
			object-fit: contain;
		}

		.footer-logos img:first-child {
			height: 92px;
		}

		.footer-logos img:last-child {
			height: 34px;
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

				<div class="header-text">
					<div class="line1">REPUBLIC OF THE PHILIPPINES</div>
					<div class="line2">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</div>
					<div class="line3">OFFICE OF THE VICE PRESIDENT FOR CAMPUSES</div>
					<div class="line4">TAGUIG CAMPUS - DENTAL SERVICES DEPARTMENT</div>
				</div>

				<div class="right-logo-box">
					<img src="{{bagong_pilipinas_logo}}" alt="Bagong Pilipinas Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
					<div class="logo-fallback" style="display:none;">Bagong Pilipinas Logo</div>
				</div>
			</div>

			<div class="report-title">
				<div class="title">Daily Treatment Record</div>
				<div class="subtitle">{{report_month_year}}</div>
			</div>

			<div class="table-wrap">
				<table class="report-table">
					<thead>
						<tr>
							<th class="col-date">Date / Time Requested</th>
							<th class="col-patient">Patient Name</th>
							<th class="col-contact">Email Address / Contact Number</th>
							<th class="col-office">Office</th>
							<th class="col-gender">Gender</th>
							<th class="col-treatment">Treatment Done</th>
							<th class="col-processed">Date / Time Processed</th>
							<th class="col-minutes">Number of Minutes Processed</th>
							<th class="col-signature">Patient Signature</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="center">{{row_1_date}}</td>
							<td class="left">{{row_1_patient_name}}</td>
							<td class="left">{{row_1_contact}}</td>
							<td class="center">{{row_1_office}}</td>
							<td class="center">{{row_1_gender}}</td>
							<td class="left">{{row_1_treatment}}</td>
							<td class="center">{{row_1_processed}}</td>
							<td class="center">{{row_1_minutes}}</td>
							<td class="center">{{row_1_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_2_date}}</td>
							<td class="left">{{row_2_patient_name}}</td>
							<td class="left">{{row_2_contact}}</td>
							<td class="center">{{row_2_office}}</td>
							<td class="center">{{row_2_gender}}</td>
							<td class="left">{{row_2_treatment}}</td>
							<td class="center">{{row_2_processed}}</td>
							<td class="center">{{row_2_minutes}}</td>
							<td class="center">{{row_2_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_3_date}}</td>
							<td class="left">{{row_3_patient_name}}</td>
							<td class="left">{{row_3_contact}}</td>
							<td class="center">{{row_3_office}}</td>
							<td class="center">{{row_3_gender}}</td>
							<td class="left">{{row_3_treatment}}</td>
							<td class="center">{{row_3_processed}}</td>
							<td class="center">{{row_3_minutes}}</td>
							<td class="center">{{row_3_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_4_date}}</td>
							<td class="left">{{row_4_patient_name}}</td>
							<td class="left">{{row_4_contact}}</td>
							<td class="center">{{row_4_office}}</td>
							<td class="center">{{row_4_gender}}</td>
							<td class="left">{{row_4_treatment}}</td>
							<td class="center">{{row_4_processed}}</td>
							<td class="center">{{row_4_minutes}}</td>
							<td class="center">{{row_4_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_5_date}}</td>
							<td class="left">{{row_5_patient_name}}</td>
							<td class="left">{{row_5_contact}}</td>
							<td class="center">{{row_5_office}}</td>
							<td class="center">{{row_5_gender}}</td>
							<td class="left">{{row_5_treatment}}</td>
							<td class="center">{{row_5_processed}}</td>
							<td class="center">{{row_5_minutes}}</td>
							<td class="center">{{row_5_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_6_date}}</td>
							<td class="left">{{row_6_patient_name}}</td>
							<td class="left">{{row_6_contact}}</td>
							<td class="center">{{row_6_office}}</td>
							<td class="center">{{row_6_gender}}</td>
							<td class="left">{{row_6_treatment}}</td>
							<td class="center">{{row_6_processed}}</td>
							<td class="center">{{row_6_minutes}}</td>
							<td class="center">{{row_6_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_7_date}}</td>
							<td class="left">{{row_7_patient_name}}</td>
							<td class="left">{{row_7_contact}}</td>
							<td class="center">{{row_7_office}}</td>
							<td class="center">{{row_7_gender}}</td>
							<td class="left">{{row_7_treatment}}</td>
							<td class="center">{{row_7_processed}}</td>
							<td class="center">{{row_7_minutes}}</td>
							<td class="center">{{row_7_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_8_date}}</td>
							<td class="left">{{row_8_patient_name}}</td>
							<td class="left">{{row_8_contact}}</td>
							<td class="center">{{row_8_office}}</td>
							<td class="center">{{row_8_gender}}</td>
							<td class="left">{{row_8_treatment}}</td>
							<td class="center">{{row_8_processed}}</td>
							<td class="center">{{row_8_minutes}}</td>
							<td class="center">{{row_8_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_9_date}}</td>
							<td class="left">{{row_9_patient_name}}</td>
							<td class="left">{{row_9_contact}}</td>
							<td class="center">{{row_9_office}}</td>
							<td class="center">{{row_9_gender}}</td>
							<td class="left">{{row_9_treatment}}</td>
							<td class="center">{{row_9_processed}}</td>
							<td class="center">{{row_9_minutes}}</td>
							<td class="center">{{row_9_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_10_date}}</td>
							<td class="left">{{row_10_patient_name}}</td>
							<td class="left">{{row_10_contact}}</td>
							<td class="center">{{row_10_office}}</td>
							<td class="center">{{row_10_gender}}</td>
							<td class="left">{{row_10_treatment}}</td>
							<td class="center">{{row_10_processed}}</td>
							<td class="center">{{row_10_minutes}}</td>
							<td class="center">{{row_10_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_11_date}}</td>
							<td class="left">{{row_11_patient_name}}</td>
							<td class="left">{{row_11_contact}}</td>
							<td class="center">{{row_11_office}}</td>
							<td class="center">{{row_11_gender}}</td>
							<td class="left">{{row_11_treatment}}</td>
							<td class="center">{{row_11_processed}}</td>
							<td class="center">{{row_11_minutes}}</td>
							<td class="center">{{row_11_signature}}</td>
						</tr>
						<tr>
							<td class="center">{{row_12_date}}</td>
							<td class="left">{{row_12_patient_name}}</td>
							<td class="left">{{row_12_contact}}</td>
							<td class="center">{{row_12_office}}</td>
							<td class="center">{{row_12_gender}}</td>
							<td class="left">{{row_12_treatment}}</td>
							<td class="center">{{row_12_processed}}</td>
							<td class="center">{{row_12_minutes}}</td>
							<td class="center">{{row_12_signature}}</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="footer">
				<div class="sign-block">
					<div class="sign-label">Prepared by:</div>
					<img src="{{prepared_by_signature}}" alt="Prepared by signature" class="sign-image prepared">
					<div class="sign-name">{{prepared_by}}</div>
					<div class="sign-role">{{prepared_by_role}}</div>
				</div>

				<div class="sign-block" style="align-items: center; text-align:center;">
					<div class="sign-label">Noted by:</div>
					<img src="{{noted_by_signature}}" alt="Noted by signature" class="sign-image" style="margin: 0 auto;">
					<div class="sign-name">{{noted_by}}</div>
					<div class="sign-role">{{noted_by_role}}</div>
				</div>
			</div>

			<div class="footer-band">
				<div class="footer-left">
					<div>PUP A. Mabini Campus, Anonas Street, Sta. Mesa, Manila 1016</div>
					<div>Direct Line: 335-1745 | Trunk Line: 335-1787 or 335-1777 local 385 (Medical Director’s Office), 312 (Clinic)</div>
					<div>Website: www.pup.edu.ph | Email: medical@pup.edu.ph</div>
					<div class="tagline">THE COUNTRY’S 1st POLYTECHNICU</div>
				</div>

				<div class="footer-logos">
					<img src="/images/wuri.png" alt="WURI" onerror="this.style.display='none'">
					<img src="/images/bagong-pilipinas.png" alt="Bagong Pilipinas" onerror="this.style.display='none'">
				</div>
			</div>
		</div>
	</div>
</body>
</html>
