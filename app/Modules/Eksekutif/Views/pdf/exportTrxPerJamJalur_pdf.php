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
                    <th class="field">No</th>
                    <th class="field">Tanggal</th>
                    <th class="field">Jam</th>
                    <th class="field">Total</th>
                    <th class="field">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result as $key => $val) { ?>
                    <tr>
                        <td class="field-center"><?= $key + 1 ?></td>
                        <td class="field-center"><?= implode('-', array_reverse(explode('-', $val->tanggal))) ?></td>
                        <td class="field-center"><?= $val->jam . ':00 WIB' ?></td>
                        <td class="field-right"><?= number_format($val->ttl_trx) ?></td>
                        <td class="field-right"><?= number_format($val->jml_trx) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="field-right-foot">Total</td>
                    <td class="field-right-foot"><?= number_format($ttl_trx) ?></td>
                    <td class="field-right-foot"><?= number_format($jml_trx) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    </body>
</html>