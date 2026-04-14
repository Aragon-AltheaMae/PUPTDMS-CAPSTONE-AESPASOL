<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Supplies</title>
    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: legal portrait;
            margin: 0.5in 0.52in;
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
            width: 8.5in;
            min-height: 14in;
            margin: 0 auto;
            padding: 0.28in 0.24in 0.32in;
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
            grid-template-columns: 92px 1fr 92px;
            align-items: start;
            gap: 10px;
            margin-bottom: 22px;
        }

        .logo-box,
        .right-logo-box {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 80px;
        }

        .logo-box img,
        .right-logo-box img {
            max-width: 82px;
            max-height: 82px;
            object-fit: contain;
            display: block;
        }

        .logo-fallback {
            width: 74px;
            height: 74px;
            border: 1px dashed #888;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 9px;
            color: #666;
            padding: 4px;
        }

        .header-text {
            text-align: center;
            line-height: 1.1;
            padding-top: 2px;
        }

        .header-text .line1,
        .header-text .line2,
        .header-text .line3,
        .header-text .line4,
        .header-text .line5,
        .header-text .line6 {
            font-weight: 700;
            text-transform: uppercase;
        }

        .header-text .line1 { font-size: 16px; letter-spacing: 0.2px; }
        .header-text .line2 { font-size: 16px; margin-top: 2px; }
        .header-text .line3 { font-size: 15px; margin-top: 2px; }
        .header-text .line4 { font-size: 15px; margin-top: 4px; }
        .header-text .line5 { font-size: 15px; margin-top: 2px; }
        .header-text .line6 { font-size: 15px; margin-top: 2px; }

        .table-wrap {
            margin-top: 16px;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 10px;
        }

        table.report-table th,
        table.report-table td {
            border: 1.6px solid #000;
            padding: 4px 5px;
            vertical-align: middle;
        }

        table.report-table th {
            text-align: center;
            font-weight: 700;
            text-transform: uppercase;
        }

        .col-date { width: 115px; text-align: center; }
        .col-stock { width: 82px; text-align: center; }
        .col-supplies { width: auto; }
        .col-units { width: 70px; text-align: center; }
        .col-qty { width: 78px; text-align: center; }
        .col-consumed { width: 78px; text-align: center; }
        .col-balance { width: 72px; text-align: center; }

        td.center {
            text-align: center;
            font-weight: 700;
        }

        td.left {
            text-align: left;
            font-weight: 700;
        }

        .placeholder {
            font-weight: 700;
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
                <div class="line1">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</div>
                <div class="line2">DENTAL SERVICES</div>
                <div class="line3">MSD</div>
                <div class="line4">AS OF {{report_month_year}}</div>
                <div class="line5">Consolidated Report of DENTAL MEDICINES</div>
                <div class="line6">{{clinic_name}}</div>
            </div>
        </div>

        <div class="table-wrap">
            <table class="report-table">
                <thead>
                    <tr>
                        <th class="col-date">Date<br>Received</th>
                        <th class="col-stock">Stock<br>Number</th>
                        <th class="col-supplies">Supplies</th>
                        <th class="col-units">Units</th>
                        <th class="col-qty">Quantity</th>
                        <th class="col-consumed">Consumed</th>
                        <th class="col-balance">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="center">{{date_received_1}}</td>
                        <td class="center">{{stock_number_1}}</td>
                        <td class="left">{{supply_name_1}}</td>
                        <td class="center">{{unit_1}}</td>
                        <td class="center">{{quantity_1}}</td>
                        <td class="center">{{consumed_1}}</td>
                        <td class="center">{{balance_1}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_2}}</td>
                        <td class="center">{{stock_number_2}}</td>
                        <td class="left">{{supply_name_2}}</td>
                        <td class="center">{{unit_2}}</td>
                        <td class="center">{{quantity_2}}</td>
                        <td class="center">{{consumed_2}}</td>
                        <td class="center">{{balance_2}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_3}}</td>
                        <td class="center">{{stock_number_3}}</td>
                        <td class="left">{{supply_name_3}}</td>
                        <td class="center">{{unit_3}}</td>
                        <td class="center">{{quantity_3}}</td>
                        <td class="center">{{consumed_3}}</td>
                        <td class="center">{{balance_3}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_4}}</td>
                        <td class="center">{{stock_number_4}}</td>
                        <td class="left">{{supply_name_4}}</td>
                        <td class="center">{{unit_4}}</td>
                        <td class="center">{{quantity_4}}</td>
                        <td class="center">{{consumed_4}}</td>
                        <td class="center">{{balance_4}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_5}}</td>
                        <td class="center">{{stock_number_5}}</td>
                        <td class="left">{{supply_name_5}}</td>
                        <td class="center">{{unit_5}}</td>
                        <td class="center">{{quantity_5}}</td>
                        <td class="center">{{consumed_5}}</td>
                        <td class="center">{{balance_5}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_6}}</td>
                        <td class="center">{{stock_number_6}}</td>
                        <td class="left">{{supply_name_6}}</td>
                        <td class="center">{{unit_6}}</td>
                        <td class="center">{{quantity_6}}</td>
                        <td class="center">{{consumed_6}}</td>
                        <td class="center">{{balance_6}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_7}}</td>
                        <td class="center">{{stock_number_7}}</td>
                        <td class="left">{{supply_name_7}}</td>
                        <td class="center">{{unit_7}}</td>
                        <td class="center">{{quantity_7}}</td>
                        <td class="center">{{consumed_7}}</td>
                        <td class="center">{{balance_7}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_8}}</td>
                        <td class="center">{{stock_number_8}}</td>
                        <td class="left">{{supply_name_8}}</td>
                        <td class="center">{{unit_8}}</td>
                        <td class="center">{{quantity_8}}</td>
                        <td class="center">{{consumed_8}}</td>
                        <td class="center">{{balance_8}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_9}}</td>
                        <td class="center">{{stock_number_9}}</td>
                        <td class="left">{{supply_name_9}}</td>
                        <td class="center">{{unit_9}}</td>
                        <td class="center">{{quantity_9}}</td>
                        <td class="center">{{consumed_9}}</td>
                        <td class="center">{{balance_9}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_10}}</td>
                        <td class="center">{{stock_number_10}}</td>
                        <td class="left">{{supply_name_10}}</td>
                        <td class="center">{{unit_10}}</td>
                        <td class="center">{{quantity_10}}</td>
                        <td class="center">{{consumed_10}}</td>
                        <td class="center">{{balance_10}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_11}}</td>
                        <td class="center">{{stock_number_11}}</td>
                        <td class="left">{{supply_name_11}}</td>
                        <td class="center">{{unit_11}}</td>
                        <td class="center">{{quantity_11}}</td>
                        <td class="center">{{consumed_11}}</td>
                        <td class="center">{{balance_11}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_12}}</td>
                        <td class="center">{{stock_number_12}}</td>
                        <td class="left">{{supply_name_12}}</td>
                        <td class="center">{{unit_12}}</td>
                        <td class="center">{{quantity_12}}</td>
                        <td class="center">{{consumed_12}}</td>
                        <td class="center">{{balance_12}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_13}}</td>
                        <td class="center">{{stock_number_13}}</td>
                        <td class="left">{{supply_name_13}}</td>
                        <td class="center">{{unit_13}}</td>
                        <td class="center">{{quantity_13}}</td>
                        <td class="center">{{consumed_13}}</td>
                        <td class="center">{{balance_13}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_14}}</td>
                        <td class="center">{{stock_number_14}}</td>
                        <td class="left">{{supply_name_14}}</td>
                        <td class="center">{{unit_14}}</td>
                        <td class="center">{{quantity_14}}</td>
                        <td class="center">{{consumed_14}}</td>
                        <td class="center">{{balance_14}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_15}}</td>
                        <td class="center">{{stock_number_15}}</td>
                        <td class="left">{{supply_name_15}}</td>
                        <td class="center">{{unit_15}}</td>
                        <td class="center">{{quantity_15}}</td>
                        <td class="center">{{consumed_15}}</td>
                        <td class="center">{{balance_15}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_16}}</td>
                        <td class="center">{{stock_number_16}}</td>
                        <td class="left">{{supply_name_16}}</td>
                        <td class="center">{{unit_16}}</td>
                        <td class="center">{{quantity_16}}</td>
                        <td class="center">{{consumed_16}}</td>
                        <td class="center">{{balance_16}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_17}}</td>
                        <td class="center">{{stock_number_17}}</td>
                        <td class="left">{{supply_name_17}}</td>
                        <td class="center">{{unit_17}}</td>
                        <td class="center">{{quantity_17}}</td>
                        <td class="center">{{consumed_17}}</td>
                        <td class="center">{{balance_17}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_18}}</td>
                        <td class="center">{{stock_number_18}}</td>
                        <td class="left">{{supply_name_18}}</td>
                        <td class="center">{{unit_18}}</td>
                        <td class="center">{{quantity_18}}</td>
                        <td class="center">{{consumed_18}}</td>
                        <td class="center">{{balance_18}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_19}}</td>
                        <td class="center">{{stock_number_19}}</td>
                        <td class="left">{{supply_name_19}}</td>
                        <td class="center">{{unit_19}}</td>
                        <td class="center">{{quantity_19}}</td>
                        <td class="center">{{consumed_19}}</td>
                        <td class="center">{{balance_19}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_20}}</td>
                        <td class="center">{{stock_number_20}}</td>
                        <td class="left">{{supply_name_20}}</td>
                        <td class="center">{{unit_20}}</td>
                        <td class="center">{{quantity_20}}</td>
                        <td class="center">{{consumed_20}}</td>
                        <td class="center">{{balance_20}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_21}}</td>
                        <td class="center">{{stock_number_21}}</td>
                        <td class="left">{{supply_name_21}}</td>
                        <td class="center">{{unit_21}}</td>
                        <td class="center">{{quantity_21}}</td>
                        <td class="center">{{consumed_21}}</td>
                        <td class="center">{{balance_21}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_22}}</td>
                        <td class="center">{{stock_number_22}}</td>
                        <td class="left">{{supply_name_22}}</td>
                        <td class="center">{{unit_22}}</td>
                        <td class="center">{{quantity_22}}</td>
                        <td class="center">{{consumed_22}}</td>
                        <td class="center">{{balance_22}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_23}}</td>
                        <td class="center">{{stock_number_23}}</td>
                        <td class="left">{{supply_name_23}}</td>
                        <td class="center">{{unit_23}}</td>
                        <td class="center">{{quantity_23}}</td>
                        <td class="center">{{consumed_23}}</td>
                        <td class="center">{{balance_23}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_24}}</td>
                        <td class="center">{{stock_number_24}}</td>
                        <td class="left">{{supply_name_24}}</td>
                        <td class="center">{{unit_24}}</td>
                        <td class="center">{{quantity_24}}</td>
                        <td class="center">{{consumed_24}}</td>
                        <td class="center">{{balance_24}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_25}}</td>
                        <td class="center">{{stock_number_25}}</td>
                        <td class="left">{{supply_name_25}}</td>
                        <td class="center">{{unit_25}}</td>
                        <td class="center">{{quantity_25}}</td>
                        <td class="center">{{consumed_25}}</td>
                        <td class="center">{{balance_25}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_26}}</td>
                        <td class="center">{{stock_number_26}}</td>
                        <td class="left">{{supply_name_26}}</td>
                        <td class="center">{{unit_26}}</td>
                        <td class="center">{{quantity_26}}</td>
                        <td class="center">{{consumed_26}}</td>
                        <td class="center">{{balance_26}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_27}}</td>
                        <td class="center">{{stock_number_27}}</td>
                        <td class="left">{{supply_name_27}}</td>
                        <td class="center">{{unit_27}}</td>
                        <td class="center">{{quantity_27}}</td>
                        <td class="center">{{consumed_27}}</td>
                        <td class="center">{{balance_27}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_28}}</td>
                        <td class="center">{{stock_number_28}}</td>
                        <td class="left">{{supply_name_28}}</td>
                        <td class="center">{{unit_28}}</td>
                        <td class="center">{{quantity_28}}</td>
                        <td class="center">{{consumed_28}}</td>
                        <td class="center">{{balance_28}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_29}}</td>
                        <td class="center">{{stock_number_29}}</td>
                        <td class="left">{{supply_name_29}}</td>
                        <td class="center">{{unit_29}}</td>
                        <td class="center">{{quantity_29}}</td>
                        <td class="center">{{consumed_29}}</td>
                        <td class="center">{{balance_29}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_30}}</td>
                        <td class="center">{{stock_number_30}}</td>
                        <td class="left">{{supply_name_30}}</td>
                        <td class="center">{{unit_30}}</td>
                        <td class="center">{{quantity_30}}</td>
                        <td class="center">{{consumed_30}}</td>
                        <td class="center">{{balance_30}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_31}}</td>
                        <td class="center">{{stock_number_31}}</td>
                        <td class="left">{{supply_name_31}}</td>
                        <td class="center">{{unit_31}}</td>
                        <td class="center">{{quantity_31}}</td>
                        <td class="center">{{consumed_31}}</td>
                        <td class="center">{{balance_31}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_32}}</td>
                        <td class="center">{{stock_number_32}}</td>
                        <td class="left">{{supply_name_32}}</td>
                        <td class="center">{{unit_32}}</td>
                        <td class="center">{{quantity_32}}</td>
                        <td class="center">{{consumed_32}}</td>
                        <td class="center">{{balance_32}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_33}}</td>
                        <td class="center">{{stock_number_33}}</td>
                        <td class="left">{{supply_name_33}}</td>
                        <td class="center">{{unit_33}}</td>
                        <td class="center">{{quantity_33}}</td>
                        <td class="center">{{consumed_33}}</td>
                        <td class="center">{{balance_33}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_34}}</td>
                        <td class="center">{{stock_number_34}}</td>
                        <td class="left">{{supply_name_34}}</td>
                        <td class="center">{{unit_34}}</td>
                        <td class="center">{{quantity_34}}</td>
                        <td class="center">{{consumed_34}}</td>
                        <td class="center">{{balance_34}}</td>
                    </tr>
                    <tr>
                        <td class="center">{{date_received_35}}</td>
                        <td class="center">{{stock_number_35}}</td>
                        <td class="left">{{supply_name_35}}</td>
                        <td class="center">{{unit_35}}</td>
                        <td class="center">{{quantity_35}}</td>
                        <td class="center">{{consumed_35}}</td>
                        <td class="center">{{balance_35}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    </div>
</body>
</html>