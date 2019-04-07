<?php
class ModelExtensionSaffwebdhl extends Model {
	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "saffwebdhl` (
		  `saffwebdhl_id` int(11) NOT NULL AUTO_INCREMENT,
		  `order_id` int(11) DEFAULT NULL,
		  `label_title` varchar(255) DEFAULT NULL,
		  `airway_bill_number` varchar(255) DEFAULT NULL,
		  `pdf_label` varchar(255) DEFAULT NULL,
		  `image_label` varchar(255) DEFAULT NULL,
		  `transaction_time` datetime DEFAULT NULL,
		  `package_location` text,
		  `pickup_date` date DEFAULT NULL,
		  `ready_by_time` varchar(10) DEFAULT NULL,
		  `close_time` varchar(10) DEFAULT NULL,
		  `after_hours_closing_time` varchar(10) DEFAULT NULL,
		  `after_hours_location` text,
		  `requestor_contact_name` varchar(255) DEFAULT NULL,
		  `requestor_contact_phone` varchar(255) DEFAULT NULL,
		  `pickup_contact_name` varchar(255) DEFAULT NULL,
		  `pickup_contact_phone` varchar(255) DEFAULT NULL,
		  `booked_shipping` int(11) DEFAULT NULL,
		  `booking_action_note` varchar(255) DEFAULT NULL,
		  `booking_confirmation_number` varchar(100) DEFAULT NULL,
		  `booking_ready_by_time` varchar(10) DEFAULT NULL,
		  `booking_call_in_time` varchar(10) DEFAULT NULL,
		  `modified_pickup` int(11) DEFAULT NULL,
		  `modified_datetime` datetime DEFAULT NULL,
		  `cancelled_pickup` int(11) DEFAULT NULL,
		  `cancelled_datetime` datetime DEFAULT NULL,
		  PRIMARY KEY (`saffwebdhl_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
				
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "saffwebdhl_capability` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`order_id` int(10) UNSIGNED DEFAULT NULL,
			`dhl_product_code` varchar(10) DEFAULT NULL,
			`dhl_local_product` varchar(255) DEFAULT NULL,
			`dhl_product_name` varchar(255) DEFAULT NULL,
			`dhl_network_type_code` varchar(10) DEFAULT NULL,
			`is_dutiable` varchar(10) DEFAULT NULL,
			`selected` int(10) UNSIGNED DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

			
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "saffwebdhl_pieces` (
		`piece_id` int(11) NOT NULL AUTO_INCREMENT,
		`order_id` int(10) UNSIGNED DEFAULT NULL,
		`height` int(10) UNSIGNED DEFAULT NULL,
		`depth` int(10) UNSIGNED DEFAULT NULL,
		`width` int(10) UNSIGNED DEFAULT NULL,
		`weight` varchar(10) DEFAULT NULL,
		PRIMARY KEY (`piece_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

		
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "saffwebdhl_options` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `option_id` int(11) DEFAULT NULL,
		  `option_name` varchar(255) DEFAULT NULL,
		  `option_value` varchar(255) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");



		$this->db->query("INSERT INTO `" . DB_PREFIX . "saffwebdhl_options` (`id`, `option_id`, `option_name`, `option_value`) VALUES (1, 1, 'Shipper', 'S'),(2, 1, 'Receiver', 'R'),(3, 2, 'SSN - Social Security No', 'S'),(4, 2, 'EIN - Employee Identification No', 'E'),(5, 2, 'DUNS', 'D'),(6, 3, 'Receiver', 'R'),(7, 3, 'Sender', 'S'),(8, 3, 'Third Party', 'T'),
		(9, 4, 'PDF', 'PDF'),(10, 4, 'EPL2', 'EPL2'),(11, 4, 'ZPL2', 'ZPL2'),(12, 4, 'LP2', 'LP2'),(13, 5, '6x4', '6X4'),(14, 5, '8x4', '8X4'),(15, 5, '6x4 A4 (only for PDF)', '6X4_A4'),(16, 5, '8x4 A4 (only for PDF)', '8X4_A4'),(17, 6, 'DHL Express Envelope', 'EE'),(18, 6, 'Jumbo Document', 'BD'),(19, 6, 'Jumbo Junior Parcel', 'JP'),(20, 6, 'Jumbo Parcel', 'BP'),(21, 6, 'Jumbo Junior Document', 'JD'),(22, 6, 'Freight', 'FR'),(23, 6, 'Express Document', 'ED'),(24, 6, 'Domestic', 'DM'),(25, 6, 'Document', 'DC'),(26, 6, 'Parcel', 'PA'),(27, 6, 'DHL Flyer', 'DF'),(28, 6, 'Custom Packaging', 'CP'),(29, 6, 'Other DHL Packaging', 'OD'),(30, 6, 'Your Packaging', 'YP'),(31, 7, 'No', 'N'),(32, 7, 'Yes', 'Y'),(33, 8, 'Americas - North America and South-America', 'AM'),(34, 8, 'Europe', 'EU'),(35, 8, 'Asia Pacific, Middle East & Africa', 'AP')");
		



		
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "saffwebdhl_products` (
		`id` int(10) NOT NULL AUTO_INCREMENT,
		`global_product_code` varchar(10) DEFAULT NULL,
		`local_product_code` varchar(10) DEFAULT NULL,
		`dhl_product_name` varchar(255) DEFAULT NULL,
		`network_type_code` varchar(10) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
		
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "saffwebdhl_products` (`global_product_code`, `local_product_code`, `dhl_product_name`, `network_type_code`) VALUES ('1', '1', 'DOMESTIC EXPRESS 12:00', 'TD'),('2', '2', 'B2C', 'TD'),('3', '3', 'B2C', 'TD'),('4', '4', 'JETLINE', 'TD'),('5', '5', 'SPRINTLINE', 'TD'),('7', '7', 'EXPRESS EASY', 'TD'),('8', '8', 'EXPRESS EASY', 'TD'),('9', '9', 'EUROPACK', 'TD'),('B', 'B', 'BREAKBULK EXPRESS', 'TD'),('C', 'C', 'MEDICAL EXPRESS', 'TD'),('D', 'D', 'EXPRESS WORLDWIDE', 'TD'),('E', 'E', 'EXPRESS 9:00', 'TD'),('F', 'F', 'FREIGHT WORLDWIDE', 'TD'),('G', 'G', 'DOMESTIC ECONOMY SELECT', 'TD'),('H', 'H', 'ECONOMY SELECT', 'TD'),('I', 'I', 'DOMESTIC EXPRESS 9:00', 'TD'),('J', 'J', 'JUMBO BOX', 'TD'),('K', 'K', 'EXPRESS 9:00', 'TD'),('L', 'L', 'EXPRESS 10:30', 'TD'),('M', 'M', 'EXPRESS 10:30', 'TD'),('N', 'N', 'DOMESTIC EXPRESS', 'TD'),('O', 'O', 'DOMESTIC EXPRESS 10:30', 'TD'),('P', 'P', 'EXPRESS WORLDWIDE', 'TD'),('Q', 'Q', 'MEDICAL EXPRESS', 'TD'),('R', 'R', 'GLOBALMAIL BUSINESS', 'TD'),('S', 'S', 'SAME DAY', 'TD'),('T', 'T', 'EXPRESS 12:00', 'TD'),('U', 'U', 'EXPRESS WORLDWIDE', 'TD'),('V', 'V', 'EUROPACK', 'TD'),('W', 'W', 'ECONOMY SELECT', 'TD'),('X', 'X', 'EXPRESS ENVELOPE', 'TD'),('Y', 'Y', 'EXPRESS 12:00', 'TD')");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "saffwebdhl`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "saffwebdhl_options`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "saffwebdhl_capability`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "saffwebdhl_pieces`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "saffwebdhl_products`");
	}

	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			$reward = 0;

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($order_product_query->rows as $product) {
				$reward += $product['reward'];
			}
			
			if ($order_query->row['affiliate_id']) {
				$affiliate_id = $order_query->row['affiliate_id'];
			} else {
				$affiliate_id = 0;
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
			} else {
				$language_code = $this->config->get('config_language');
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'customer'                => $order_query->row['customer'],
				'customer_group_id'       => $order_query->row['customer_group_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'custom_field'            => json_decode($order_query->row['custom_field'], true),
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => json_decode($order_query->row['payment_custom_field'], true),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => json_decode($order_query->row['shipping_custom_field'], true),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'reward'                  => $reward,
				'order_status_id'         => $order_query->row['order_status_id'],
				'order_status'            => $order_query->row['order_status'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'affiliate_firstname'     => $affiliate_firstname,
				'affiliate_lastname'      => $affiliate_lastname,
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_added'              => $order_query->row['date_added'],
				'date_modified'           => $order_query->row['date_modified']
			);
		} else {
			return;
		}
	}	
	/*
	* Get country name
	*/
	public function get_country_name($country_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "'");
		return $query->row['name'];
	}	

	/*
	* Get all orders that have been processed by Saffweb DHL Shipping Extension
		*/
	public function getAllOrders() {
		$sql = "SELECT * FROM " . DB_PREFIX . "order WHERE shipping_code LIKE '%saffwebdhl%' ORDER BY order_id DESC";
		$query = $this->db->query($sql);
		$saffwebdhl = $query->rows;
		return $saffwebdhl;
	}
	/*
	* Get a total of all existing records from the database table
	*/
	public function countAllOrders() {
		$sql = "SELECT COUNT(order_id) AS total FROM " . DB_PREFIX . "order WHERE shipping_code LIKE '%saffwebdhl%'";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
		
	/*
	* Get all Saffweb DHL Options
	*/
	public function getoptions($the_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "saffwebdhl_options WHERE option_id = '" . (int)$the_id . "'");
		return $query->rows;
	}	
	
	/*
	* Add a new Saffweb DHL capability in the DB
	*/
	public function addCapability($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "saffwebdhl_capability` SET order_id = '" . $this->db->escape($data['order_id']) . "', dhl_product_code = '" . $this->db->escape($data['dhl_product_code']) . "', dhl_local_product = '" . $this->db->escape($data['dhl_local_product']) . "', dhl_product_name = '" . $this->db->escape($data['dhl_product_name']) . "', dhl_network_type_code = '" . $this->db->escape($data['dhl_network_type_code']) . "', is_dutiable = '" . $this->db->escape($data['is_dutiable']) . "'");
	}	
	/*
	* Get all affweb DHL capabilities 
	*/
	public function getAllCapabilities($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "saffwebdhl_capability WHERE order_id = '" . (int)$order_id . "'");
		return $query->rows;
	}	
	/*
	* Get an existing record from the database table
	*/
	public function getCapability($record_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "saffwebdhl_capability WHERE id = '" . (int)$record_id . "'");
		return $query->row;
	}
	
	public function updateCapability($record_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "saffwebdhl_capability SET selected = 1 WHERE id = '" . (int)$record_id . "'");
	}

	public function getSelectedCapability($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "saffwebdhl_capability WHERE order_id = '" . (int)$order_id . "' AND selected = 1");
		return $query->row;
	}
	/*
	* Get all DHL Products
	*/
	public function getDhlProducts() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "saffwebdhl_products");
		return $query->rows;
	}	
	
	/*
	* Delete an existing label in the database table
	*/
	public function deleteCapabilities($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "saffwebdhl_capability WHERE order_id = '" . (int)$order_id . "'");
	}

	/*
	* Add a new Saffweb DHL Label in the DB
	*/
	public function addDhlLabel($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "saffwebdhl` SET order_id = '" . $this->db->escape($data['order_id']) . "', label_title = '" . $this->db->escape($data['label_title']) . "', airway_bill_number = '" . $this->db->escape($data['airway_bill_number']) . "', pdf_label = '" . $this->db->escape($data['pdf_label']) . "', image_label = '" . $this->db->escape($data['image_label']) . "', transaction_time = '" . $this->db->escape($data['transaction_time']) . "'");
	}	
		
	/*
	* Get all existing DHL Label records from the database table
	*/
	public function getAllLabels($order_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "saffwebdhl WHERE order_id = '" . (int)$order_id . "' ORDER BY saffwebdhl_id DESC";
		$query = $this->db->query($sql);
		$saffwebdhl = $query->rows;
		return $saffwebdhl;
	}
	/*
	* Get Order ID from label
	*/
	public function getOrderId($saffwebdhl_id) {
		$query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "saffwebdhl WHERE saffwebdhl_id = '" . (int)$saffwebdhl_id . "'");
		return $query->row['order_id'];
	}
	/*
	* Get filename from label
	*/
	public function getFilename($saffwebdhl_id) {
		$query = $this->db->query("SELECT pdf_label FROM " . DB_PREFIX . "saffwebdhl WHERE saffwebdhl_id = '" . (int)$saffwebdhl_id . "'");
		return $query->row['pdf_label'];
	}	
	/*
	* Get recordID given AWB Number
	*/
	public function getRecordID($awb_number) {
		$query = $this->db->query("SELECT saffwebdhl_id FROM " . DB_PREFIX . "saffwebdhl WHERE airway_bill_number = '" . (int)$awb_number . "'");
		return $query->row['saffwebdhl_id'];
	}	
	/*
	* Get Airway Bill Number
	*/
	public function getAirwayBill($saffwebdhl_id) {
		$query = $this->db->query("SELECT airway_bill_number FROM " . DB_PREFIX . "saffwebdhl WHERE saffwebdhl_id = '" . (int)$saffwebdhl_id . "'");
		return $query->row['airway_bill_number'];
	}	
	/*
	* Get all existing AWB records for given order number
	*/
	public function getAllAirwayBills($order_id) {
		$sql = "SELECT airway_bill_number FROM " . DB_PREFIX . "saffwebdhl WHERE order_id = '" . (int)$order_id . "' ORDER BY saffwebdhl_id DESC";
		$query = $this->db->query($sql);
		$saffwebdhl = $query->rows;
		return $saffwebdhl;
	}	
	
	/*
	* Delete an existing label in the database table
	*/
	public function deleteLabel($saffwebdhl_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "saffwebdhl WHERE saffwebdhl_id = '" . (int)$saffwebdhl_id . "'");
	}
	/*
	* Update Book Puckup Record
	*/
	public function bookPickup($record_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "saffwebdhl SET package_location = '" . $this->db->escape($data['package_location']) . "', pickup_date = '" . $this->db->escape($data['pickup_date']) . "', ready_by_time = '" . $this->db->escape($data['ready_by_time']) . "', close_time = '" . $this->db->escape($data['close_time']) . "', after_hours_closing_time = '" . $this->db->escape($data['after_hours_closing_time']) . "', after_hours_location = '" . $this->db->escape($data['after_hours_location']) . "', requestor_contact_name = '" . $this->db->escape($data['requestor_contact_name']) . "', requestor_contact_phone = '" . $this->db->escape($data['requestor_contact_phone']) . "', pickup_contact_name = '" . $this->db->escape($data['pickup_contact_name']) . "', pickup_contact_phone = '" . $this->db->escape($data['pickup_contact_phone']) . "' WHERE saffwebdhl_id = '" . (int)$record_id . "'");
	}
	
	public function bookPickupUpdate($record_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "saffwebdhl SET booked_shipping = '" . $this->db->escape($data['booked_shipping']) . "', booking_action_note = '" . $this->db->escape($data['booking_action_note']) . "', booking_confirmation_number = '" . $this->db->escape($data['booking_confirmation_number']) . "', booking_ready_by_time = '" . $this->db->escape($data['booking_ready_by_time']) . "', booking_call_in_time = '" . $this->db->escape($data['booking_call_in_time']) . "', cancelled_pickup = '" . $this->db->escape($data['cancelled_pickup']) . "' WHERE saffwebdhl_id = '" . (int)$record_id . "'");
	}
	
	public function pickupCancelUpdate($record_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "saffwebdhl SET booked_shipping = '" . $this->db->escape($data['booked_shipping']) . "', booking_action_note = '" . $this->db->escape($data['booking_action_note']) . "', cancelled_pickup = '" . $this->db->escape($data['cancelled_pickup']) . "' WHERE saffwebdhl_id = '" . (int)$record_id . "'");
	}
	/*
	* Get an existing record from the database table
	*/
	public function getDhlRecord($saffwebdhl_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "saffwebdhl WHERE saffwebdhl_id = '" . (int)$saffwebdhl_id . "'");
		return $query->row;
	}
	/*
	* Manage Shipping Pieces
	*/
	public function getAllDhlPieces($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "saffwebdhl_pieces WHERE order_id = '" . (int)$order_id . "' ORDER BY piece_id DESC");
		return $query->rows;
	}	
	
	public function countAllDhlPieces($order_id) {
		$query = $this->db->query("SELECT COUNT(piece_id) AS total FROM " . DB_PREFIX . "saffwebdhl_pieces WHERE order_id = '" . (int)$order_id . "'");
		return $query->row['total'];
	}
	
	public function packageWeight($order_id) {
		$query = $this->db->query("SELECT SUM(weight) AS weight FROM " . DB_PREFIX . "saffwebdhl_pieces WHERE order_id = '" . (int)$order_id . "'");
		return $query->row['weight'];
	}

	public function addDhlPieces($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "saffwebdhl_pieces` SET order_id = '" . $this->db->escape($data['order_id']) . "', height = '" . $this->db->escape($data['height']) . "', depth = '" . $this->db->escape($data['depth']) . "', width = '" . $this->db->escape($data['width']) . "', weight = '" . $this->db->escape($data['weight']) . "'");
	}	
	
	public function deleteDhlPiece($piece_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "saffwebdhl_pieces WHERE piece_id = '" . (int)$piece_id . "'");
	}
}
?>