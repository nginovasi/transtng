<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;800&display=swap" rel="stylesheet">

    <style type="text/css">
        .logo {
            float: right;
            width: 80px;
        }

        .header h5 {
            position: relative;
            color: #242732;
        }

		table{
			border-collapse: collapse;
			width: 100%;
		}

		table th, td {
			padding: 6px 8px;
		}

        .field {
            border: 1px solid #555255;
        }

        .field-left {
            border: 1px solid #555255;
            text-align: left;
        }

        .field-center {
            border: 1px solid #555255;
            text-align: center;
        }

        .field-right {
            border: 1px solid #555255;
            text-align: right;
        }

        .field-right-foot {
            border: 1px solid #555255;
            text-align: right;
            font-weight: bold;
        }

	</style>

	<title></title>
</head>
<body>
    <div class="header">
        <img src="<?= base_url() . '/assets/logo_trans_tangerang.png'?>" alt="Logo" class="logo">
        <h5>BRT (BUS RAPID TRANSIT) <br/>
                    <b>TRANS TANGERANG</b><br/>
                    Jl. Borobudur Raya, RT.002/RW.012,<br/>
                    Cibodas Baru, Kec. Cibodas, Kota Tangerang,<br/>
                    Banten 15138, Indonesia</h5>
    </div>

    <div class="title" style="font-weight: bold; font-size: 20px; text-align: center;">
        <h6><?= $title; ?></h6>
    </div>

    <div class="body">
        <table class="table" id="">
            <thead>
                <tr>
                    <th rowspan="2" class="field">No</th>
                    <th rowspan="2" class="field">Pos</th>
                    <th colspan="3" class="field">Shift Pagi</th>
                    <th colspan="3" class="field">Shift Malam</th>
                    <th rowspan="2" class="field">Jumlah</th>
                </tr>
                <tr>
                    <th class="field">Cash</th>
                    <th class="field">Cashless</th>
                    <th class="field">Jumlah</th>
                    <th class="field">Cash</th>
                    <th class="field">Cashless</th>
                    <th class="field">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result as $key => $val) { ?>
                    <tr>
                        <td class="field-center"><?= $key + 1 ?></td>
                        <td class="field-center"><?= $val->name ?></td>
                        <td class="field-right"><?= number_format($val->cashless_shift_pagi) ?></td>
                        <td class="field-right"><?= number_format($val->cash_shift_pagi) ?></td>
                        <td class="field-right"><?= number_format($val->jml_shift_pagi) ?></td>
                        <td class="field-right"><?= number_format($val->cashless_shift_malam) ?></td>
                        <td class="field-right"><?= number_format($val->cash_shift_malam) ?></td>
                        <td class="field-right"><?= number_format($val->jml_shift_malam) ?></td>
                        <td class="field-right"><?= number_format($val->jml) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="field-right-foot">Total</td>
                    <td class="field-right-foot"><?= number_format($ttl_trx_cash_shift_pagi) ?></td>
                    <td class="field-right-foot"><?= number_format($jml_trx_cashless_shift_pagi) ?></td>
                    <td class="field-right-foot"><?= number_format($jml_trx_jml_shift_pagi) ?></td>
                    <td class="field-right-foot"><?= number_format($ttl_trx_cash_shift_malam) ?></td>
                    <td class="field-right-foot"><?= number_format($jml_trx_cashless_shift_malam) ?></td>
                    <td class="field-right-foot"><?= number_format($jml_trx_jml_shift_malam) ?></td>
                    <td class="field-right-foot"><?= number_format($jml_trx_jml) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    </body>
</html>