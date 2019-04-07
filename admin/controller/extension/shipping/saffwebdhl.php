<?php
class ControllerExtensionShippingSaffwebdhl extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/saffwebdhl');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('shipping_saffwebdhl', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
		}

		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_production'] = $this->language->get('text_production');
		$data['text_testing'] = $this->language->get('text_testing');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_dhl_settings'] = $this->language->get('text_dhl_settings');
		$data['text_dhl_products'] = $this->language->get('text_dhl_products');
		$data['text_shipper_details'] = $this->language->get('text_shipper_details');
		$data['text_shipping_origin'] = $this->language->get('text_shipping_origin');
		$data['text_contact_person'] = $this->language->get('text_contact_person');
		$data['text_dhl_logs'] = $this->language->get('text_dhl_logs');
		$data['text_general_settings'] = $this->language->get('text_general_settings');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes_dhlxml'] = $this->language->get('text_yes_dhlxml');
		$data['text_no_dhlxml'] = $this->language->get('text_no_dhlxml');

		$data['entry_test_mode'] = $this->language->get('entry_test_mode');
		$data['entry_access_id'] = $this->language->get('entry_access_id');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_account_number'] = $this->language->get('entry_account_number');
		$data['entry_dhl_region'] = $this->language->get('entry_dhl_region');
		$data['entry_duty_payment_type'] = $this->language->get('entry_duty_payment_type');
		$data['entry_shipper_identification_type'] = $this->language->get('entry_shipper_identification_type');
		$data['entry_shipper_ein_ssn_number'] = $this->language->get('entry_shipper_ein_ssn_number');
		$data['entry_shipper_payment_type'] = $this->language->get('entry_shipper_payment_type');
		$data['entry_label_image_format'] = $this->language->get('entry_label_image_format');
		$data['entry_label_image_size'] = $this->language->get('entry_label_image_size');
		$data['entry_package_type'] = $this->language->get('entry_package_type');
		$data['entry_company_name'] = $this->language->get('entry_company_name');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_country_name'] = $this->language->get('entry_country_name');
		$data['entry_zone_id'] = $this->language->get('entry_zone_id');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_division'] = $this->language->get('entry_division');
		$data['entry_division_code'] = $this->language->get('entry_division_code');
		$data['entry_postal_code'] = $this->language->get('entry_postal_code');
		$data['entry_country_code'] = $this->language->get('entry_country_code');
		$data['entry_person_name'] = $this->language->get('entry_person_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_phone_number'] = $this->language->get('entry_phone_number');
		$data['entry_phone_extension'] = $this->language->get('entry_phone_extension');
		$data['entry_fax_number'] = $this->language->get('entry_fax_number');
		$data['entry_length_class'] = $this->language->get('entry_length_class');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_length'] = $this->language->get('entry_length');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_display_weight'] = $this->language->get('entry_display_weight');
		$data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_export_license'] = $this->language->get('entry_export_license');
		$data['entry_import_license'] = $this->language->get('entry_import_license');
		$data['entry_schedule_b'] = $this->language->get('entry_schedule_b');
		$data['entry_log_dhlxml'] = $this->language->get('entry_log_dhlxml');
		$data['entry_domestic_products'] = $this->language->get('entry_domestic_products');
		$data['entry_international_products'] = $this->language->get('entry_international_products');

		$data['help_test_mode'] = $this->language->get('help_test_mode');
		$data['help_access_id'] = $this->language->get('help_access_id');
		$data['help_password'] = $this->language->get('help_password');
		$data['help_account_number'] = $this->language->get('help_account_number');
		$data['help_domestic_products'] = $this->language->get('help_domestic_products');
		$data['help_international_products'] = $this->language->get('help_international_products');
		$data['help_dimension'] = $this->language->get('help_dimension');
		$data['help_length_class'] = $this->language->get('help_length_class');
		$data['help_display_weight'] = $this->language->get('help_display_weight');
		$data['help_weight_class'] = $this->language->get('help_weight_class');
		$data['help_schedule_b'] = $this->language->get('help_schedule_b');
		$data['help_log_dhlxml'] = $this->language->get('help_log_dhlxml');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_download'] = $this->language->get('button_download');
		$data['button_clear'] = $this->language->get('button_clear');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
 		if (isset($this->error['access_id'])) {
			$data['error_access_id'] = $this->error['access_id'];
		} else {
			$data['error_access_id'] = '';
		}
 
  		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}
  		
		if (isset($this->error['account'])) {
			$data['error_account_number'] = $this->error['account'];
		} else {
			$data['error_account_number'] = '';
		}
		
		if (isset($this->error['dhl_domestic'])) {
			$data['error_dhl_domestic'] = $this->error['dhl_domestic'];
		} else {
			$data['error_dhl_domestic'] = '';
		}

		if (isset($this->error['dhl_international'])) {
			$data['error_dhl_international'] = $this->error['dhl_international'];
		} else {
			$data['error_dhl_international'] = '';
		}
		
 		if (isset($this->error['country_name'])) {
			$data['error_country_name'] = $this->error['country_name'];
		} else {
			$data['error_country_name'] = '';
		}
		
 		if (isset($this->error['zone_id'])) {
			$data['error_zone_id'] = $this->error['zone_id'];
		} else {
			$data['error_zone_id'] = '';
		}
		
 		if (isset($this->error['country_code'])) {
			$data['error_country_code'] = $this->error['country_code'];
		} else {
			$data['error_country_code'] = '';
		}
				
 		if (isset($this->error['company_name'])) {
			$data['error_company_name'] = $this->error['company_name'];
		} else {
			$data['error_company_name'] = '';
		}
		
 		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}
		
 		if (isset($this->error['address_1'])) {
			$data['error_address_1'] = $this->error['address_1'];

		} else {
			$data['error_address_1'] = '';
		}
				
 		if (isset($this->error['postal_code'])) {
			$data['error_postal_code'] = $this->error['postal_code'];
		} else {
			$data['error_postal_code'] = '';
		}
			
 		if (isset($this->error['person_name'])) {
			$data['error_person_name'] = $this->error['person_name'];
		} else {
			$data['error_person_name'] = '';
		}
		
 		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		
 		if (isset($this->error['phone_number'])) {
			$data['error_phone_number'] = $this->error['phone_number'];
		} else {
			$data['error_phone_number'] = '';
		}
				
		if (isset($this->error['dimension'])) {
			$data['error_dimension'] = $this->error['dimension'];
		} else {
			$data['error_dimension'] = '';
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);
		
		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['shipping_saffwebdhl_test_mode'])) {
			$data['shipping_saffwebdhl_test_mode'] = $this->request->post['shipping_saffwebdhl_test_mode'];
		} else {
			$data['shipping_saffwebdhl_test_mode'] = $this->config->get('shipping_saffwebdhl_test_mode');
		}

		if (isset($this->request->post['shipping_saffwebdhl_access_id'])) {
			$data['shipping_saffwebdhl_access_id'] = $this->request->post['shipping_saffwebdhl_access_id'];
		} else {
			$data['shipping_saffwebdhl_access_id'] = $this->config->get('shipping_saffwebdhl_access_id');
		}

		if (isset($this->request->post['shipping_saffwebdhl_password'])) {
			$data['shipping_saffwebdhl_password'] = $this->request->post['shipping_saffwebdhl_password'];
		} else {
			$data['shipping_saffwebdhl_password'] = $this->config->get('shipping_saffwebdhl_password');
		}

		if (isset($this->request->post['shipping_saffwebdhl_account_number'])) {
			$data['shipping_saffwebdhl_account_number'] = $this->request->post['shipping_saffwebdhl_account_number'];
		} else {
			$data['shipping_saffwebdhl_account_number'] = $this->config->get('shipping_saffwebdhl_account_number');
		}
		
		$this->load->model('extension/saffwebdhl');
		$data['dutypayment'] = $this->model_extension_saffwebdhl->getoptions(1);
		$data['identification'] = $this->model_extension_saffwebdhl->getoptions(2);
		$data['paymenttype'] = $this->model_extension_saffwebdhl->getoptions(3);
		$data['imageformat'] = $this->model_extension_saffwebdhl->getoptions(4);
		$data['imagesize'] = $this->model_extension_saffwebdhl->getoptions(5);
		$data['packagetype'] = $this->model_extension_saffwebdhl->getoptions(6);
		$data['dhlregion'] = $this->model_extension_saffwebdhl->getoptions(8);


		if (isset($this->request->post['shipping_saffwebdhl_dhl_region'])) {
			$data['shipping_saffwebdhl_dhl_region'] = $this->request->post['shipping_saffwebdhl_dhl_region'];
		} else {
			$data['shipping_saffwebdhl_dhl_region'] = $this->config->get('shipping_saffwebdhl_dhl_region');
		}

		if (isset($this->request->post['shipping_saffwebdhl_duty_payment_type'])) {
			$data['shipping_saffwebdhl_duty_payment_type'] = $this->request->post['shipping_saffwebdhl_duty_payment_type'];
		} else {
			$data['shipping_saffwebdhl_duty_payment_type'] = $this->config->get('shipping_saffwebdhl_duty_payment_type');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_export_license'])) {
			$data['shipping_saffwebdhl_export_license'] = $this->request->post['shipping_saffwebdhl_export_license'];
		} else {
			$data['shipping_saffwebdhl_export_license'] = $this->config->get('shipping_saffwebdhl_export_license');
		}

		if (isset($this->request->post['shipping_saffwebdhl_import_license'])) {
			$data['shipping_saffwebdhl_import_license'] = $this->request->post['shipping_saffwebdhl_import_license'];
		} else {
			$data['shipping_saffwebdhl_import_license'] = $this->config->get('shipping_saffwebdhl_import_license');
		}

		if (isset($this->request->post['shipping_saffwebdhl_schedule_b'])) {
			$data['shipping_saffwebdhl_schedule_b'] = $this->request->post['shipping_saffwebdhl_schedule_b'];
		} else {
			$data['shipping_saffwebdhl_schedule_b'] = $this->config->get('shipping_saffwebdhl_schedule_b');
		}
		
		$data['dhlproducts'] = $this->model_extension_saffwebdhl->getDhlProducts();

		if (isset($this->request->post['shipping_saffwebdhl_dhl_domestic'])) {
			$data['shipping_saffwebdhl_dhl_domestic'] = implode(", ", $this->request->post['shipping_saffwebdhl_dhl_domestic']);
			$data['dhl_domestic'] = array("1","14","16","21","22");
		} else {
			if($this->config->get('shipping_saffwebdhl_dhl_domestic')) {
				$data['dhl_domestic'] = $this->config->get('shipping_saffwebdhl_dhl_domestic');
			}
			else{
				$data['dhl_domestic'] = array("1","14","16","21","22");
			}
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_dhl_international'])) {
			$data['shipping_saffwebdhl_dhl_international'] = implode(", ", $this->request->post['shipping_saffwebdhl_dhl_international']);
			$data['dhl_international'] = array("20","23","24","32");
		} else {
			if($this->config->get('shipping_saffwebdhl_dhl_international')) {
				$data['dhl_international'] = $this->config->get('shipping_saffwebdhl_dhl_international');
			}
			else{
				$data['dhl_international'] = array("20","23","24","32");
			}
		}

		if (isset($this->request->post['shipping_saffwebdhl_label_image_format'])) {
			$data['shipping_saffwebdhl_label_image_format'] = $this->request->post['shipping_saffwebdhl_label_image_format'];
		} else {
			$data['shipping_saffwebdhl_label_image_format'] = $this->config->get('shipping_saffwebdhl_label_image_format');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_label_image_size'])) {
			$data['shipping_saffwebdhl_label_image_size'] = $this->request->post['shipping_saffwebdhl_label_image_size'];
		} else {
			$data['shipping_saffwebdhl_label_image_size'] = $this->config->get('shipping_saffwebdhl_label_image_size');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_package_type'])) {
			$data['shipping_saffwebdhl_package_type'] = $this->request->post['shipping_saffwebdhl_package_type'];
		} else {
			$data['shipping_saffwebdhl_package_type'] = $this->config->get('shipping_saffwebdhl_package_type');
		}

		if (isset($this->request->post['shipping_saffwebdhl_shipper_identification_type'])) {
			$data['shipping_saffwebdhl_shipper_identification_type'] = $this->request->post['shipping_saffwebdhl_shipper_identification_type'];
		} else {
			$data['shipping_saffwebdhl_shipper_identification_type'] = $this->config->get('shipping_saffwebdhl_shipper_identification_type');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_shipper_ein_ssn_number'])) {
			$data['shipping_saffwebdhl_shipper_ein_ssn_number'] = $this->request->post['shipping_saffwebdhl_shipper_ein_ssn_number'];
		} else {
			$data['shipping_saffwebdhl_shipper_ein_ssn_number'] = $this->config->get('shipping_saffwebdhl_shipper_ein_ssn_number');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_shipper_payment_type'])) {
			$data['shipping_saffwebdhl_shipper_payment_type'] = $this->request->post['shipping_saffwebdhl_shipper_payment_type'];
		} else {
			$data['shipping_saffwebdhl_shipper_payment_type'] = $this->config->get('shipping_saffwebdhl_shipper_payment_type');
		}
		
		
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['shipping_saffwebdhl_country_name'])) {
			$data['shipping_saffwebdhl_country_name'] = $this->request->post['shipping_saffwebdhl_country_name'];
		} else {
			$data['shipping_saffwebdhl_country_name'] = $this->config->get('shipping_saffwebdhl_country_name');
		}

		if (isset($this->request->post['shipping_saffwebdhl_zone_id'])) {
			$data['shipping_saffwebdhl_zone_id'] = $this->request->post['shipping_saffwebdhl_zone_id'];
		} else {
			$data['shipping_saffwebdhl_zone_id'] = $this->config->get('shipping_saffwebdhl_zone_id');
		}		
		
		if (isset($this->request->post['shipping_saffwebdhl_country_code'])) {
			$data['shipping_saffwebdhl_country_code'] = $this->request->post['shipping_saffwebdhl_country_code'];
		} else {
			$data['shipping_saffwebdhl_country_code'] = $this->config->get('shipping_saffwebdhl_country_code');
		}

		if (isset($this->request->post['shipping_saffwebdhl_company_name'])) {
			$data['shipping_saffwebdhl_company_name'] = $this->request->post['shipping_saffwebdhl_company_name'];
		} else {
			$data['shipping_saffwebdhl_company_name'] = $this->config->get('shipping_saffwebdhl_company_name');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_address_1'])) {
			$data['shipping_saffwebdhl_address_1'] = $this->request->post['shipping_saffwebdhl_address_1'];
		} else {
			$data['shipping_saffwebdhl_address_1'] = $this->config->get('shipping_saffwebdhl_address_1');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_address_2'])) {
			$data['shipping_saffwebdhl_address_2'] = $this->request->post['shipping_saffwebdhl_address_2'];
		} else {
			$data['shipping_saffwebdhl_address_2'] = $this->config->get('shipping_saffwebdhl_address_2');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_city'])) {
			$data['shipping_saffwebdhl_city'] = $this->request->post['shipping_saffwebdhl_city'];
		} else {
			$data['shipping_saffwebdhl_city'] = $this->config->get('shipping_saffwebdhl_city');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_postal_code'])) {
			$data['shipping_saffwebdhl_postal_code'] = $this->request->post['shipping_saffwebdhl_postal_code'];
		} else {
			$data['shipping_saffwebdhl_postal_code'] = $this->config->get('shipping_saffwebdhl_postal_code');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_division'])) {
			$data['shipping_saffwebdhl_division'] = $this->request->post['shipping_saffwebdhl_division'];
		} else {
			$data['shipping_saffwebdhl_division'] = $this->config->get('shipping_saffwebdhl_division');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_division_code'])) {
			$data['shipping_saffwebdhl_division_code'] = $this->request->post['shipping_saffwebdhl_division_code'];
		} else {
			$data['shipping_saffwebdhl_division_code'] = $this->config->get('shipping_saffwebdhl_division_code');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_person_name'])) {
			$data['shipping_saffwebdhl_person_name'] = $this->request->post['shipping_saffwebdhl_person_name'];
		} else {
			$data['shipping_saffwebdhl_person_name'] = $this->config->get('shipping_saffwebdhl_person_name');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_email'])) {
			$data['shipping_saffwebdhl_email'] = $this->request->post['shipping_saffwebdhl_email'];
		} else {
			$data['shipping_saffwebdhl_email'] = $this->config->get('shipping_saffwebdhl_email');
		}

		if (isset($this->request->post['shipping_saffwebdhl_phone_number'])) {
			$data['shipping_saffwebdhl_phone_number'] = $this->request->post['shipping_saffwebdhl_phone_number'];
		} else {
			$data['shipping_saffwebdhl_phone_number'] = $this->config->get('shipping_saffwebdhl_phone_number');
		}

		if (isset($this->request->post['shipping_saffwebdhl_phone_extension'])) {
			$data['shipping_saffwebdhl_phone_extension'] = $this->request->post['shipping_saffwebdhl_phone_extension'];
		} else {
			$data['shipping_saffwebdhl_phone_extension'] = $this->config->get('shipping_saffwebdhl_phone_extension');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_fax_number'])) {
			$data['shipping_saffwebdhl_fax_number'] = $this->request->post['shipping_saffwebdhl_fax_number'];
		} else {
			$data['shipping_saffwebdhl_fax_number'] = $this->config->get('shipping_saffwebdhl_fax_number');
		}

		$data['download_dhl_logfile'] = $this->url->link('extension/shipping/saffwebdhl/download', 'user_token=' . $this->session->data['user_token'], true);
		$data['clear_dhl_logfile'] = $this->url->link('extension/shipping/saffwebdhl/clear', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->post['shipping_saffwebdhl_length'])) {
			$data['shipping_saffwebdhl_length'] = $this->request->post['shipping_saffwebdhl_length'];
		} else {
			$data['shipping_saffwebdhl_length'] = $this->config->get('shipping_saffwebdhl_length');
		}

		if (isset($this->request->post['shipping_saffwebdhl_width'])) {
			$data['shipping_saffwebdhl_width'] = $this->request->post['shipping_saffwebdhl_width'];
		} else {
			$data['shipping_saffwebdhl_width'] = $this->config->get('shipping_saffwebdhl_width');
		}

		if (isset($this->request->post['shipping_saffwebdhl_height'])) {
			$data['shipping_saffwebdhl_height'] = $this->request->post['shipping_saffwebdhl_height'];
		} else {
			$data['shipping_saffwebdhl_height'] = $this->config->get('shipping_saffwebdhl_height');
		}

		if (isset($this->request->post['shipping_saffwebdhl_length_class_id'])) {
			$data['shipping_saffwebdhl_length_class_id'] = $this->request->post['shipping_saffwebdhl_length_class_id'];
		} else {
			$data['shipping_saffwebdhl_length_class_id'] = $this->config->get('shipping_saffwebdhl_length_class_id');
		}

        $this->load->model('localisation/length_class');
		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();
		
		if (isset($this->request->post['shipping_saffwebdhl_display_weight'])) {
			$data['shipping_saffwebdhl_display_weight'] = $this->request->post['shipping_saffwebdhl_display_weight'];
		} else {
			$data['shipping_saffwebdhl_display_weight'] = $this->config->get('shipping_saffwebdhl_display_weight');
		}

        $this->load->model('localisation/weight_class');
		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['shipping_saffwebdhl_weight_class_id'])) {
			$data['shipping_saffwebdhl_weight_class_id'] = $this->request->post['shipping_saffwebdhl_weight_class_id'];
		} else {
			$data['shipping_saffwebdhl_weight_class_id'] = $this->config->get('shipping_saffwebdhl_weight_class_id');
		}
				
		$this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['shipping_saffwebdhl_geo_zone_id'])) {
			$data['shipping_saffwebdhl_geo_zone_id'] = $this->request->post['shipping_saffwebdhl_geo_zone_id'];
		} else {
			$data['shipping_saffwebdhl_geo_zone_id'] = $this->config->get('shipping_saffwebdhl_geo_zone_id');
		}
		
        $this->load->model('localisation/tax_class');
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['shipping_saffwebdhl_tax_class_id'])) {
			$data['shipping_saffwebdhl_tax_class_id'] = $this->request->post['shipping_saffwebdhl_tax_class_id'];
		} else {
			$data['shipping_saffwebdhl_tax_class_id'] = $this->config->get('shipping_saffwebdhl_tax_class_id');
		}

		if (isset($this->request->post['shipping_saffwebdhl_status'])) {
			$data['shipping_saffwebdhl_status'] = $this->request->post['shipping_saffwebdhl_status'];
		} else {
			$data['shipping_saffwebdhl_status'] = $this->config->get('shipping_saffwebdhl_status');
		}
		
		if (isset($this->request->post['shipping_saffwebdhl_log_dhlxml'])) {
			$data['shipping_saffwebdhl_log_dhlxml'] = $this->request->post['shipping_saffwebdhl_log_dhlxml'];
		} else {
			$data['shipping_saffwebdhl_log_dhlxml'] = $this->config->get('shipping_saffwebdhl_log_dhlxml');
		}

		if (isset($this->request->post['shipping_saffwebdhl_sort_order'])) {
			$data['shipping_saffwebdhl_sort_order'] = $this->request->post['shipping_saffwebdhl_sort_order'];
		} else {
			$data['shipping_saffwebdhl_sort_order'] = $this->config->get('shipping_saffwebdhl_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/saffwebdhl', $data));
    }
    
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/saffwebdhl')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['shipping_saffwebdhl_access_id']) {
			$this->error['access_id'] = $this->language->get('error_access_id');
		}

		if (!$this->request->post['shipping_saffwebdhl_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->request->post['shipping_saffwebdhl_account_number']) {
			$this->error['account'] = $this->language->get('error_account_number');
		}
		
		if (!$this->request->post['shipping_saffwebdhl_dhl_domestic']) {
			$this->error['dhl_domestic'] = $this->language->get('error_dhl_domestic');
		}

		if (!$this->request->post['shipping_saffwebdhl_dhl_international']) {
			$this->error['dhl_international'] = $this->language->get('error_dhl_international');
		}
		
		if (!$this->request->post['shipping_saffwebdhl_country_name']) {
			$this->error['country_name'] = $this->language->get('error_country_name');
		}
		
		if (!$this->request->post['shipping_saffwebdhl_country_code']) {
			$this->error['country_code'] = $this->language->get('error_country_code');
		}
		
		if (!$this->request->post['shipping_saffwebdhl_company_name']) {
			$this->error['company_name'] = $this->language->get('error_company_name');
		}
		
		if (!$this->request->post['shipping_saffwebdhl_city']) {
			$this->error['city'] = $this->language->get('error_city');
		}
		
		if (!$this->request->post['shipping_saffwebdhl_address_1']) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if (!$this->request->post['shipping_saffwebdhl_postal_code']) {
			$this->error['postal_code'] = $this->language->get('error_postal_code');
		}

		if (!$this->request->post['shipping_saffwebdhl_person_name']) {
			$this->error['person_name'] = $this->language->get('error_person_name');
		}

		if (!$this->request->post['shipping_saffwebdhl_email']) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (!$this->request->post['shipping_saffwebdhl_phone_number']) {
			$this->error['phone_number'] = $this->language->get('error_phone_number');
		}

		if (!$this->request->post['shipping_saffwebdhl_length'] || !$this->request->post['shipping_saffwebdhl_width'] || !$this->request->post['shipping_saffwebdhl_height']) {
			$this->error['dimension'] = $this->language->get('error_dimension');
		}

		return !$this->error;
	}
	
	
	public function download() {
		$this->load->language('tool/log');

		$file = DIR_LOGS .'saffwebdhl.log';

		if (file_exists($file) && filesize($file) > 0) {
			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename="' . $this->config->get('config_name') . '_' . date('Y-m-d_H-i-s', time()) . '_saffwebdhl.log"');
			$this->response->addheader('Content-Transfer-Encoding: binary');

			$this->response->setOutput(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
		} else {
			$this->session->data['error'] = sprintf($this->language->get('error_warning'), basename($file), '0B');

			$this->response->redirect($this->url->link('extension/shipping/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true));
		}
	}
	
	
	public function clear() {
		$this->load->language('tool/log');
		if (!$this->user->hasPermission('modify', 'extension/shipping/saffwebdhl')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			$file = DIR_LOGS .'saffwebdhl.log';

			$handle = fopen($file, 'w+');

			fclose($handle);

			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('extension/shipping/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true));
	}
	
	
	public function install() {
		$this->load->model('extension/saffwebdhl');
		$this->model_extension_saffwebdhl->install();
	}


	public function uninstall() {
		$this->load->model('extension/saffwebdhl');
		$this->model_extension_saffwebdhl->uninstall();
	}
}
?>