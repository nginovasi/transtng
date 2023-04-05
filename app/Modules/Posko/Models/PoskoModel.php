<?php

namespace App\Modules\Posko\Models;

use App\Core\BaseModel;
use LDAP\Result;
use Mpdf\Tag\Q;

class PoskoModel extends BaseModel
{
	// get all facilities
	public function getFacilities()
	{
		return $this->db->query("SELECT * 
									from m_facilities
									where is_deleted = 0")->getResult();
	}

	// save armada mudik
	public function saveFasilitas($facilitiesDatas, $deleted, $role_id, $data, callable $callback = NULL)
	{
		$this->db->transBegin();
		unset($data['check']);
		unset($data['armada_mudik_id']);
		unset($data['facilities_id']);

		$id = "";

		if ($data['id'] == "") {
			$data['created_by'] = $this->session->get('id');

			$result = parent::base_insertRID($data, 'm_armada_mudik');
		} else {
			$id = $data['id'];
			$data['last_edited_at'] = date('Y-m-d H:i:s');
			$data['last_edited_by'] = $this->session->get('id');
			unset($data['id']);

			parent::base_update($data, 'm_armada_mudik', array('id' => $id));

			$result = $id;
		}

		foreach ($deleted as $deleted_id) {
			$this->db->query("delete from m_armada_mudik_fasilities where armada_mudik_id = " . $result . " and facilities_id = " . $deleted_id['facilities_id']);
		}

		foreach ($facilitiesDatas as $facilitiesData) {
			$this->db->query("insert into m_armada_mudik_fasilities 
								(armada_mudik_id, facilities_id) 
								VALUES (" . $result . "," . $facilitiesData['facilities_id'] . ")
								ON DUPLICATE KEY UPDATE armada_mudik_id = values(armada_mudik_id), facilities_id = values(facilities_id)
								");
		}

		if ($this->db->transStatus() === FALSE) {
			$this->db->transRollback();
			$this->db->transComplete();
			return false;
		} else {
			$this->db->transCommit();
			$this->db->transComplete();
			return true;
		}
	}

	// function get number of A1 = 1, A2 = 2 ... A10 = 10
	function get_number($input)
	{
		$input = preg_replace('/[^0-9]/', '', $input);

		return $input == '' ? '1' : $input;
	}

	// save jadwal
	public function saveJadwal($idUser, $data, callable $callback = NULL)
	{
		$this->db->transBegin();

		$id = "";

		// insert data jadwal mudik
		if ($data['id'] == "") {
			// data created by user login
			$data['created_by'] = $idUser;

			// insert jadwal mudik
			$result = parent::base_insertRID($data, 't_jadwal_mudik');

			// get data seat map bus template
			$mapDetails = $this->db->query("SELECT c.*
												FROM m_armada_mudik a
												JOIN m_seat_map b
												ON a.armada_sheet_id = b.id
												JOIN m_seat_map_detail c
												ON b.id = c.seat_map_id
												WHERE a.id = " . $data['jadwal_armada_id'] . "
											")->getResult();

			// insert data seat jadwal mudik per bis
			$seatMapDetail = [];
			foreach ($mapDetails as $mapDetail) {
				$seatMapDetail[] = [
					"jadwal_id" => $result,
					"seat_map_id" => $mapDetail->seat_map_id,
					"seat_map_detail_name" => $mapDetail->seat_map_detail_name,
					"seat_group_baris" => $this->get_number($mapDetail->seat_map_detail_name)
				];
			}

			parent::base_insertBatch($seatMapDetail, 't_jadwal_seat_mudik');
		} else {
			// update data jadwal mudik
			// not update armada mudik, because exist relation on seat map detail bis 

			$id = $data['id'];
			$data['last_edited_at'] = date('Y-m-d H:i:s');
			$data['last_edited_by'] = $this->session->get('id');
			unset($data['id']);

			parent::base_update($data, 't_jadwal_mudik', array('id' => $id));
		}

		if ($this->db->transStatus() === FALSE) {
			$this->db->transRollback();
			$this->db->transComplete();
			return false;
		} else {
			$this->db->transCommit();
			$this->db->transComplete();
			return true;
		}
	}

	// save paguyuban mudik
	public function savePaguyuban($role_id, $data, callable $callback = NULL)
	{
		$this->db->transBegin();

		// loop seat bis
		for ($i = 0; $i < count($data['paguyuban_tempat_duduk']); $i++) {
			// cek paguyuban detail exist
			$paguyubanDetail = $this->db->query("SELECT * 
													FROM t_paguyuban_mudik_detail 
													WHERE jadwal_seat_mudik_id = " . $data['paguyuban_tempat_duduk_id'][$i])->getRow();

			// if paguyuban mudik detail not exist
			if (!$paguyubanDetail) {
				// cek email registered on mitra darat mobile
				$cekEmail = "";
				if (@$data['paguyuban_email' . $i] != null) {
					$cekEmail = $this->db->query("SELECT * 
													FROM m_user_mobile 
													WHERE id = " . "'" . $data['paguyuban_email' . $i] . "'")->getRow();
				}

				// post and get id transansaction
				$resultTransaction = "";
				if (!empty($cekEmail)) {
					// cek billing exist by jadwal and id user
					$billings = $this->db->query("SELECT * 
													FROM t_billing_mudik 
													WHERE billing_jadwal_id = " . $data['jadwal_mudik_id'] . " 
													AND billing_user_id = " . $cekEmail->id . "
													AND billing_status_payment = 1
													AND billing_cancel = 0
													AND billing_status_verif = 1")->getRow();

					// if billing not exist, so insert billing
					if (!$billings) {
						// cek promo
						$promo = $this->db->query("SELECT *
													FROM m_promo_mudik
													WHERE promo_active = 1
													ORDER BY id DESC")->getRow();

						// cek type jadwal
						$typeJadwal = $this->db->query("SELECT *
															FROM t_jadwal_mudik
															WHERE id = " . $data['jadwal_mudik_id'])->getRow();

						// cek verifikasi mudik
						$verifyMudik = $this->db->query("SELECT *
															FROM s_config_verifikasi_mudik
															WHERE arus = " . $typeJadwal->jadwal_type)->getRow();

						$billing = [
							"billing_qty" => 1,
							"billing_jadwal_id" => $data['jadwal_mudik_id'],
							"biliing_amount" => 0,
							"billing_user_id" => $cekEmail->id,
							"billing_promo_code" => $promo->promo_code,
							"billing_expired_date" => date("Y-m-d H:i:s"),
							"billing_payment_date" => date("Y-m-d H:i:s"),
							"billing_is_paguyuban" => 1,
							"billing_verif_expired_date" => date("Y-m-d", strtotime($verifyMudik->max_date_expired)),
							"billing_status_payment" => 1,
							"billing_status_verif" => 1,	
							"billing_date_verif" => date("Y-m-d H:i:s")
						];

						// insert billing
						$resultBilling = parent::base_insertRID($billing, 't_billing_mudik');

						// get data billing after insert
						$getBillingCode = $this->db->query("SELECT * 
															FROM t_billing_mudik
															WHERE id = " . $resultBilling . "")->getRow();

						if ($getBillingCode) {
							$transactionMudik = [
								"billing_id" => $resultBilling,
								"billing_code" => $getBillingCode->billing_code,
								"transaction_seat_id" => $data['paguyuban_tempat_duduk_id'][$i],
								"transaction_amount" => 0,
								"transaction_nik" => $data['paguyuban_no_ktp'][$i],
								"transaction_booking_name" => $data['paguyuban_name'][$i],
								"is_verified" => 1,
								"verified_by" => $this->session->get('id'),
								"verified_at" => date("Y-m-d H:i:s")
							];

							// insert transaction
							$resultTransaction = parent::base_insertRID($transactionMudik, 't_transaction_mudik');
						}
					} else {
						// update qty billing
						$billing = $this->db->query("UPDATE t_billing_mudik 
														SET billing_qty = billing_qty + 1 
														where billing_jadwal_id = " . $data['jadwal_mudik_id'] . " 
														AND billing_user_id = " . $cekEmail->id . "
														AND billing_status_payment = 1
														AND billing_cancel = 0
														AND billing_status_verif = 1");

						// get data billing (same sql)
						$getBillingCode = $this->db->query("SELECT * 
															FROM t_billing_mudik
															WHERE billing_jadwal_id = " . $data['jadwal_mudik_id'] . "
															AND billing_user_id = " . $cekEmail->id . "
															AND billing_status_payment = 1
															AND billing_cancel = 0
															AND billing_status_verif = 1
															")->getRow();

						if ($getBillingCode) {
							$transactionMudik = [
								"billing_id" => $getBillingCode->id,
								"billing_code" => $getBillingCode->billing_code,
								"transaction_seat_id" => $data['paguyuban_tempat_duduk_id'][$i],
								"transaction_amount" => 0,
								"transaction_nik" => $data['paguyuban_no_ktp'][$i],
								"transaction_booking_name" => $data['paguyuban_name'][$i],
								"is_verified" => 1,
								"verified_by" => $this->session->get('id'),
								"verified_at" => date("Y-m-d H:i:s")
							];

							// insert transaction
							$resultTransaction = parent::base_insertRID($transactionMudik, 't_transaction_mudik');
						}
					}
				} else {
					// replace null if check email not registered on mitra darat mobile
					$data['paguyuban_name'][$i] = Null;
					$data['paguyuban_email' . $i] = Null;
					$data['paguyuban_no_wa'][$i] = Null;
					$data['paguyuban_no_ktp'][$i] = Null;
					$data['paguyuban_no_kk'][$i] = Null;
				}

				// update data seat use & transaction, if email not registered on mitra darat mobil, field paguyuban name not null, paguyuban email not null, paguyuban no wa not null, paguyuban no ktp not null, paguyuban no kk not null 
				if (!empty($data['paguyuban_name'][$i]) && @$data['paguyuban_email' . $i] != null && !empty($data['paguyuban_no_wa'][$i]) && !empty($data['paguyuban_no_ktp'][$i]) && !empty($data['paguyuban_no_kk'][$i]) && !empty($cekEmail)) {
					$this->db->query("update t_jadwal_seat_mudik set seat_map_use = 1, transaction_id = " . $resultTransaction . " where id = " . $data['paguyuban_tempat_duduk_id'][$i]);
				} else {
					$this->db->query("update t_jadwal_seat_mudik set seat_map_use = 0 where id = " . $data['paguyuban_tempat_duduk_id'][$i]);
				}

				// data paguyuban detail
				$paguyubans = [
					"paguyuban_mudik_id" => $data['open'] == 0 ? unwrap_null(@$data['paguyuban_mudik_ids' . $i], NULL) : $data['paguyuban_mudik_id'],
					"jadwal_seat_mudik_id" => $data['paguyuban_tempat_duduk_id'][$i],
					"paguyuban_tempat_duduk" => $data['paguyuban_tempat_duduk'][$i],
					"paguyuban_name" => unwrap_null(@$data['paguyuban_name'][$i], "-"),
					"paguyuban_email" => unwrap_null(@$data['paguyuban_email' . $i], "-"),
					"paguyuban_no_wa" => unwrap_null(@$data['paguyuban_no_wa'][$i], "-"),
					"paguyuban_no_ktp" => unwrap_null(@$data['paguyuban_no_ktp'][$i], "-"),
					"paguyuban_no_kk" => unwrap_null(@$data['paguyuban_no_kk'][$i], "-"),
					"created_by" => $this->session->get('id'),
					"created_at" => date("Y-m-d H:i:s"),
				];

				parent::base_insert($paguyubans, 't_paguyuban_mudik_detail');
			} else {
				// cek email registered on mitra darat mobile
				$cekEmail = "";
				if (@$data['paguyuban_email' . $i] != null) {
					$cekEmail = $this->db->query("SELECT * 
													FROM m_user_mobile 
													WHERE id = " . "'" . $data['paguyuban_email' . $i] . "'")->getRow();
				}

				// replace null if check email not registered on mitra darat mobile
				if (empty($cekEmail)) {
					$data['paguyuban_mudik_ids' . $i] = NULL;
					$data['paguyuban_name'][$i] = Null;
					$data['paguyuban_email' . $i] = Null;
					$data['paguyuban_no_wa'][$i] = Null;
					$data['paguyuban_no_ktp'][$i] = Null;
					$data['paguyuban_no_kk'][$i] = Null;
				}

				$paguyubans = [
					"paguyuban_mudik_id" => $data['open'] == 0 ? unwrap_null(@$data['paguyuban_mudik_ids' . $i], NULL) : $data['paguyuban_mudik_id'],
					"jadwal_seat_mudik_id" => $data['paguyuban_tempat_duduk_id'][$i],
					"paguyuban_tempat_duduk" => $data['paguyuban_tempat_duduk'][$i],
					"paguyuban_name" => unwrap_null(@$data['paguyuban_name'][$i], "-"),
					"paguyuban_email" => unwrap_null(@$data['paguyuban_email' . $i], "-"),
					"paguyuban_no_wa" => unwrap_null(@$data['paguyuban_no_wa'][$i], "-"),
					"paguyuban_no_ktp" => unwrap_null(@$data['paguyuban_no_ktp'][$i], "-"),
					"paguyuban_no_kk" => unwrap_null(@$data['paguyuban_no_kk'][$i], "-"),
					"last_edited_at" => date("Y-m-d H:i:s"),
					"last_edited_by" => $this->session->get('id'),
				];

				// update per field paguyuban mudik detail
				parent::base_update($paguyubans, 't_paguyuban_mudik_detail', array('id' => $paguyubanDetail->id));

				// update data transaction paguyuban when email mobile mitra darat exist
				$resultTransaction = "";
				if (!empty($cekEmail)) {
					// cek billing exist
					$billings = $this->db->query("SELECT * 
													FROM t_billing_mudik 
													WHERE billing_jadwal_id = " . $data['jadwal_mudik_id'] . " 
													AND billing_user_id = " . $cekEmail->id . "
													AND billing_status_payment = 1
													AND billing_cancel = 0
													AND billing_status_verif = 1")->getRow();

					// if billing not exist, so insert
					if (!$billings) {
						// cek promo
						$promo = $this->db->query("SELECT *
													FROM m_promo_mudik
													WHERE promo_active = 1
													ORDER BY id DESC")->getRow();

						// cek type jadwal
						$typeJadwal = $this->db->query("SELECT *
															FROM t_jadwal_mudik
															WHERE id = " . $data['jadwal_mudik_id'])->getRow();

						// cek verifikasi mudik
						$verifyMudik = $this->db->query("SELECT *
															FROM s_config_verifikasi_mudik
															WHERE arus = " . $typeJadwal->jadwal_type)->getRow();

						$billing = [
							"billing_qty" => 1,
							"billing_jadwal_id" => $data['jadwal_mudik_id'],
							"biliing_amount" => 0,
							"billing_user_id" => $cekEmail->id,
							"billing_promo_code" => $promo->promo_code,
							"billing_expired_date" => date("Y-m-d H:i:s"),
							"billing_payment_date" => date("Y-m-d H:i:s"),
							"billing_is_paguyuban" => 1,
							"billing_verif_expired_date" => date("Y-m-d", strtotime($verifyMudik->max_date_expired)),
							"billing_status_payment" => 1,
							"billing_status_verif" => 1,
							"billing_status_verif" => 1,
							"billing_date_verif" => date("Y-m-d H:i:s")
						];

						// insert billing
						$resultBilling = parent::base_insertRID($billing, 't_billing_mudik');

						// get data billing
						$getBillingCode = $this->db->query("select * 
															from t_billing_mudik
															where id = " . $resultBilling . "")->getRow();

						if ($getBillingCode) {
							$transactionMudik = [
								"billing_id" => $resultBilling,
								"billing_code" => $getBillingCode->billing_code,
								"transaction_seat_id" => $data['paguyuban_tempat_duduk_id'][$i],
								"transaction_amount" => 0,
								"transaction_nik" => $data['paguyuban_no_ktp'][$i],
								"transaction_booking_name" => $data['paguyuban_name'][$i],
								"is_verified" => 1,
								"verified_by" => $this->session->get('id'),
								"verified_at" => date("Y-m-d H:i:s")
							];

							// insert transaction
							parent::base_insertRID($transactionMudik, 't_transaction_mudik');
						}
					} else {
						// get data transaction
						$getTrasaction = $this->db->query("SELECT * 
															FROM t_transaction_mudik
															WHERE billing_id = $billings->id
															AND billing_code = " . "'" . $billings->billing_code . "'" . "
															AND transaction_seat_id = " . "'" . $data['paguyuban_tempat_duduk_id'][$i] . "'" . "
															")->getRow();


						$transactionMudik = [
							"billing_id" => $billings->id,
							"billing_code" => $billings->billing_code,
							"transaction_seat_id" => $data['paguyuban_tempat_duduk_id'][$i],
							"transaction_amount" => 0,
							"transaction_nik" => $data['paguyuban_no_ktp'][$i],
							"transaction_booking_name" => $data['paguyuban_name'][$i]
						];

						// update if exist									
						if ($getTrasaction) {
							parent::base_update($transactionMudik, 't_transaction_mudik', array('id' => $getTrasaction->id));
						} else {
							$resultTransaction = parent::base_insertRID($transactionMudik, 't_transaction_mudik');

							if (!empty($data['paguyuban_name'][$i]) && @$data['paguyuban_email' . $i] != null && !empty($data['paguyuban_no_wa'][$i]) && !empty($data['paguyuban_no_ktp'][$i]) && !empty($data['paguyuban_no_kk'][$i]) && !empty($cekEmail)) {
								$this->db->query("update t_jadwal_seat_mudik set seat_map_use = 1, transaction_id = " . $resultTransaction . " where id = " . $data['paguyuban_tempat_duduk_id'][$i]);
							} else {
								$this->db->query("update t_jadwal_seat_mudik set seat_map_use = 0, transaction_id = NULL where id = " . $data['paguyuban_tempat_duduk_id'][$i]);
							}

							// update qty billing
							$billing = $this->db->query("update t_billing_mudik 
															set billing_qty = billing_qty + 1
															where billing_jadwal_id = " . $data['jadwal_mudik_id'] . " 
															and billing_user_id = " . $cekEmail->id . "
															AND billing_status_payment = 1
															AND billing_cancel = 0
															AND billing_status_verif = 1");
						}
					}
				} else {
					// set data paguyuban detail when delete
					$paguyubandel = [
						"paguyuban_mudik_id" => NULL,
						"jadwal_seat_mudik_id" => $data['paguyuban_tempat_duduk_id'][$i],
						"paguyuban_tempat_duduk" => $data['paguyuban_tempat_duduk'][$i],
						"paguyuban_name" => "-",
						"paguyuban_email" => "-",
						"paguyuban_no_wa" => "-",
						"paguyuban_no_ktp" => "-",
						"paguyuban_no_kk" => "-",
						"last_edited_by" => $this->session->get('id'),
						"last_edited_at" => date("Y-m-d H:i:s"),
					];

					// update paguyuban detail when delete
					parent::base_update($paguyubandel, 't_paguyuban_mudik_detail', array('jadwal_seat_mudik_id' => $data['paguyuban_tempat_duduk_id'][$i]));

					// get transaction when delete
					$transactiondel = $this->db->query("SELECT * 
														FROM t_transaction_mudik
														WHERE transaction_seat_id = " . $data['paguyuban_tempat_duduk_id'][$i])->getRow();

					if ($transactiondel) {
						// update transaction mudik when delete
						$this->db->query('update t_transaction_mudik 
											set transaction_seat_id = NULL
											where transaction_seat_id = ' . $data['paguyuban_tempat_duduk_id'][$i]);

						$this->db->query("update t_billing_mudik 
											set billing_qty = billing_qty - 1
											where id = " . $transactiondel->billing_id);
					}
				}
			}
		}

		if ($this->db->transStatus() === FALSE) {
			$this->db->transRollback();
			$this->db->transComplete();
			return false;
		} else {
			$this->db->transCommit();
			$this->db->transComplete();
			return true;
		}
	}

	// change seat
	public function changeSeat($role_id, $id, $seat, $use, callable $callback = NULL)
	{
		$this->db->transBegin();

		// get data from original
		$getDataFrom = $this->db->query("select * from t_jadwal_seat_mudik where id = " . $id[0])->getRow();

		// get data seat destination
		$getDataTo = $this->db->query("select * from t_jadwal_seat_mudik where id = " . $id[1])->getRow();

		// change data original from destination
		$dataFrom = [
			"seat_map_use" => $getDataTo->seat_map_use,
			"transaction_id" => $getDataTo->transaction_id,
		];

		// update data original from destination
		parent::base_update($dataFrom, 't_jadwal_seat_mudik', array('id' => $getDataFrom->id));

		// get data destination
		$getDataPaguyubanTo = $this->db->query("select * 
													from t_paguyuban_mudik_detail
													where jadwal_seat_mudik_id = " . $getDataTo->id)->getRow();

		// get data original
		$getDataPaguyubanFrom = $this->db->query("select * 
													from t_paguyuban_mudik_detail
													where jadwal_seat_mudik_id = " . $getDataFrom->id)->getRow();

		if ($getDataPaguyubanTo) {
			// data paguyuban original from destination
			$dataPaguyubanFrom = [
				"paguyuban_mudik_id" => $getDataPaguyubanTo->paguyuban_mudik_id,
				"paguyuban_name" => $getDataPaguyubanTo->paguyuban_name,
				"paguyuban_email" => $getDataPaguyubanTo->paguyuban_email,
				"paguyuban_no_wa" => $getDataPaguyubanTo->paguyuban_no_wa,
				"paguyuban_no_ktp" => $getDataPaguyubanTo->paguyuban_no_ktp,
				"paguyuban_no_kk" => $getDataPaguyubanTo->paguyuban_no_kk
			];

			// update data paguyuban original from destination
			parent::base_update($dataPaguyubanFrom, 't_paguyuban_mudik_detail', array('jadwal_seat_mudik_id' => $getDataFrom->id));
		} else {
			$getDataJadwalSeats = $this->db->query('select * from t_jadwal_seat_mudik where jadwal_id = ' . $getDataTo->jadwal_id)->getResult();

			$paguyubans = [];
			foreach ($getDataJadwalSeats as $getDataJadwalSeat) {
				// data paguyuban detail
				$paguyubans[] = [
					"paguyuban_mudik_id" => NULL,
					"jadwal_seat_mudik_id" => $getDataJadwalSeat->id,
					"paguyuban_tempat_duduk" => $getDataJadwalSeat->seat_map_detail_name,
					"paguyuban_name" => "-",
					"paguyuban_email" => "-",
					"paguyuban_no_wa" => "-",
					"paguyuban_no_ktp" => "-",
					"paguyuban_no_kk" => "-",
					"created_by" => $this->session->get('id'),
					"created_at" => date("Y-m-d H:i:s"),
				];
			}

			parent::base_insertBatch($paguyubans, 't_paguyuban_mudik_detail');

			// get data destination
			$getDataPaguyubanTo = $this->db->query("select * 
														from t_paguyuban_mudik_detail
														where jadwal_seat_mudik_id = " . $getDataTo->id)->getRow();

			if ($getDataPaguyubanTo) {
				// data paguyuban original from destination
				$dataPaguyubanFrom = [
					"paguyuban_mudik_id" => $getDataPaguyubanTo->paguyuban_mudik_id,
					"paguyuban_name" => $getDataPaguyubanTo->paguyuban_name,
					"paguyuban_email" => $getDataPaguyubanTo->paguyuban_email,
					"paguyuban_no_wa" => $getDataPaguyubanTo->paguyuban_no_wa,
					"paguyuban_no_ktp" => $getDataPaguyubanTo->paguyuban_no_ktp,
					"paguyuban_no_kk" => $getDataPaguyubanTo->paguyuban_no_kk
				];

				// update data paguyuban original from destination
				parent::base_update($dataPaguyubanFrom, 't_paguyuban_mudik_detail', array('jadwal_seat_mudik_id' => $getDataFrom->id));
			}
		}

		// change data destination from original
		$dataTo = [
			"seat_map_use" => $getDataFrom->seat_map_use,
			"transaction_id" => $getDataFrom->transaction_id
		];

		// update data destination from original
		parent::base_update($dataTo, 't_jadwal_seat_mudik', array('id' => $getDataTo->id));

		if ($getDataPaguyubanFrom) {
			// data paguyuban destination from original
			$dataPaguyubanTo = [
				"paguyuban_mudik_id" => $getDataPaguyubanFrom->paguyuban_mudik_id,
				"paguyuban_name" => $getDataPaguyubanFrom->paguyuban_name,
				"paguyuban_email" => $getDataPaguyubanFrom->paguyuban_email,
				"paguyuban_no_wa" => $getDataPaguyubanFrom->paguyuban_no_wa,
				"paguyuban_no_ktp" => $getDataPaguyubanFrom->paguyuban_no_ktp,
				"paguyuban_no_kk" => $getDataPaguyubanFrom->paguyuban_no_kk
			];

			// update data destination from original
			parent::base_update($dataPaguyubanTo, 't_paguyuban_mudik_detail', array('jadwal_seat_mudik_id' => $getDataTo->id));
		} else {
			$getDataJadwalSeats = $this->db->query('select * from t_jadwal_seat_mudik where jadwal_id = ' . $getDataFrom->jadwal_id)->getResult();

			$paguyubans = [];
			foreach ($getDataJadwalSeats as $getDataJadwalSeat) {
				// data paguyuban detail
				$paguyubans[] = [
					"paguyuban_mudik_id" => NULL,
					"jadwal_seat_mudik_id" => $getDataJadwalSeat->id,
					"paguyuban_tempat_duduk" => $getDataJadwalSeat->seat_map_detail_name,
					"paguyuban_name" => "-",
					"paguyuban_email" => "-",
					"paguyuban_no_wa" => "-",
					"paguyuban_no_ktp" => "-",
					"paguyuban_no_kk" => "-",
					"created_by" => $this->session->get('id'),
					"created_at" => date("Y-m-d H:i:s"),
				];
			}

			parent::base_insertBatch($paguyubans, 't_paguyuban_mudik_detail');

			// get data original
			$getDataPaguyubanFrom = $this->db->query("select * 
														from t_paguyuban_mudik_detail
														where jadwal_seat_mudik_id = " . $getDataFrom->id)->getRow();

			if ($getDataPaguyubanFrom) {
				// data paguyuban original from destination
				$dataPaguyubanTo = [
					"paguyuban_mudik_id" => $getDataPaguyubanFrom->paguyuban_mudik_id,
					"paguyuban_name" => $getDataPaguyubanFrom->paguyuban_name,
					"paguyuban_email" => $getDataPaguyubanFrom->paguyuban_email,
					"paguyuban_no_wa" => $getDataPaguyubanFrom->paguyuban_no_wa,
					"paguyuban_no_ktp" => $getDataPaguyubanFrom->paguyuban_no_ktp,
					"paguyuban_no_kk" => $getDataPaguyubanFrom->paguyuban_no_kk
				];

				// update data destination from original
				parent::base_update($dataPaguyubanTo, 't_paguyuban_mudik_detail', array('jadwal_seat_mudik_id' => $getDataTo->id));
			}
		}

		$transactionTo = $this->db->query("SELECT a.*, b.*
												FROM t_jadwal_seat_mudik a
												LEFT JOIN t_transaction_mudik b
													ON a.transaction_id = b.id
												WHERE a.id = " . $id[0])->getRow();

		$transactionFrom = $this->db->query("SELECT a.*, b.*
												FROM t_jadwal_seat_mudik a
												LEFT JOIN t_transaction_mudik b
													ON a.transaction_id = b.id
												WHERE a.id = " . $id[1])->getRow();

		if($transactionTo->transaction_id != null) {
			$dataTo = [
				"transaction_seat_id" => $id[0]
			];

			parent::base_update($dataTo, 't_transaction_mudik', array('id' => $transactionTo->transaction_id));
		}

		if($transactionFrom->transaction_id != null) {
			$dataTo = [
				"transaction_seat_id" => $id[1]
			];

			parent::base_update($dataTo, 't_transaction_mudik', array('id' => $transactionFrom->transaction_id));
		}

		if ($this->db->transStatus() === FALSE) {
			$this->db->transRollback();
			$this->db->transComplete();
			return false;
		} else {
			$this->db->transCommit();
			$this->db->transComplete();
			return true;
		}
	}

	public function verifikasimudik_export($filter)
	{
		$data_explode = explode(".", $filter);
		$billing_code = $data_explode[0];
		$id = $data_explode[1];

		

		$query = "SELECT a.id, a.transaction_booking_name AS nama, a.transaction_nik AS nik, a.transaction_number, a.billing_code AS booking_code, a.transaction_seat_id, a.is_verified, SHA1(a.transaction_number) AS transaction_number_hash,
		b.billing_qty AS jumlah_penumpang, 
		concat(DATE_FORMAT(d.jadwal_date_depart, '%d-%m-%Y'),' / ', d.jadwal_time_depart) AS jadwal_keberangkatan, concat(d.jadwal_date_arrived, ' ', d.jadwal_time_arrived) AS jadwal_balik,
		e.route_name AS lokasi_keberangkatan, e.route_from, e.route_to,
		f.armada_code AS no_bus
		FROM t_transaction_mudik a
		JOIN t_billing_mudik b ON b.id = a.billing_id
		JOIN t_jadwal_seat_mudik c ON c.id = a.transaction_seat_id
		JOIN t_jadwal_mudik d ON d.id = c.jadwal_id
		JOIN m_route e ON e.id = d.jadwal_route_id
		JOIN m_armada_mudik f ON f.id = d.jadwal_armada_id
		WHERE a.is_verified = '1' AND a.id = '" . base64_decode($data_explode['1']) . "' AND a.billing_code = '" . base64_decode($data_explode['0']) . "'";

		return $this->db->query($query)->getRow();
	}
	public function verifikasimudikcetak_export($filter)
	{
		$data = explode(".", $filter);
		$dateStart = $data[0];
		$dateEnd = $data[1];
		$is_verif = $data[2];
		$verified_by = $this->session->get('id');
		// $query = "SELECT b.user_web_name AS verifikator, a.transaction_booking_name, a.transaction_nik, a.transaction_seat_id, a.transaction_number, DATE_FORMAT(a.verified_at, '%d-%m-%Y') AS verified_at, a.reject_verified_reason, e.route_from, e.route_to, 
		// CASE WHEN is_verified = 1 THEN 'Verified'
		// WHEN is_verified = 2 THEN 'Rejected'
		// END AS STATUS
		// FROM t_transaction_mudik a
		// INNER JOIN m_user_web b ON b.id = a.verified_by
		// LEFT JOIN t_jadwal_seat_mudik c ON c.id = a.transaction_seat_id
		// LEFT JOIN t_jadwal_mudik d ON d.id = c.jadwal_id
		// LEFT JOIN m_route e ON e.id = d.jadwal_route_id
		// LEFT JOIN m_armada_mudik f ON f.id = d.jadwal_armada_id
		// WHERE is_verified IN (1,2) AND DATE(verified_at) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "'";
		if (base64_decode($is_verif) == 0 ){
			$where = " a.is_verified='" . base64_decode($is_verif) . "' AND DATE(a.created_at) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "' ORDER BY (a.transaction_booking_name) ASC limit 500";
		} else {
			$where = " a.is_verified='" . base64_decode($is_verif) . "' AND DATE(a.verified_at) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "' ORDER BY (a.transaction_booking_name) ASC limit 500";
		}
		$query = "SELECT a.created_at, b.user_web_name AS verifikator, a.transaction_booking_name, a.transaction_nik, a.transaction_seat_id, a.transaction_number, a.is_verified, DATE_FORMAT(a.verified_at, '%d-%m-%Y') AS verified_at, DATE_FORMAT(a.verified_at, '%H:%i:%s') AS waktu_verif , a.reject_verified_reason, e.route_from, e.route_to, 
		CASE WHEN is_verified = 1 THEN 'Verified'
		WHEN is_verified = 2 THEN 'Rejected'
		WHEN is_verified = 0 THEN 'Belum Verif' 
		END AS STATUS
		FROM t_transaction_mudik a
		LEFT JOIN m_user_web b ON b.id = a.verified_by
		LEFT JOIN t_jadwal_seat_mudik c ON c.id = a.transaction_seat_id 
		LEFT JOIN t_jadwal_mudik d ON d.id = c.jadwal_id
		LEFT JOIN m_route e ON e.id = d.jadwal_route_id
     	LEFT JOIN m_armada_mudik f ON f.id = d.jadwal_armada_id
		WHERE $where";
		// -- ORDER BY a.transaction_booking_name ASC ";
		// WHERE is_verified='" . base64_decode($is_verif) . "'  AND a.transaction_seat_id IS NOT NULL AND DATE(a.created_at) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "' limit 500";
		// WHERE is_verified IN (1,2) AND DATE(verified_at) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "' AND verified_by='" . $verified_by . "'";
		return $this->db->query($query)->getResult();
	}

	public function verifikasikendaraanmudikcetak_export($filter)
	{
		$data = explode(".", $filter);
		$dateStart = $data[0];
		$dateEnd = $data[1];
		$is_verif = $data[2];
		$verified_by = $this->session->get('id');
		if (base64_decode($is_verif) == 0 ){
			$where = " a.motis_status_verif='" . base64_decode($is_verif) . "' AND DATE(a.created_at) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "' limit 500;";
		} else {
			$where = " a.motis_status_verif='" . base64_decode($is_verif) . "' AND DATE(a.motis_date_verif) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "' limit 500;";
		}
		$query = "SELECT a.motis_user_id, b.user_mobile_name, a.motis_code, DATE_FORMAT(a.motis_date_verif, '%d-%m-%Y') AS motis_date_verif, c.nik_pendaftar_kendaraan, c.no_kendaraan, c.no_stnk_kendaraan, c.jenis_kendaraan, e.route_from, e.route_to,
		CASE WHEN motis_status_verif = 1 THEN 'Verified'
		WHEN motis_status_verif = 2 THEN 'Rejected'
		WHEN motis_status_verif = 0 THEN 'Belum Verifikasi'
		END AS STATUS
		FROM t_billing_motis_mudik a
		LEFT JOIN m_user_mobile b ON b.id = a.motis_user_id
		LEFT JOIN t_motis_manifest_mudik c ON c.motis_billing_code = a.motis_code 
		LEFT JOIN t_jadwal_motis_mudik d ON d.id = a.motis_jadwal_id
		LEFT JOIN m_route e ON e.id = d.jadwal_route_id
		WHERE $where";
		//  WHERE motis_status_verif='" . base64_decode($is_verif) . "'AND DATE(motis_date_verif) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "'";
		 // WHERE motis_status_verif IN (1,2) AND DATE(motis_date_verif) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "'";
		 // WHERE is_verified IN (1,2) AND DATE(verified_at) BETWEEN '" . base64_decode($dateStart) . "' AND '" . base64_decode($dateEnd) . "' AND verified_by='" . $verified_by . "'";

		return $this->db->query($query)->getResult();
	}
	
	public function verifikasipesertamudik_export($filter)
	{
		$data_explode = explode(".", $filter);
		$billing_code = $data_explode[0];
		$id = $data_explode[1];
		// $query = "SELECT a.id, d.trayek_name, a.no_spda, a.tgl_spda, b.nama_pengemudi, c.armada_code, a.ritase_spda, a.jrk_tempuh_spda, a.wkt_tempuh_spda, a.bbm_spda, c.armada_kapasitas, a.ttl_penumpang_spda, a.ttl_pdptan_spda,
		// form_spda_ttd_pengemudi, form_spda_ttd_manager, form_spda_nama_manager
		// FROM t_form_spda a
		// LEFT JOIN m_driver b ON b.id = a.driver_spda
		// LEFT JOIN m_armada c ON c.id = a.kd_bus_spda 
		//  LEFT JOIN m_trayek d ON d.id = a.trayek_id
		// WHERE a.is_deleted = 0 AND a.id='" . base64_decode($data_explode['1']) . "' AND a.no_spda='" . base64_decode($data_explode['0']) . "' ";
		$query = "SELECT a.id, a.transaction_booking_name AS nama, a.transaction_nik AS nik, a.transaction_number, a.billing_code AS booking_code, a.transaction_seat_id, a.is_verified, SHA1(a.transaction_number) AS transaction_number_hash,
		b.billing_qty AS jumlah_penumpang, 
		concat(d.jadwal_date_depart,' ', d.jadwal_time_depart) AS jadwal_keberangkatan, concat(d.jadwal_date_arrived, ' ', d.jadwal_time_arrived) AS jadwal_balik,
		e.route_name AS lokasi_keberangkatan, e.route_from, e.route_to,
		f.armada_code AS no_bus
		FROM t_transaction_mudik a
		JOIN t_billing_mudik b ON b.id = a.billing_id
		JOIN t_jadwal_seat_mudik c ON c.id = a.transaction_seat_id
		JOIN t_jadwal_mudik d ON d.id = c.jadwal_id
		JOIN m_route e ON e.id = d.jadwal_route_id
		JOIN m_armada_mudik f ON f.id = d.jadwal_armada_id
		WHERE a.is_verified = '1' AND a.id = '" . base64_decode($data_explode['1']) . "' AND a.billing_code = '" . base64_decode($data_explode['0']) . "'";
		
		return $this->db->query($query)->getRow();
	}

	public function verifikasikendaraanmudik_export($filter)
	{
		$data_explode = explode(".", $filter);

		$query = "SELECT DISTINCT  b.id, g.transaction_booking_name AS user_mobile_name, a.nik_pendaftar_kendaraan, a.motis_billing_code, a.nama_pemilik_kendaraan, e.route_name, DATE_FORMAT(d.jadwal_date_depart, '%d-%m-%Y') AS jadwal_date_depart , d.jadwal_time_depart, e.route_from, e.route_to, a.no_kendaraan, SHA1(a.motis_billing_code) AS motis_billing_hash, d.jadwal_type, f.armada_name,f.armada_code
		FROM t_motis_manifest_mudik a
	   LEFT JOIN t_billing_motis_mudik b ON b.id = a.motis_billing_id
	   LEFT JOIN m_user_mobile c ON c.id = b.motis_user_id
	   LEFT JOIN t_jadwal_motis_mudik d ON d.id = b.motis_jadwal_id
	   LEFT JOIN m_route e ON e.id = d.jadwal_route_id
	   LEFT JOIN m_armada_motis_mudik f ON f.id = b.motis_armada_id
	   LEFT JOIN t_transaction_mudik g ON g.transaction_nik = a.nik_pendaftar_kendaraan
	   WHERE b.motis_status_verif = '1' AND b.id = '" . base64_decode($data_explode['1']) . "' AND a.motis_billing_code = '" . base64_decode($data_explode['0']) . "'";

		return $this->db->query($query)->getRow();
	}
	public function verifikasikedatangankendaraanmudik_export($filter)
	{
		$data_explode = explode(".", $filter);

		$query = "SELECT b.id, c.user_mobile_name, a.nik_pendaftar_kendaraan, a.motis_billing_code, e.route_name, d.jadwal_date_depart, d.jadwal_time_depart, e.route_from, e.route_to, a.no_kendaraan, SHA1(a.motis_billing_code) AS motis_billing_hash, d.jadwal_type, f.armada_name,f.armada_code
		FROM t_motis_manifest_mudik a
		JOIN t_billing_motis_mudik b ON b.id = a.motis_billing_id
		JOIN m_user_mobile c ON c.id = b.motis_user_id
		JOIN t_jadwal_motis_mudik d ON d.id = b.motis_jadwal_id
		JOIN m_route e ON e.id = d.jadwal_route_id
		JOIN m_armada_motis_mudik f ON f.id = b.motis_armada_id
		WHERE b.motis_status_verif = '1' AND b.id = '" . base64_decode($data_explode['1']) . "' AND a.motis_billing_code = '" . base64_decode($data_explode['0']) . "'";

		return $this->db->query($query)->getRow();
	}

	// save paguyuban motis
	public function savePaguyubanMotis($user_id, $data, callable $callback = NULL)
	{
		$this->db->transBegin();

		$countNo = count($data['no']);

		for($i = 0; $i < $countNo; $i++) {
			if(@$data['email'][$i] != null) {
				if($data['billing_id'][$i] == "") {
					$jadwalMotis = $this->db->query("SELECT b.*
														FROM t_jadwal_motis_mudik a
														JOIN m_route b
														ON a.jadwal_route_id = b.id
														WHERE a.id = " . $data['jadwal_mudik_id'] . "
														AND b.is_deleted = 0")->getRow();

					$jadwalMotisBalik = $this->db->query("SELECT b.* 
															FROM m_route a
															JOIN t_jadwal_motis_mudik b
																ON a.id = b.jadwal_route_id
															WHERE a.terminal_from_id = " . $jadwalMotis->terminal_to_id . "
															AND a.terminal_to_id = " . $jadwalMotis->terminal_from_id . "
															AND a.is_deleted = 0")->getRow();

					$cekUserBilling = $this->db->query("SELECT *
														FROM t_billing_mudik
														WHERE billing_user_id = " . $data['email'][$i] . "
														AND billing_status_payment = 1")->getRow();

					// arus mudik									
					$paguyuban_motis = [
						"motis_jadwal_id" => $data['jadwal_mudik_id'],
						"motis_amount" => 0,
						"motis_user_id" => $data['email'][$i],
						"motis_armada_id" => NULL,
						"motis_status_payment" => 1,
						"motis_cancel" => 0,
						"motis_is_paguyuban" => 1,
						"motis_verif_expired_date" => $cekUserBilling->billing_verif_expired_date
					];

					$resultBilling = parent::base_insertRID($paguyuban_motis, 't_billing_motis_mudik');

					$getBilling = $this->db->query("SELECT * 
													FROM t_billing_motis_mudik
													WHERE id = " . $resultBilling)->getRow();

					$motis = [
						"motis_billing_id" => $resultBilling,
						"motis_billing_code" => $getBilling->motis_code,
						"no_kendaraan" => $data["no_kendaraan"][$i],
						"jenis_kendaraan" => $data["jenis_kendaraan"][$i],
						"no_stnk_kendaraan" => $data["no_stnk_kendaraan"][$i],
						"nik_pendaftar_kendaraan" => $data["nik_pendaftar_kendaraan"][$i],
						"foto_kendaraan" => $data["foto_kendaraan"][$i],
						"foto_stnk" => $data["foto_stnk"][$i],
						"foto_ktp" => $data["foto_ktp"][$i],
						"date_created" => date("Y-m-d H:i:s")
					];

					parent::base_insert($motis, 't_motis_manifest_mudik');

					// arus balik
					if($jadwalMotisBalik) {
						$paguyuban_motisbalik = [
							"motis_jadwal_id" => $jadwalMotisBalik->id,
							"motis_amount" => 0,
							"motis_user_id" => $data['email'][$i],
							"motis_armada_id" => NULL,
							"motis_status_payment" => 1,
							"motis_cancel" => 0,
							"motis_is_paguyuban" => 1,
							"motis_verif_expired_date" => $cekUserBilling->billing_verif_expired_date
						];
	
						$resultBillingMudikBalik = parent::base_insertRID($paguyuban_motisbalik, 't_billing_motis_mudik');

						$getBillingMudik = $this->db->query("SELECT * 
													FROM t_billing_motis_mudik
													WHERE id = " . $resultBillingMudikBalik)->getRow();

						$motisBalik = [
							"motis_billing_id" => $resultBillingMudikBalik,
							"motis_billing_code" => $getBillingMudik->motis_code,
							"no_kendaraan" => $data["no_kendaraan"][$i],
							"jenis_kendaraan" => $data["jenis_kendaraan"][$i],
							"no_stnk_kendaraan" => $data["no_stnk_kendaraan"][$i],
							"nik_pendaftar_kendaraan" => $data["nik_pendaftar_kendaraan"][$i],
							"foto_kendaraan" => $data["foto_kendaraan"][$i],
							"foto_stnk" => $data["foto_stnk"][$i],
							"foto_ktp" => $data["foto_ktp"][$i],
							"date_created" => date("Y-m-d H:i:s")
						];

						parent::base_insert($motisBalik, 't_motis_manifest_mudik');
					}
				} else {
					$jadwalMotis = $this->db->query("SELECT b.*
														FROM t_jadwal_motis_mudik a
														JOIN m_route b
														ON a.jadwal_route_id = b.id
														WHERE a.id = " . $data['jadwal_mudik_id'] . "
														AND b.is_deleted = 0")->getRow();
					
					$jadwalMotisBalik = $this->db->query("SELECT d.* 
															FROM m_route a
															JOIN t_jadwal_motis_mudik b
															ON a.id = b.jadwal_route_id
															LEFT JOIN t_billing_motis_mudik c
															ON b.id = c.motis_jadwal_id
															LEFT JOIN t_motis_manifest_mudik d
															ON c.id = d.motis_billing_id
															WHERE a.terminal_from_id = " . $jadwalMotis->terminal_to_id . "
															AND a.terminal_to_id =  " . $jadwalMotis->terminal_from_id . "
															AND a.is_deleted = 0
															AND c.motis_user_id = " . $data['email'][$i])->getRow();

					$motis = [
						"no_kendaraan" => $data["no_kendaraan"][$i],
						"jenis_kendaraan" => $data["jenis_kendaraan"][$i],
						"no_stnk_kendaraan" => $data["no_stnk_kendaraan"][$i],
						"nik_pendaftar_kendaraan" => $data["nik_pendaftar_kendaraan"][$i],
						"foto_kendaraan" => $data["foto_kendaraan"][$i],
						"foto_stnk" => $data["foto_stnk"][$i],
						"foto_ktp" => $data["foto_ktp"][$i]
					];

					parent::base_update($motis, 't_motis_manifest_mudik', array('motis_billing_id' => $data['billing_id'][$i]));

					if($jadwalMotisBalik) {
						$motisBalik = [
							"no_kendaraan" => $data["no_kendaraan"][$i],
							"jenis_kendaraan" => $data["jenis_kendaraan"][$i],
							"no_stnk_kendaraan" => $data["no_stnk_kendaraan"][$i],
							"nik_pendaftar_kendaraan" => $data["nik_pendaftar_kendaraan"][$i],
							"foto_kendaraan" => $data["foto_kendaraan"][$i],
							"foto_stnk" => $data["foto_stnk"][$i],
							"foto_ktp" => $data["foto_ktp"][$i]
						];
	
						parent::base_update($motisBalik, 't_motis_manifest_mudik', array('id' => $jadwalMotisBalik->id));
					}
				}
			}
		}

		if ($this->db->transStatus() === FALSE) {
			$this->db->transRollback();
			$this->db->transComplete();
			return false;
		} else {
			$this->db->transCommit();
			$this->db->transComplete();
			return true;
		}
	}

	public function manpaguyubanmudik_export($filter) {
		$jadwal_mudik_id = $filter["jadwal_mudik_id"];
		$paguyuban_mudik_id = $filter["paguyuban_mudik_id"];

		$query = $this->db->query("SELECT b.*, c.transaction_booking_name, d.billing_is_paguyuban, e.paguyuban_mudik_id, f.paguyuban_mudik_name, e.paguyuban_name, e.paguyuban_email, e.paguyuban_no_wa, e.paguyuban_no_ktp, e.paguyuban_no_kk, d.billing_user_id, g.user_mobile_email as 'billing_user_nama'
									FROM t_jadwal_mudik a
									JOIN t_jadwal_seat_mudik b
										ON a.id = b.jadwal_id
									LEFT JOIN t_transaction_mudik c
										ON b.transaction_id = c.id
									LEFT JOIN t_billing_mudik d
										ON c.billing_id = d.id
									LEFT JOIN t_paguyuban_mudik_detail e
										ON b.id = e.jadwal_seat_mudik_id
									LEFT JOIN t_paguyuban_mudik f
										ON e.paguyuban_mudik_id = f.id
									LEFT JOIN m_user_mobile g
										ON d.billing_user_id = g.id
									WHERE a.is_deleted = 0
									AND a.id = " . $jadwal_mudik_id . "")->getResult();

		$paguyuban = $this->db->query("SELECT * 
									FROM t_paguyuban_mudik
									WHERE id = " . $paguyuban_mudik_id)->getRow();

		$jadwal = $this->db->query("SELECT a.id, CONCAT(b.armada_name, ' - ', c.route_name, ' - ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )') as 'text'
										from t_jadwal_mudik a
										join m_armada_mudik b
										on a.jadwal_armada_id = b.id
										JOIN m_route c
										ON a.jadwal_route_id = c.id
										where c.kategori_angkutan_id = 5
										and a.open = 0
										and a.is_deleted = 0
										and a.id = " . $jadwal_mudik_id)->getRow();

		return [
			'seats' => $query,
			'paguyuban' => $paguyuban,
			'jadwal' => $jadwal
		];
	}
}
