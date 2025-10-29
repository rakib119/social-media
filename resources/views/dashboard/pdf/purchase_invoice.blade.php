@php
    $payment_for_array = [0 => '', 1 => 'New Package', 2 => 'Renewal Fees'];
    $genarel_infos = DB::table('genarel_infos')->select('field_name', 'value')->get();
    $dataArray = [];
    foreach ($genarel_infos as $v) {
        $dataArray[$v->field_name] = $v->value;
    }
    extract($dataArray);

    $logoPath = public_path('assets/images/info/' . $logo);
    $base64_logo = base64_encode(file_get_contents($logoPath));
    $logo = 'data:image/png;base64,' . $base64_logo;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        *, *:before, *:after {
            box-sizing: border-box;
        }
        body {
            font-family: serif, 'noto_sans_bengali', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .bangla-text, .currency-symbol {
            font-family: 'noto_sans_bengali', serif;
        }

        .invoice-box {
            max-width: 650px;
            width: 100%;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }


        /* .top-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        } */

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #444;
        }

        .company-logo {
            height: 60px;
        }

        .info-table, .items-table, .totals-table, .payment-section-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
        }
        .pdf-header {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
        }
        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .items-table th, .items-table td {
            border: 1px solid #eee;
            padding: 10px;
            text-align: left;
        }

        .items-table th {
            background-color: #f7f7f7;
        }

        .totals-table td {
            padding: 8px;
        }

        .totals-table tr:last-child td {
            font-weight: bold;
            font-size: 16px;
        }

        .text-right {
            text-align: right;
        }

        .section-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .payment-box {
            padding: 10px;
        }

        .footer {
            margin-top: 70px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }

        td[colspan] {
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <table  class="pdf-header">
            <tbody>
                <tr>
                    <td width="60%">
                        <img src="{{ $logo }}" alt="Company Logo" class="company-logo">
                    </td>
                    <td class="text-right">
                        <div class="invoice-title">INV-{{ sprintf('%07d', $data->id) }}</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="info-table">
            <tr>
                <td>
                    <strong>From:</strong><br>
                    Ascentaverse<br>
                    {!! $address !!}<br>
                    <strong>Email:</strong> {{ $email }}
                </td>
                <td class="text-right">
                    <strong>To:</strong><br>
                    {{ $data->purchase_by }}<br>
                    <strong>Code:</strong> {{ $data->verification_code }}<br>
                    <strong>Phone:</strong> {{ $data->phone_number }}<br>
                    <strong>Email:</strong> {{ $data->email }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Invoice #:</strong> INV-{{ sprintf('%07d', $data->id) }}<br>
                    <strong>Date:</strong> {{ $date }}
                </td>
            </tr>
        </table>

        @if ($data->package_mst_id)
            <table class="items-table">
                <tr>
                    <th>Package Name</th>
                    <th>Sub Package Name</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Payment</th>
                </tr>
                <tr>
                    <td>{{ $data->package_name }}</td>
                    <td>{{ $data->sub_package_name }}</td>
                    <td><span class="currency-symbol">BDT </span>{{ number_format($data->package_value, 2) }}</td>
                    <td>{{ $data->discount_per ?? 0 }}%</td>
                    <td><span class="currency-symbol">BDT </span>{{ number_format($data->payment_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4"> <strong>Subtotal:</strong></td>
                    <td><span class="currency-symbol">BDT </span>{{ number_format($data->payment_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4"> <strong>Total:</strong></td>
                    <td><span class="currency-symbol">BDT </span>{{ number_format($data->payment_amount, 2) }}</td>
                </tr>
            </table>
        @else
            <table class="items-table">
                <tr>
                    <th>Payment For</th>
                    <th>Description</th>
                    <th>Payment</th>
                </tr>
                <tr>
                    <td>{{ $payment_for_array[$data->payment_for] }}</td>
                    <td>{{ $data->remarks }}</td>
                    <td><span class="currency-symbol">BDT </span>{{ number_format($data->payment_amount, 2) }}</td>
                </tr>
            </table>
        @endif
        @if ($data->payment_method!=1)
            <table class="payment-section-table">
                <tr>
                    <td width="45%" class="payment-box" v-align="top">
                        <div class="section-title">Payment Sent From</div>
                        <table>
                            <tr>
                                <td><strong>Bank Name</strong></td>
                                <td><strong>:</strong> {{ $data->bank_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Account Holder</strong></td>
                                <td><strong>:</strong> {{ $data->account_holder }}</td>
                            </tr>
                            <tr>
                                <td><strong>Account Number</strong></td>
                                <td><strong>:</strong> {{ $data->account_no }}</td>
                            </tr>
                            <tr>
                                <td><strong>Transaction ID</strong></td>
                                <td><strong>:</strong> {{ $data->transaction_id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date</strong></td>
                                <td><strong>:</strong> {{ $data->created_at }}</td>
                            </tr>
                        </table>
                    </td>
                    <td  class="payment-box" v-align="top">
                        <div class="section-title">Payment Received To</div>
                        <table>
                            <tr>
                                <td><strong>Bank Name</strong></td>
                                <td><strong>:</strong> {{ $data->bank_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Account Number</strong></td>
                                <td><strong>:</strong> {{ $data->company_account_no }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date</strong></td>
                                <td><strong>:</strong> {{ $data->updated_at }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        @endif
        <div class="footer">
            Thank you for your purchase. Please contact us if you have any questions.
        </div>
    </div>

</body>
</html>
