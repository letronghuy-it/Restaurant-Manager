<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>hoa-don-tinh-tien</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
        }

        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;
            margin: 0 auto;
            width: 44mm;
            background: #FFF;

        }

        h1 {
            font-size: 1.5em;
            color: #222;
        }

        h2 {
            font-size: .9em;
        }

        h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        p {
            font-size: .7em;
            color: #666;
            line-height: 1.2em;
        }

        #top,
        #mid,
        #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }

        #top {
            min-height: 100px;
        }

        #mid {
            min-height: 80px;
        }

        #bot {
            min-height: 50px;
        }

        #top .logo {
            //float: left;
            height: 60px;
            width: 60px;
            background: url(https://thietkeinan.truongthinh.info/library/module_new/cong-ty-chuyen-thiet-ke-design-logo-nganh-am-thuc-dep-gia-re_s3562.jpg) no-repeat;
            background-size: 60px 60px;
        }

        .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background: url(/logo.jpg) no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
        }

        .info {
            display: block;
            //float:left;
            margin-left: 0;
        }

        .title {
            float: right;
        }

        .title p {
            text-align: right;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        td {
            //padding: 5px 0 5px 15px;
            //border: 1px solid #EEE
        }

        .tabletitle {
            //padding: 5px;
            font-size: .5em;
            background: #EEE;
        }

        .service {
            border-bottom: 1px solid #EEE;
        }

        .item {
            width: 24mm;
        }

        .itemtext {
            font-size: .5em;
        }

        #legalcopy {
            margin-top: 5mm;
        }

        .service:hover {
            background-color: #EEE;
            color: #222;
        }

        .itemtext {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div id="invoice-POS">

        <center id="top">
            <div class="logo"></div>
            <div class="info">
                <h2>Bếp Vàng</h2>
            </div>
            <!--End Info-->
        </center>
        <!--End InvoiceTop-->

        <div id="mid">
            <div class="info">
                <h2>Ngày:{{ $ngay }}</h2>
                <p>
                    Address :32 Xuân Phú,TX.Sông Cầu,Phú Yên</br>
                    Email : hale.02031982@gmail.com</br>
                    Phone : 0983057130</br>
                </p>
            </div>
        </div>
        <!--End Invoice Mid-->

        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item">
                            <h2>Tên</h2>
                        </td>
                        <td class="item">
                            <h2>SL</h2>
                        </td>
                        <td class="item">
                            <h2>ĐG</h2>
                        </td>
                        <td class="item">
                            <h2>CK</h2>
                        </td>
                        <td class="Rate">
                            <h2>TT</h2>
                        </td>
                    </tr>

                    @foreach ($chiTiet as $key => $value)
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">{{ $value->ten_mon_an }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ number_format($value->so_luong_ban, 2) }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ number_format($value->don_gia_ban, 0) }}đ</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ number_format($value->tien_chiet_khau, 0) }}đ</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ number_format($value->thanh_tien, 0) }}đ </p>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
            <!--End Table-->
            <div id="legalcopy">
                <div>
                    <table>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">Tổng tiền:</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ number_format($tong_tien) }}đ</p>
                            </td>
                        </tr>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">Giảm Giá:</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ number_format($giam_gia) }}đ </p>
                            </td>
                        </tr>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">Thực thu:</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">
                                    {{ number_format($thanh_tien) }}đ  <span><i>({{ ucwords($tt_chu) }})</i></span></p>
                            </td>
                        </tr>
                    </table>
                </div>
                <p class="legal"><strong>Cảm ơn quý khách đã ghé thăm nhà hàng chúng tôi!</strong>
                </p>
            </div>

        </div>
        <!--End InvoiceBot-->
    </div>
    <!--End Invoice-->

</body>

</html>
