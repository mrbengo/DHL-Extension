<?php
class ControllerExtensionModuleSaffwebdhl extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/saffwebdhl');
		$this->load->model('setting/setting');
		
		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('saffwebdhl', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_installed'] = $this->language->get('text_installed');
 		
		$data['user_token'] = $this->session->data['user_token'];

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/saffwebdhl', $data));
	}
	

 /*
 * View Sender and Receiver Details.
 */
  	public function view_sr_details() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->load->language('sale/order');
			
			$this->load->language('extension/module/saffwebdhl');
			$this->load->model('extension/saffwebdhl');
			$this->load->model('design/layout');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_shipper_details'] = $this->language->get('text_shipper_details');
			$data['text_customer_detail'] = $this->language->get('text_customer_detail');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_loading'] = $this->language->get('text_loading');
			
			//Shipper Details
			$data['text_country_name']  = $this->language->get('text_country_name');
			$data['text_zone_id']  = $this->language->get('text_zone_id');
			$data['text_country_code']  = $this->language->get('text_country_code');
			$data['text_company_name']  = $this->language->get('text_company_name');
			$data['text_address_1']  = $this->language->get('text_address_1');
			$data['text_address_2']  = $this->language->get('text_address_2');
			$data['text_city']  = $this->language->get('text_city');
			$data['text_postal_code']  = $this->language->get('text_postal_code');
			$data['text_division']  = $this->language->get('text_division');
			$data['text_division_code']  = $this->language->get('text_division_code');
			$data['text_person_name']  = $this->language->get('text_person_name');
			$data['text_email']  = $this->language->get('text_email');
			$data['text_phone_number']  = $this->language->get('text_phone_number');
			$data['text_phone_extension']  = $this->language->get('text_phone_extension');
			
			//Consignee/Customer Details
			$data['text_shipping_company'] = $this->language->get('text_shipping_company');
			$data['text_shipping_name'] = $this->language->get('text_shipping_name');
			$data['text_shipping_company'] = $this->language->get('text_shipping_company');
			$data['text_shipping_address_1'] = $this->language->get('text_shipping_address_1');
			$data['text_shipping_address_2'] = $this->language->get('text_shipping_address_2');
			$data['text_shipping_postcode'] = $this->language->get('text_shipping_postcode');
			$data['text_shipping_city'] = $this->language->get('text_shipping_city');
			$data['text_shipping_zone'] = $this->language->get('text_shipping_zone');
			$data['text_shipping_country'] = $this->language->get('text_shipping_country');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_shipping_code'] = $this->language->get('text_shipping_code');
			$data['text_shipping_phone'] = $this->language->get('text_shipping_phone');
			$data['text_shipping_email'] = $this->language->get('text_shipping_email');
			$data['text_shipping_country_code']  = $this->language->get('text_shipping_country_code');

			$url = '';

			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			
			$data['cancel'] = $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true);

			$data['user_token'] = $this->session->data['user_token'];

			$data['order_id'] = $this->request->get['order_id'];
			
			//Get Shipper Details
			$this->load->model('setting/setting');
			$data['shipping_saffwebdhl_country_name'] = $this->model_extension_saffwebdhl->get_country_name($this->config->get('shipping_saffwebdhl_country_name'));
			$data['shipping_saffwebdhl_zone_id'] = $this->config->get('shipping_saffwebdhl_zone_id');
			$data['shipping_saffwebdhl_country_code'] = $this->config->get('shipping_saffwebdhl_country_code');
			$data['shipping_saffwebdhl_company_name'] = $this->config->get('shipping_saffwebdhl_company_name');
			$data['shipping_saffwebdhl_address_1'] = $this->config->get('shipping_saffwebdhl_address_1');
			$data['shipping_saffwebdhl_address_2'] = $this->config->get('shipping_saffwebdhl_address_2');
			$data['shipping_saffwebdhl_city'] = $this->config->get('shipping_saffwebdhl_city');
			$data['shipping_saffwebdhl_postal_code'] = $this->config->get('shipping_saffwebdhl_postal_code');
			$data['shipping_saffwebdhl_division'] = $this->config->get('shipping_saffwebdhl_division');
			$data['shipping_saffwebdhl_division_code'] = $this->config->get('shipping_saffwebdhl_division_code');
			$data['shipping_saffwebdhl_person_name'] = $this->config->get('shipping_saffwebdhl_person_name');
			$data['shipping_saffwebdhl_email'] = $this->config->get('shipping_saffwebdhl_email');
			$data['shipping_saffwebdhl_phone_number'] = $this->config->get('shipping_saffwebdhl_phone_number');
			$data['shipping_saffwebdhl_phone_extension'] = $this->config->get('shipping_saffwebdhl_phone_extension');
			
			//Get Consigee/Customer Details
			$data['shipping_company'] = $order_info['shipping_company'];
			$data['shipping_firstname'] = $order_info['shipping_firstname'];
			$data['shipping_lastname'] = $order_info['shipping_lastname'];
			$data['shipping_company'] = $order_info['shipping_company'];
			$data['shipping_address_1'] = $order_info['shipping_address_1'];
			$data['shipping_address_2'] = $order_info['shipping_address_2'];
			$data['shipping_city'] = $order_info['shipping_city'];
			$data['shipping_postcode'] = $order_info['shipping_postcode'];
			$data['shipping_zone'] = $order_info['shipping_zone'];
			$data['shipping_zone_code'] = $order_info['shipping_zone_code'];
			$data['shipping_country'] = $order_info['shipping_country'];
			$data['shipping_email'] = $order_info['email'];
			$data['shipping_telephone'] = $order_info['telephone'];
            $data['shipping_country_code'] = $order_info['shipping_iso_code_2'];
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('extension/module/saffwebdhl_view_sr', $data));
		
		} else {
			return new Action('error/not_found');
		}
	}


/*
 * Get DHL Capability and Products.
 */
  	public function get_dhl_capability() {
		$this->load->model('sale/order');
		$this->load->language('sale/order');
		$this->load->language('extension/module/saffwebdhl');
		$this->load->model('extension/saffwebdhl');
		$json = array();
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		$order_info = $this->model_sale_order->getOrder($order_id);
		
		$this->load->model('setting/setting');
		//Get all pieces for this order and showcase them.
		$pieces = $this->model_extension_saffwebdhl->getAllDhlPieces($order_info['order_id']);
		$num_pieces = $this->model_extension_saffwebdhl->countAllDhlPieces($order_info['order_id']);

		$weight_code = strtoupper($this->weight->getUnit($this->config->get('shipping_saffwebdhl_weight_class_id')));
		$length_code = strtoupper($this->length->getUnit($this->config->get('shipping_saffwebdhl_length_class_id')));

		$x = 0;
		$the_pieces = "";
		foreach ($pieces as $piece) {
		$x++;
		$the_pieces.=
		 '<Piece>
			<PieceID>' . $x . '</PieceID>
			<Height>' . $piece['height'] . '</Height>
			<Depth>' . $piece['depth'] . '</Depth>
			<Width>' . $piece['width'] . '</Width>
			<Weight>' . $piece['weight'] . '</Weight>
		 </Piece>';
		} 

		$dutiable_value = $this->request->get['is_dutiable'];
		if ($dutiable_value == 'Y') {
			//Process DHL is dutible
			$xml  = '<?xml version="1.0" encoding="utf-8"?>
				<req:DCTRequest xmlns:req="http://www.dhl.com">
				  <GetCapability>
					<Request>
					  <ServiceHeader>
						<MessageTime>'.date('c').'</MessageTime>
					    <MessageReference>1234567890123456789012345678</MessageReference>
					    <SiteID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</SiteID>
					    <Password>' . $this->config->get('shipping_saffwebdhl_password') . '</Password>
					  </ServiceHeader>
					</Request>
					<From>
					  <CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
					  <Postalcode>' . $this->config->get('shipping_saffwebdhl_postal_code') . '</Postalcode>
					  <City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
					</From>
					<BkgDetails>
					  <PaymentCountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</PaymentCountryCode>
					  <Date>'.date('Y-m-d').'</Date>
					  <ReadyTime>PT9H</ReadyTime>
					  <DimensionUnit>' . $length_code . '</DimensionUnit>
					  <WeightUnit>' . $weight_code . '</WeightUnit>
					  <Pieces>
						' . $the_pieces . '
					  </Pieces>
					  <IsDutiable>Y</IsDutiable>
					</BkgDetails>
					<To>
					  <CountryCode>' . $order_info['shipping_iso_code_2'] . '</CountryCode>
					  <Postalcode>' . $order_info['shipping_postcode'] . '</Postalcode>
					  <City>' . $order_info['shipping_city'] . '</City>
					</To>
					<Dutiable>
					  <DeclaredCurrency>' . $this->config->get('config_currency') . '</DeclaredCurrency>
					  <DeclaredValue>' . round($order_info['total'], 2) . '</DeclaredValue>
					</Dutiable>
				  </GetCapability>
				</req:DCTRequest>';
				
				$dom = $this->process_xml($xml); //Process XML request to DHL
				if ($dom) {
					//Delete existing capabilities first
			        $this->model_extension_saffwebdhl->deleteCapabilities($order_info['order_id']); 
					
					foreach ($dom->GetCapabilityResponse->BkgDetails->QtdShp as $item){
						$data2 = array();
						$data2['order_id'] = $order_info['order_id'];
						$data2['dhl_product_code'] = $item->GlobalProductCode;
						$data2['dhl_local_product'] = $item->LocalProductCode;
						$data2['dhl_product_name'] = $item->LocalProductName;
						$data2['is_dutiable'] = 'Y';
						
						$this->model_extension_saffwebdhl->addCapability($data2);
					}
				}
				$json = array(
			    'is_dutiable'   => 'Y',
				'dhl_products'  => "YES"
			);
				
		}
		
		if($dutiable_value == 'N') {
			//Process DHL is non-dutible
			$xml  = '<?xml version="1.0" encoding="utf-8"?>
			  <req:DCTRequest xmlns:req="http://www.dhl.com">
				<GetCapability>
				  <Request>
					<ServiceHeader>
					   <MessageTime>'.date('c').'</MessageTime>
					   <MessageReference>1234567890123456789012345678</MessageReference>
					   <SiteID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</SiteID>
					   <Password>' . $this->config->get('shipping_saffwebdhl_password') . '</Password>
					</ServiceHeader>
				  </Request>
				  <From>
					 <CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
					 <Postalcode>' . $this->config->get('shipping_saffwebdhl_postal_code') . '</Postalcode>
					 <City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
				  </From>
				  <BkgDetails>
					 <PaymentCountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</PaymentCountryCode>
					 <Date>'.date('Y-m-d').'</Date>
					 <ReadyTime>PT9H</ReadyTime>
					 <DimensionUnit>' . $length_code . '</DimensionUnit>
					 <WeightUnit>' . $weight_code . '</WeightUnit>
					 <Pieces>
					' . $the_pieces . '
					 </Pieces>
					<IsDutiable>N</IsDutiable>
				  </BkgDetails>
				  <To>
					 <CountryCode>' . $order_info['shipping_iso_code_2'] . '</CountryCode>
					 <Postalcode>' . $order_info['shipping_postcode'] . '</Postalcode>
					 <City>' . $order_info['shipping_city'] . '</City>
				  </To>
				</GetCapability>
			  </req:DCTRequest>';
				
				$dom = $this->process_xml($xml); //Process XML request to DHL
				if ($dom) {
					//Delete existing capabilities first
			        $this->model_extension_saffwebdhl->deleteCapabilities($order_info['order_id']); 
					
					foreach ($dom->GetCapabilityResponse->BkgDetails->QtdShp as $item){
						$data2 = array();
						$data2['order_id'] = $order_info['order_id'];
						$data2['dhl_product_code'] = $item->GlobalProductCode;
						$data2['dhl_local_product'] = $item->LocalProductCode;
						$data2['dhl_product_name'] = $item->LocalProductName;
						$data2['is_dutiable'] = 'N';
						
						$this->model_extension_saffwebdhl->addCapability($data2);
					}
				}
				
			$json = array(
			    'is_dutiable'   => 'N',
				'dhl_products'  => "NO"
			);
		}
		
	}


 /*
 * Generate Labels from DHL.
 */
  	public function request_shipping() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->load->language('sale/order');
			$this->load->language('extension/module/saffwebdhl');
			$this->load->model('extension/saffwebdhl');
			$this->load->model('design/layout');

			$this->document->setTitle($this->language->get('heading_title'));
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_no_results'] = $this->language->get('text_no_results');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_loading'] = $this->language->get('text_loading');
			$data['text_request_shipping'] = $this->language->get('text_request_shipping');
			$data['text_check_dhl_capability'] = $this->language->get('text_check_dhl_capability');
			$data['text_shipping_label'] = $this->language->get('text_shipping_label');
			$data['text_delete_label'] = $this->language->get('text_delete_label');
		    $data['text_select'] = $this->language->get('text_select');
			$data['text_shipping_from'] = $this->language->get('text_shipping_from');
			$data['text_shipping_to'] = $this->language->get('text_shipping_to');
			$data['text_country_name']  = $this->language->get('text_country_name');
			$data['text_country_code']  = $this->language->get('text_country_code');
			$data['text_city']  = $this->language->get('text_city');
			$data['text_postal_code']  = $this->language->get('text_postal_code');
			$data['text_shipping_postcode'] = $this->language->get('text_shipping_postcode');
			$data['text_shipping_city'] = $this->language->get('text_shipping_city');
			$data['text_shipping_country'] = $this->language->get('text_shipping_country');
			$data['text_shipping_country_code']  = $this->language->get('text_shipping_country_code');
			
			// Entry
			$data['entry_packagetype'] = $this->language->get('entry_packagetype');
			$data['entry_isdutiable'] = $this->language->get('entry_isdutiable');
			$data['entry_dhl_product'] = $this->language->get('entry_dhl_product');
			$data['entry_shipping_contents'] = $this->language->get('entry_shipping_contents');
			$data['entry_insured_amount'] = $this->language->get('entry_insured_amount');
			$data['entry_consignee_ein'] = $this->language->get('entry_consignee_ein');
			$data['entry_dhl_account_number'] = $this->language->get('entry_dhl_account_number');
			$data['entry_package_location'] = $this->language->get('entry_package_location');
			$data['entry_customer_division'] = $this->language->get('entry_customer_division');
			$data['entry_phone_extension'] = $this->language->get('entry_phone_extension');

			// Help
			$data['help_shipping_contents'] = $this->language->get('help_shipping_contents');
			$data['help_insured_amount'] = $this->language->get('help_insured_amount');
			$data['help_consignee_ein'] = $this->language->get('help_consignee_ein');
			$data['help_dhl_account_number'] = $this->language->get('help_dhl_account_number');
			$data['help_package_location'] = $this->language->get('help_package_location');
			$data['help_isdutiable'] = $this->language->get('help_isdutiable');
			
			//Order table columns
			$data['column_label_title'] = $this->language->get('column_label_title');
			$data['column_tracking_number'] = $this->language->get('column_tracking_number');
			$data['column_pdf_label'] = $this->language->get('column_pdf_label');
			$data['column_transaction_time'] = $this->language->get('column_transaction_time');

			$url = '';

			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['cancel'] = $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true);
			
			$data['user_token'] = $this->session->data['user_token'];
			$data['order_id'] = $this->request->get['order_id'];
			
			//Get Shipping FROM & TO Details
			$this->load->model('setting/setting');
			$data['shipping_saffwebdhl_country_name'] = $this->model_extension_saffwebdhl->get_country_name($this->config->get('shipping_saffwebdhl_country_name'));
			$data['shipping_saffwebdhl_country_code'] = $this->config->get('shipping_saffwebdhl_country_code');
			$data['shipping_saffwebdhl_city'] = $this->config->get('shipping_saffwebdhl_city');
			$data['shipping_saffwebdhl_postal_code'] = $this->config->get('shipping_saffwebdhl_postal_code');
			$data['shipping_city']         = $order_info['shipping_city'];
			$data['shipping_postcode']     = $order_info['shipping_postcode'];
			$data['shipping_country']      = $order_info['shipping_country'];
            $data['shipping_country_code'] = $order_info['shipping_iso_code_2'];			
			
			$data['dhlproducts'] = $this->model_extension_saffwebdhl->getAllCapabilities($order_id);
			$data['dhlregion'] = $this->config->get('shipping_saffwebdhl_dhl_region');//Get DHL Region
			
			$consignee_name = $order_info['shipping_firstname'].' '.$order_info['shipping_lastname'];
			$shipper_country_name =$this->model_extension_saffwebdhl->get_country_name($this->config->get('shipping_saffwebdhl_country_name'));
			if ($order_info['shipping_company']){
				$consignee_company = $order_info['shipping_company'];
			} else{
				$consignee_company = $consignee_name;
			}
			
			
			//Get all labels for this order and showcase them.
			$data['alllabels'] = array();
			$labels = $this->model_extension_saffwebdhl->getAllLabels($order_info['order_id']);
							
			foreach ($labels as $label) {
				$data['alllabels'][] = array(
					'saffwebdhl_id'      => $label['saffwebdhl_id'],
					'order_id'           => $label['order_id'],
					'label_title'        => $label['label_title'],
					'airway_bill_number' => $label['airway_bill_number'],
					'pdf_label'          => $label['pdf_label'],
					'pdf_label_link'     => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/image/dhl/".$label['pdf_label']."",
					'image_label'        => $label['image_label'],
					'transaction_time'   => $label['transaction_time'],
					'delete_label' => $this->url->link('extension/module/saffwebdhl/delete_label', 'user_token=' . $this->session->data['user_token'] . '&saffwebdhl_id=' .  $label['saffwebdhl_id'], true)
				);
			}
			
			
			 if ($this->request->server['REQUEST_METHOD'] == 'POST') {
				$dhlproducts = $this->model_extension_saffwebdhl->getCapability($this->request->post['shipping_saffwebdhl_dhl_product']);
				//Get all pieces for this order and showcase them.
				$pieces = $this->model_extension_saffwebdhl->getAllDhlPieces($order_info['order_id']);
				$num_pieces = $this->model_extension_saffwebdhl->countAllDhlPieces($order_info['order_id']);
				$total_weight = $this->model_extension_saffwebdhl->packageWeight($order_info['order_id']);

				$weight_code = strtoupper($this->weight->getUnit($this->config->get('shipping_saffwebdhl_weight_class_id')));
				if ($weight_code == 'KG') {
					$weight_code = 'K';
				}
				if ($weight_code == 'OZ') {
					$weight_code = 'O';
				}
				if ($weight_code == 'LB') {
					$weight_code = 'L';
				}
				
			    $length_code = strtoupper($this->length->getUnit($this->config->get('shipping_saffwebdhl_length_class_id')));
				if ($length_code == 'CM') {
					$length_code = 'C';
				}
				if ($length_code == 'IN') {
					$length_code = 'I';
				}
				if ($length_code == 'MM') {
					$length_code = 'M';
				}

				$x = 0;
				$the_pieces = "";
				foreach ($pieces as $piece) {
				$x++;
				$the_pieces.=
				 '<Piece>
					<PieceID>' . $x . '</PieceID>
					<Weight>' . $piece['weight'] . '</Weight>
					<Width>' . $piece['width'] . '</Width>
					<Height>' . $piece['height'] . '</Height>
					<Depth>' . $piece['depth'] . '</Depth>
				 </Piece>';
				} 
				
				$xml_request = '<Request>
							<ServiceHeader>
								<MessageTime>'.date('c').'</MessageTime>
							    <MessageReference>da83273f4ae26060e7db50f971e50488</MessageReference>
							    <SiteID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</SiteID>
							    <Password>' . $this->config->get('shipping_saffwebdhl_password') . '</Password>
							</ServiceHeader>
							</Request>';
				
				//Duty Paid By 		
				$duty_payment = $this->config->get('shipping_saffwebdhl_duty_payment_type');
				$data['duty_payment'] = $duty_payment;
				
				if($duty_payment == 'R'){
					$dutyaccountnumber = '<DutyAccountNumber>' . $this->request->post['dhl_account_number'] . '</DutyAccountNumber>';
					$termsoftrade = '<TermsOfTrade>DAP</TermsOfTrade>';
					$specialservice = '<SpecialService>
							<SpecialServiceType>A</SpecialServiceType>
						</SpecialService>
						<SpecialService>
							<SpecialServiceType>I</SpecialServiceType>
						</SpecialService>';
				}
				
				if($duty_payment == 'S'){
					$dutyaccountnumber = '<DutyAccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</DutyAccountNumber>';
					$termsoftrade = '<TermsOfTrade>DDP</TermsOfTrade>';
					$specialservice = '<SpecialService>
							<SpecialServiceType>DD</SpecialServiceType>
						</SpecialService>';
				}
				
				$dhlregion = $this->config->get('shipping_saffwebdhl_dhl_region');//Get DHL Region
				
				//AM Region -Supports USA and other countries in North and South Americas.
				if($dhlregion == "AM"){
					$xml  = '<?xml version="1.0" encoding="UTF-8"?>
					<req:ShipmentRequest xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com ship-val-global-req.xsd" schemaVersion="5.0">
						' . $xml_request . '
						<RegionCode>AM</RegionCode>
						<RequestedPickupTime>Y</RequestedPickupTime>
						<NewShipper>Y</NewShipper>
						<LanguageCode>en</LanguageCode>
						<PiecesEnabled>Y</PiecesEnabled>
						<Billing>
							<ShipperAccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</ShipperAccountNumber>
							<ShippingPaymentType>' . $this->config->get('shipping_saffwebdhl_shipper_payment_type') . '</ShippingPaymentType>
							<BillingAccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</BillingAccountNumber>
							<DutyPaymentType>' . $this->config->get('shipping_saffwebdhl_duty_payment_type') . '</DutyPaymentType>
							' . $dutyaccountnumber . '
						</Billing>
						<Consignee>
							<CompanyName>' . $consignee_company . '</CompanyName>
						    <AddressLine>' . $order_info['shipping_address_1'] . '</AddressLine>
						    <AddressLine>' . $order_info['shipping_address_2'] . '</AddressLine>
						    <City>' . $order_info['shipping_city'] . '</City>
						    <PostalCode>' . $order_info['shipping_postcode'] . '</PostalCode>
						    <CountryCode>' . $order_info['shipping_iso_code_2'] . '</CountryCode>
						    <CountryName>' . $order_info['shipping_country'] . '</CountryName>
							<Contact>
								<PersonName>' . $consignee_name . '</PersonName>
								<PhoneNumber>' . $order_info['telephone'] . '</PhoneNumber>
								<PhoneExtension>' . $this->request->post['phone_extension'] . '</PhoneExtension>
								<Email>' . $order_info['email'] . '</Email>
							</Contact>
						</Consignee>
						<Commodity>
							<CommodityCode>cc</CommodityCode>
							<CommodityName>cn</CommodityName>
						</Commodity>
						<Dutiable>
							<DeclaredValue>' . round($order_info['total'], 2) . '</DeclaredValue>
							<DeclaredCurrency>' . $this->config->get('config_currency') . '</DeclaredCurrency>
							<ScheduleB>' . $this->config->get('shipping_saffwebdhl_schedule_b') . '</ScheduleB>
							<ExportLicense>' . $this->config->get('shipping_saffwebdhl_export_license') . '</ExportLicense>
							<ShipperEIN>' . $this->config->get('shipping_saffwebdhl_shipper_ein_ssn_number') . '</ShipperEIN>
							<ShipperIDType>' . $this->config->get('shipping_saffwebdhl_shipper_identification_type') . '</ShipperIDType>
							<ImportLicense>' . $this->config->get('shipping_saffwebdhl_import_license') . '</ImportLicense>
							<ConsigneeEIN>' . $this->request->post['consignee_ein'] . '</ConsigneeEIN>
							' . $termsoftrade . '
						</Dutiable>
						<Reference>
							<ReferenceID>' . $order_info['shipping_iso_code_2'] . ' Shipment on '.date('Y-m-d H:i:s').'</ReferenceID>
							<ReferenceType>St</ReferenceType>
						</Reference>
						<ShipmentDetails>
							<NumberOfPieces>' . $num_pieces . '</NumberOfPieces>
						    <Pieces>
						    ' . $the_pieces . '
						    </Pieces>
						    <Weight>' . $total_weight . '</Weight>
						    <WeightUnit>' . $weight_code . '</WeightUnit>
							<GlobalProductCode>' . $dhlproducts['dhl_product_code'] . '</GlobalProductCode>
							<LocalProductCode>' . $dhlproducts['dhl_local_product'] . '</LocalProductCode>
							<Date>'.date('Y-m-d').'</Date>
							<Contents>' . $this->request->post['shipping_contents'] . '</Contents>
							<DoorTo>DD</DoorTo>
							<DimensionUnit>' . $length_code . '</DimensionUnit>
							<InsuredAmount>' . $this->request->post['insured_amount'] . '</InsuredAmount>
							<PackageType>' . $this->request->post['shipping_saffwebdhl_packagetype'] . '</PackageType>
							<IsDutiable>' . $dhlproducts['is_dutiable'] . '</IsDutiable>
							<CurrencyCode>' . $this->config->get('config_currency') . '</CurrencyCode>
						</ShipmentDetails>
						<Shipper>
							<ShipperID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</ShipperID>
							<CompanyName>' . $this->config->get('shipping_saffwebdhl_company_name') . '</CompanyName>
							<RegisteredAccount>' . $this->config->get('shipping_saffwebdhl_access_id') . '</RegisteredAccount>
							<AddressLine>' . $this->config->get('shipping_saffwebdhl_address_1') . '</AddressLine>
						    <AddressLine>' . $this->config->get('shipping_saffwebdhl_address_2') . '</AddressLine>
							<City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
							<Division>' . $this->config->get('shipping_saffwebdhl_division') . '</Division>
							<DivisionCode>' . $this->config->get('shipping_saffwebdhl_division_code') . '</DivisionCode>
							<PostalCode>' . $this->config->get('shipping_saffwebdhl_postal_code') . '</PostalCode>
							<CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
							<CountryName>' . $shipper_country_name . '</CountryName>
							<Contact>
								<PersonName>' . $this->config->get('shipping_saffwebdhl_person_name') . '</PersonName>
								<PhoneNumber>' . $this->config->get('shipping_saffwebdhl_phone_number') . '</PhoneNumber>
								<PhoneExtension>' . $this->config->get('shipping_saffwebdhl_phone_extension') . '</PhoneExtension>
								<Email>' . $this->config->get('shipping_saffwebdhl_email') . '</Email>
							</Contact>
						</Shipper>
						' . $specialservice . '
						<EProcShip>N</EProcShip>
						<LabelImageFormat>' . $this->config->get('shipping_saffwebdhl_label_image_format') . '</LabelImageFormat> 
					</req:ShipmentRequest>';
				}

				
				//EU Region -Supports countries in Europe.
				if($dhlregion == "EU"){
					$xml  = '<?xml version="1.0" encoding="UTF-8"?>
					<req:ShipmentRequest xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com ship-val-global-req.xsd" schemaVersion="5.0">
						' . $xml_request . '
						<RegionCode>EU</RegionCode>
						<NewShipper>N</NewShipper>
						<LanguageCode>en</LanguageCode>
						<PiecesEnabled>Y</PiecesEnabled>
						<Billing>
						  <ShipperAccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</ShipperAccountNumber>
						  <ShippingPaymentType>' . $this->config->get('shipping_saffwebdhl_shipper_payment_type') . '</ShippingPaymentType>
						  <BillingAccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</BillingAccountNumber>
						  <DutyPaymentType>' . $this->config->get('shipping_saffwebdhl_duty_payment_type') . '</DutyPaymentType>
						</Billing>
						<Consignee>
							<CompanyName>' . $consignee_company . '</CompanyName>
							<AddressLine>' . $order_info['shipping_address_1'] . '</AddressLine>
							<AddressLine>' . $order_info['shipping_address_2'] . '</AddressLine>
							<City>' . $order_info['shipping_city'] . '</City>
							<Division>' . $this->request->post['customer_division'] . '</Division>
							<PostalCode>' . $order_info['shipping_postcode'] . '</PostalCode>
							<CountryCode>' . $order_info['shipping_iso_code_2'] . '</CountryCode>
							<CountryName>' . $order_info['shipping_country'] . '</CountryName>
							<Contact>
								<PersonName>' . $consignee_name . '</PersonName>
								<PhoneNumber>' . $order_info['telephone'] . '</PhoneNumber>
								<PhoneExtension>' . $this->request->post['phone_extension'] . '</PhoneExtension>
								<FaxNumber>' . $order_info['fax'] . '</FaxNumber>
								<Email>' . $order_info['email'] . '</Email>
							</Contact>
						</Consignee>
						<Commodity>
							<CommodityCode>cc</CommodityCode>
							<CommodityName>cn</CommodityName>
						</Commodity>
						<Dutiable>
							<DeclaredValue>' . round($order_info['total'], 2) . '</DeclaredValue>
							<DeclaredCurrency>' . $this->config->get('config_currency') . '</DeclaredCurrency>
							<ScheduleB>' . $this->config->get('shipping_saffwebdhl_schedule_b') . '</ScheduleB>
							<ExportLicense>' . $this->config->get('shipping_saffwebdhl_export_license') . '</ExportLicense>
							<ShipperEIN>' . $this->config->get('shipping_saffwebdhl_shipper_ein_ssn_number') . '</ShipperEIN>
							<ShipperIDType>' . $this->config->get('shipping_saffwebdhl_shipper_identification_type') . '</ShipperIDType>
							<ImportLicense>' . $this->config->get('shipping_saffwebdhl_import_license') . '</ImportLicense>
							<ConsigneeEIN>' . $this->request->post['consignee_ein'] . '</ConsigneeEIN>
							' . $termsoftrade . '
						</Dutiable>
						<ShipmentDetails>
							<NumberOfPieces>' . $num_pieces . '</NumberOfPieces>
						    <Pieces>
						    ' . $the_pieces . '
						    </Pieces>
						    <Weight>' . $total_weight . '</Weight>
						    <WeightUnit>' . $weight_code . '</WeightUnit>
							<GlobalProductCode>' . $dhlproducts['dhl_product_code'] . '</GlobalProductCode>
							<LocalProductCode>' . $dhlproducts['dhl_local_product'] . '</LocalProductCode>
							<Date>'.date('Y-m-d').'</Date>
							<Contents>' . $this->request->post['shipping_contents'] . '</Contents>
							<DoorTo>DD</DoorTo>
							<DimensionUnit>' . $length_code . '</DimensionUnit>
							<InsuredAmount>' . $this->request->post['insured_amount'] . '</InsuredAmount>
							<PackageType>' . $this->request->post['shipping_saffwebdhl_packagetype'] . '</PackageType>
							<IsDutiable>' . $dhlproducts['is_dutiable'] . '</IsDutiable>
							<CurrencyCode>' . $this->config->get('config_currency') . '</CurrencyCode>
						</ShipmentDetails>
						<Shipper>
							<ShipperID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</ShipperID>
							<CompanyName>' . $this->config->get('shipping_saffwebdhl_company_name') . '</CompanyName>
							<RegisteredAccount>' . $this->config->get('shipping_saffwebdhl_access_id') . '</RegisteredAccount>
							<AddressLine>' . $this->config->get('shipping_saffwebdhl_address_1') . '</AddressLine>
						    <AddressLine>' . $this->config->get('shipping_saffwebdhl_address_2') . '</AddressLine>
							<City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
							<Division>' . $this->config->get('shipping_saffwebdhl_division') . '</Division>
							<PostalCode>' . $this->config->get('shipping_saffwebdhl_postal_code') . '</PostalCode>
							<CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
							<CountryName>' . $shipper_country_name . '</CountryName>
							<Contact>
								<PersonName>' . $this->config->get('shipping_saffwebdhl_person_name') . '</PersonName>
								<PhoneNumber>' . $this->config->get('shipping_saffwebdhl_phone_number') . '</PhoneNumber>
								<PhoneExtension>' . $this->config->get('shipping_saffwebdhl_phone_extension') . '</PhoneExtension>
								<FaxNumber>' . $this->config->get('shipping_saffwebdhl_fax_number') . '</FaxNumber>
								<Email>' . $this->config->get('shipping_saffwebdhl_email') . '</Email>
							</Contact>
						</Shipper>
						' . $specialservice . '
						<Place>
							<ResidenceOrBusiness>B</ResidenceOrBusiness>
							<CompanyName>' . $this->config->get('shipping_saffwebdhl_company_name') . '</CompanyName>
							<AddressLine>' . $this->config->get('shipping_saffwebdhl_address_1') . '</AddressLine>
							<AddressLine>' . $this->config->get('shipping_saffwebdhl_address_2') . '</AddressLine>
							<City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
							<CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
							<DivisionCode>' . $this->config->get('shipping_saffwebdhl_division_code') . '</DivisionCode>
							<Division>' . $this->config->get('shipping_saffwebdhl_division') . '</Division>
							<PostalCode>' . $this->config->get('shipping_saffwebdhl_postal_code') . '</PostalCode>
							<PackageLocation>' . $this->request->post['package_location'] . '</PackageLocation>
						</Place>	
						<EProcShip>N</EProcShip>
						<LabelImageFormat>' . $this->config->get('shipping_saffwebdhl_label_image_format') . '</LabelImageFormat> 
					</req:ShipmentRequest>';
				}
				
				
				//AP - EM Region -Supports countries in Asia, Africa, Australia and Pacific.
				if($dhlregion == "AP"){
					$xml  = '<?xml version="1.0" encoding="UTF-8"?>
					<req:ShipmentRequest xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com ship-val-global-req.xsd" schemaVersion="5.0">
						' . $xml_request . '
						<RegionCode>AP</RegionCode>
						<LanguageCode>en</LanguageCode>
						<PiecesEnabled>Y</PiecesEnabled>
						<Billing>
							<ShipperAccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</ShipperAccountNumber>
							<ShippingPaymentType>' . $this->config->get('shipping_saffwebdhl_shipper_payment_type') . '</ShippingPaymentType>
							<DutyPaymentType>' . $this->config->get('shipping_saffwebdhl_duty_payment_type') . '</DutyPaymentType>
						</Billing>
						<Consignee>
							<CompanyName>' . $consignee_company . '</CompanyName>
							<AddressLine>' . $order_info['shipping_address_1'] . '</AddressLine>
							<AddressLine>' . $order_info['shipping_address_2'] . '</AddressLine>
							<City>' . $order_info['shipping_city'] . '</City>
							<PostalCode>' . $order_info['shipping_postcode'] . '</PostalCode>
							<CountryCode>' . $order_info['shipping_iso_code_2'] . '</CountryCode>
							<CountryName>' . $order_info['shipping_country'] . '</CountryName>
							<Contact>
								<PersonName>' . $consignee_name . '</PersonName>
								<PhoneNumber>' . $order_info['telephone'] . '</PhoneNumber>
								<PhoneExtension>' . $this->request->post['phone_extension'] . '</PhoneExtension>
								<Email>' . $order_info['email'] . '</Email>
							</Contact>
						</Consignee>
						<Commodity>
							<CommodityCode>cc</CommodityCode>
							<CommodityName>cm</CommodityName>
						</Commodity>
						<Dutiable>
							<DeclaredValue>' . round($order_info['total'], 0) . '</DeclaredValue>
							<DeclaredCurrency>' . $this->config->get('config_currency') . '</DeclaredCurrency>
							<ShipperEIN>' . $this->config->get('shipping_saffwebdhl_shipper_ein_ssn_number') . '</ShipperEIN>		
						</Dutiable>
						<Reference>
							<ReferenceID>' . $order_info['shipping_iso_code_2'] . ' Shipment on '.date('Y-m-d H:i:s').'</ReferenceID>
							<ReferenceType>St</ReferenceType>
						</Reference>
						<ShipmentDetails>
							<NumberOfPieces>' . $num_pieces . '</NumberOfPieces>
						    <Pieces>
						    ' . $the_pieces . '
						    </Pieces>
						    <Weight>' . $total_weight . '</Weight>
						    <WeightUnit>' . $weight_code . '</WeightUnit>
							<GlobalProductCode>' . $dhlproducts['dhl_product_code'] . '</GlobalProductCode>
							<LocalProductCode>' . $dhlproducts['dhl_local_product'] . '</LocalProductCode>
							<Date>'.date('Y-m-d').'</Date>
							<Contents>' . $this->request->post['shipping_contents'] . '</Contents>
							<DoorTo>DD</DoorTo>
							<DimensionUnit>' . $length_code . '</DimensionUnit>
							<InsuredAmount>' . $this->request->post['insured_amount'] . '</InsuredAmount>
							<PackageType>' . $this->request->post['shipping_saffwebdhl_packagetype'] . '</PackageType>
							<IsDutiable>' . $dhlproducts['is_dutiable'] . '</IsDutiable>
							<CurrencyCode>' . $this->config->get('config_currency') . '</CurrencyCode>
						</ShipmentDetails>
						<Shipper>
							<ShipperID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</ShipperID>
							<CompanyName>' . $this->config->get('shipping_saffwebdhl_company_name') . '</CompanyName>
							<AddressLine>' . $this->config->get('shipping_saffwebdhl_address_1') . '</AddressLine>
						    <AddressLine>' . $this->config->get('shipping_saffwebdhl_address_2') . '</AddressLine>
							<City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
							<DivisionCode>' . $this->config->get('shipping_saffwebdhl_division_code') . '</DivisionCode>
							<!--<PostalCode>' . $this->config->get('shipping_saffwebdhl_postal_code') . '</PostalCode>-->
							<CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
							<CountryName>' . $shipper_country_name . '</CountryName>
							<Contact>
								<PersonName>' . $this->config->get('shipping_saffwebdhl_person_name') . '</PersonName>
								<PhoneNumber>' . $this->config->get('shipping_saffwebdhl_phone_number') . '</PhoneNumber>
								<PhoneExtension>' . $this->config->get('shipping_saffwebdhl_phone_extension') . '</PhoneExtension>
								<FaxNumber>' . $this->config->get('shipping_saffwebdhl_fax_number') . '</FaxNumber>
								<Email>' . $this->config->get('shipping_saffwebdhl_email') . '</Email>
							</Contact>
						</Shipper>
						' . $specialservice . '
						<LabelImageFormat>' . $this->config->get('shipping_saffwebdhl_label_image_format') . '</LabelImageFormat>
					</req:ShipmentRequest>';
				}
				
				$dom = $this->process_xml($xml); //Process XML request to DHL
				if ($dom) {
					$thetimenow = time();
					$dhl_filename = $thetimenow.'-dhl-label.pdf'; //Create a name for the pdf file based on unix timestamp
					if(isset($dom->LabelImage[0]->OutputImage)){
						file_put_contents(DIR_IMAGE.'dhl/'.$dhl_filename, base64_decode($dom->LabelImage[0]->OutputImage));//Save label data in the database
						$data2 = array();
						$data2['order_id'] = $order_info['order_id'];
						$data2['label_title'] = $dom->ProductShortName;
						$data2['airway_bill_number'] = $dom->AirwayBillNumber;
						$data2['pdf_label'] =  $dhl_filename;
						$data2['image_label'] =  $dhl_filename;
						$data2['transaction_time'] = date('Y-m-d H:i:s');
		
						$this->model_extension_saffwebdhl->addDhlLabel($data2);
						$this->model_extension_saffwebdhl->updateCapability($this->request->post['shipping_saffwebdhl_dhl_product']);
					}
					else{
						$data['error_warning'] = "DHL Error. Check Log File";
					}
				} 
				 
			$this->response->redirect($this->url->link('extension/module/saffwebdhl/request_shipping', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_info['order_id'], true));
			 }

			$this->load->model('extension/saffwebdhl');
			$data['packagetype'] = $this->model_extension_saffwebdhl->getoptions(6);
			$data['isdutiable'] = $this->model_extension_saffwebdhl->getoptions(7);
	
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}
	
			if (isset($this->request->post['shipping_saffwebdhl_packagetype'])) {
				$data['shipping_saffwebdhl_packagetype'] = $this->request->post['shipping_saffwebdhl_packagetype'];
			}
			
			if (isset($this->request->post['shipping_saffwebdhl_isdutiable'])) {
				$data['shipping_saffwebdhl_isdutiable'] = $this->request->post['shipping_saffwebdhl_isdutiable'];
			}
			
			$data['duty_payment'] = $this->config->get('shipping_saffwebdhl_duty_payment_type');
			$data['dhlregion'] = $this->config->get('shipping_saffwebdhl_dhl_region');
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('extension/module/saffwebdhl_request_shipping', $data));
		} else {
			return new Action('error/not_found');
		}
	}

  /*
 * Deete the DHL Label from the system.
 */
  	public function delete_label() {
		$this->load->language('extension/module/saffwebdhl');
		$this->load->model('setting/setting');
		$this->load->model('extension/saffwebdhl');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['saffwebdhl_id'])) {
			$order_id = $this->model_extension_saffwebdhl->getOrderId($this->request->get['saffwebdhl_id']);
			$filename = $this->model_extension_saffwebdhl->getFilename($this->request->get['saffwebdhl_id']);
			$file = DIR_IMAGE.'dhl/'.$filename;
			unlink($file); //Delete file
			$this->model_extension_saffwebdhl->deleteLabel($this->request->get['saffwebdhl_id']); //Delete label
		} else {
			$order_id = 0;
		}

		$this->response->redirect($this->url->link('extension/module/saffwebdhl/request_shipping', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true));
	}


 /*
 * View Pickup Service from DHL.
 */
  	public function dhl_pickup() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->load->language('sale/order');
			$this->load->language('extension/module/saffwebdhl');
			$this->load->model('extension/saffwebdhl');
			$this->load->model('design/layout');
			$this->load->model('setting/setting');					

			$this->document->setTitle($this->language->get('heading_title'));
			$data['heading_title'] = $this->language->get('heading_title');
		
			$data['text_no_results'] = $this->language->get('text_no_results');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_pending'] = $this->language->get('text_pending');
			$data['text_booking_yes'] = $this->language->get('text_booking_yes');
			$data['text_booking_no'] = $this->language->get('text_booking_no');
			$data['text_book_modify_cancel'] = $this->language->get('text_book_modify_cancel');
			$data['text_modify_pickup'] = $this->language->get('text_modify_pickup');
			$data['text_cancel_pickup'] = $this->language->get('text_cancel_pickup');
			
			$data['button_book_pickup_service'] = $this->language->get('button_book_pickup_service');
			
			//Table columns
			$data['column_shipping_type'] = $this->language->get('column_shipping_type');
			$data['column_pickup_date'] = $this->language->get('column_pickup_date');
			$data['column_action_note'] = $this->language->get('column_action_note');
			$data['column_confirmation_number'] = $this->language->get('column_confirmation_number');
			$data['column_ready_by_time'] = $this->language->get('column_ready_by_time');
			$data['column_call_in_time'] = $this->language->get('column_call_in_time');
			$data['column_booking_cancelled'] = $this->language->get('column_booking_cancelled');
			$data['column_booking_action'] = $this->language->get('column_booking_action');

			$url = '';

			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['cancel'] = $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true);
			
			$data['book_pickup'] = $this->url->link('extension/module/saffwebdhl/book_pickup', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true);
			
			$data['user_token'] = $this->session->data['user_token'];
			$data['order_id'] = $this->request->get['order_id'];

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}
			
			//Get all labels for this order and showcase them.
			$data['allbookings'] = array();
			$bookings = $this->model_extension_saffwebdhl->getAllLabels($order_info['order_id']);
							
			foreach ($bookings as $booking) {
				$data['allbookings'][] = array(
					'saffwebdhl_id'       => $booking['saffwebdhl_id'],
					'order_id'            => $booking['order_id'],
					'shipping_type'       => $booking['label_title'],
					'pickup_date'         => $booking['pickup_date'],
					'action_note'         => $booking['booking_action_note'],
					'confirmation_number' => $booking['booking_confirmation_number'],
					'ready_by_time'       => $booking['booking_ready_by_time'],
					'call_in_time'        => $booking['booking_call_in_time'],
					'cancelled_pickup'    => $booking['cancelled_pickup'],

					'shipping_track'      => $this->url->link('extension/module/saffwebdhl/shipping_track', 'user_token=' . $this->session->data['user_token'] . '&saffwebdhl_id=' . $booking['saffwebdhl_id'], true),
					
					'modify_pickup'      => $this->url->link('extension/module/saffwebdhl/modify_pickup', 'user_token=' . $this->session->data['user_token'] . '&saffwebdhl_id=' . $booking['saffwebdhl_id'], true),
					
					'cancel_pickup'      => $this->url->link('extension/module/saffwebdhl/cancel_pickup', 'user_token=' . $this->session->data['user_token'] . '&saffwebdhl_id=' . $booking['saffwebdhl_id'], true)
				);
			}

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('extension/module/saffwebdhl_pickup', $data));
		} else {
			return new Action('error/not_found');
		}
	}


 /*
 * Request/Book Pickup Service from DHL.
 */
  	public function book_pickup() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->load->language('sale/order');
			$this->load->language('extension/module/saffwebdhl');
			$this->load->model('extension/saffwebdhl');
			$this->load->model('design/layout');

			$this->document->setTitle($this->language->get('heading_title'));
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_option'] = $this->language->get('text_option');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_pending'] = $this->language->get('text_pending');
			$data['text_book_pickup_header'] = $this->language->get('text_book_pickup_header');

			$data['entry_awb_number'] = $this->language->get('entry_awb_number');
			$data['entry_package_location'] = $this->language->get('entry_package_location');
			$data['entry_pickup_date'] = $this->language->get('entry_pickup_date');
			$data['entry_ready_by_time'] = $this->language->get('entry_ready_by_time');
			$data['entry_close_time'] = $this->language->get('entry_close_time');
			$data['entry_after_hours_closing_time'] = $this->language->get('entry_after_hours_closing_time');
			$data['entry_after_hours_location'] = $this->language->get('entry_after_hours_location');
			$data['entry_requestor_contact_name'] = $this->language->get('entry_requestor_contact_name');
			$data['entry_requestor_contact_phone'] = $this->language->get('entry_requestor_contact_phone');
			$data['entry_pickup_contact_name'] = $this->language->get('entry_pickup_contact_name');
			$data['entry_pickup_contact_phone'] = $this->language->get('entry_pickup_contact_phone');

			$data['help_package_location'] = $this->language->get('help_package_location');
			$data['help_after_hours_location'] = $this->language->get('help_after_hours_location');
			
			$data['button_book_pickup_service'] = $this->language->get('button_book_pickup_service');
			
			$url = '';

			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['cancel'] = $this->url->link('extension/module/saffwebdhl/dhl_pickup', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true);
			
			$data['user_token'] = $this->session->data['user_token'];
			$data['order_id'] = $this->request->get['order_id'];
			
			$this->load->model('setting/setting');
			$consignee_name = $order_info['shipping_firstname'].' '.$order_info['shipping_lastname'];
			$shipper_country_name =$this->model_extension_saffwebdhl->get_country_name($this->config->get('shipping_saffwebdhl_country_name'));
			
			$data['person_name'] = $this->config->get('shipping_saffwebdhl_person_name');
			$data['phone_number'] = $this->config->get('shipping_saffwebdhl_phone_number');
								
			//Get all AWB Numbers for this order.
			$data['alllawbs'] = $this->model_extension_saffwebdhl->getAllAirwayBills($order_info['order_id']);
			
		    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			    $record_id = $this->model_extension_saffwebdhl->getRecordID($this->request->post['awb_number']);//Get ID
			    $this->model_extension_saffwebdhl->bookPickup($record_id, $this->request->post);
				 
				$dhlservices = $this->model_extension_saffwebdhl->getSelectedCapability($order_info['order_id']);
				
				//Get all pieces for this order and showcase them.
				$pieces = $this->model_extension_saffwebdhl->getAllDhlPieces($order_info['order_id']);
				$num_pieces = $this->model_extension_saffwebdhl->countAllDhlPieces($order_info['order_id']);
				$total_weight = $this->model_extension_saffwebdhl->packageWeight($order_info['order_id']);

				$weight_code = strtoupper($this->weight->getUnit($this->config->get('shipping_saffwebdhl_weight_class_id')));
				if ($weight_code == 'KG') {
					$weight_code = 'K';
				}
				if ($weight_code == 'OZ') {
					$weight_code = 'O';
				}
				if ($weight_code == 'LB') {
					$weight_code = 'L';
				}
				
			    $length_code = strtoupper($this->length->getUnit($this->config->get('shipping_saffwebdhl_length_class_id')));
				if ($length_code == 'CM') {
					$length_code = 'C';
				}
				if ($length_code == 'IN') {
					$length_code = 'I';
				}
				if ($length_code == 'MM') {
					$length_code = 'M';
				}

				 //Process request to DHL
				$xml  = '<?xml version="1.0" encoding="UTF-8"?>
				<req:BookPURequest xsi:schemaLocation="http://www.dhl.com book-pickup-global-req.xsd" schemaVersion="1.0" xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
				   <Request>
					  <ServiceHeader>
						 <MessageTime>'.date('Y-m-d').'T09:30:47-05:00</MessageTime>
						 <MessageReference>Esteemed Courier Service of DHL</MessageReference>
						 <SiteID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</SiteID>
						 <Password>' . $this->config->get('shipping_saffwebdhl_password') . '</Password>
					  </ServiceHeader>
				   </Request>
				   <RegionCode>' . $this->config->get('shipping_saffwebdhl_dhl_region') . '</RegionCode>
				   <Requestor>
					  <AccountType>D</AccountType>
					  <AccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</AccountNumber>
					  <RequestorContact>
						 <PersonName>' . $this->request->post['requestor_contact_name'] . '</PersonName>
						 <Phone>' . $this->request->post['requestor_contact_phone'] . '</Phone>
					  </RequestorContact>
					  <CompanyName>' . $this->config->get('shipping_saffwebdhl_company_name') . '</CompanyName>
				   </Requestor>
				   <Place>
					  <LocationType>B</LocationType>
					  <CompanyName>' . $this->config->get('shipping_saffwebdhl_company_name') . '</CompanyName>
					  <Address1>' . $this->config->get('shipping_saffwebdhl_address_1') . '</Address1>
					  <Address2>' . $this->config->get('shipping_saffwebdhl_address_2') . '</Address2>
					  <PackageLocation>' . $this->request->post['package_location'] . '</PackageLocation>
					  <City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
					  <StateCode>' . $this->config->get('shipping_saffwebdhl_division_code') . '</StateCode>
					  <DivisionName>' . $this->config->get('shipping_saffwebdhl_division') . '</DivisionName>
					  <CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
					  <PostalCode>' . $this->config->get('shipping_saffwebdhl_postal_code') . '</PostalCode>
				   </Place>
				   <Pickup>
					  <PickupDate>' . $this->request->post['pickup_date'] . '</PickupDate>
					  <ReadyByTime>' . $this->request->post['ready_by_time'] . '</ReadyByTime>
					  <CloseTime>' . $this->request->post['close_time'] . '</CloseTime>
					  <AfterHoursClosingTime>' . $this->request->post['after_hours_closing_time'] . '</AfterHoursClosingTime>
					  <AfterHoursLocation>' . $this->request->post['after_hours_location'] . '</AfterHoursLocation>
					  <Pieces>' . $num_pieces . '</Pieces>
					  <weight>
						 <Weight>' . $total_weight . '</Weight>
						 <WeightUnit>' . $weight_code . '</WeightUnit>
					  </weight>
				   </Pickup>
				   <PickupContact>
					  <PersonName>' . $this->request->post['pickup_contact_name'] . '</PersonName>
					  <Phone>' . $this->request->post['pickup_contact_phone'] . '</Phone>
				   </PickupContact>
				   <ShipmentDetails>
					  <AWBNumber>' . $this->request->post['awb_number'] . '</AWBNumber>
					  <NumberOfPieces>' . $num_pieces . '</NumberOfPieces>
					  <Weight>' . $total_weight . '</Weight>
					  <WeightUnit>' . $weight_code . '</WeightUnit>
					  <GlobalProductCode>' . $dhlservices['dhl_product_code'] . '</GlobalProductCode>
					  <DoorTo>DD</DoorTo>
					  <DimensionUnit>' . $length_code . '</DimensionUnit>
					  <Pieces>
						 <Weight>' . $total_weight . '</Weight>
						 <Width>' . $this->config->get('shipping_saffwebdhl_width') . '</Width>
						 <Height>' . $this->config->get('shipping_saffwebdhl_height') . '</Height>
						 <Depth>' . $this->config->get('shipping_saffwebdhl_length') . '</Depth>
					  </Pieces>
				   </ShipmentDetails>
				</req:BookPURequest>';
				
				$dom = $this->process_xml($xml); //Process XML request to DHL
				if ($dom) {
					$data2 = array();
					$actionnote = $dom->Note->ActionNote;
					if ($actionnote == "Success"){$data2['booked_shipping'] = 1;}
					$data2['booking_action_note'] = $dom->Note->ActionNote;
					$data2['booking_confirmation_number'] = $dom->ConfirmationNumber;
					$data2['booking_ready_by_time'] = $dom->ReadyByTime;
					$data2['booking_call_in_time'] = $dom->CallInTime;
					$data2['cancelled_pickup'] = 0;
					
					$this->model_extension_saffwebdhl->bookPickupUpdate($record_id, $data2);
					
					$this->response->redirect($this->url->link('extension/module/saffwebdhl/dhl_pickup', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true));
			  } 
			  else {
				   return new Action('error/not_found');
			  }
			}
			
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}
		
			if (isset($this->error['package_location'])) {
				$data['error_package_location'] = $this->error['package_location'];
			} else {
				$data['error_package_location'] = '';
			}
			
			if (isset($this->error['pickup_date'])) {
				$data['error_pickup_date'] = $this->error['pickup_date'];
			} else {
				$data['error_pickup_date'] = '';
			}

			if (isset($this->error['ready_by_time'])) {
				$data['error_ready_by_time'] = $this->error['ready_by_time'];
			} else {
				$data['error_ready_by_time'] = '';
			}
			
			if (isset($this->error['requestor_contact_name'])) {
				$data['error_requestor_contact_name'] = $this->error['requestor_contact_name'];
			} else {
				$data['error_requestor_contact_name'] = '';
			}
			
			if (isset($this->error['requestor_contact_phone'])) {
				$data['error_requestor_contact_phone'] = $this->error['requestor_contact_phone'];
			} else {
				$data['error_requestor_contact_phone'] = '';
			}
			
			if (isset($this->error['pickup_contact_name'])) {
				$data['error_pickup_contact_name'] = $this->error['pickup_contact_name'];
			} else {
				$data['error_pickup_contact_name'] = '';
			}
			
			if (isset($this->error['pickup_contact_phone'])) {
				$data['error_pickup_contact_phone'] = $this->error['pickup_contact_phone'];
			} else {
				$data['error_pickup_contact_phone'] = '';
			}


			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('extension/module/saffwebdhl_book_pickup', $data));
		} else {
			return new Action('error/not_found');
		}
	}


 /*
 * Modify Pickup Service from DHL.
 */
  	public function modify_pickup() {
		$this->load->model('sale/order');
		$this->load->model('extension/saffwebdhl');
		$this->load->model('design/layout');
		$this->load->language('sale/order');
		$this->load->language('extension/module/saffwebdhl');

		if (isset($this->request->get['saffwebdhl_id'])) {
			$saffwebdhl_id = $this->request->get['saffwebdhl_id'];
			$order_id = $this->model_extension_saffwebdhl->getOrderId($this->request->get['saffwebdhl_id']);
		    $order_info = $this->model_sale_order->getOrder($order_id);
		} else {
			$order_id = 0;
			$order_info = "";
		}

		if ($order_info) {
			$this->document->setTitle($this->language->get('heading_title'));
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_option'] = $this->language->get('text_option');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_pending'] = $this->language->get('text_pending');
			$data['text_book_pickup_header'] = $this->language->get('text_book_pickup_header');

			$data['entry_awb_number'] = $this->language->get('entry_awb_number');
			$data['entry_package_location'] = $this->language->get('entry_package_location');
			$data['entry_pickup_date'] = $this->language->get('entry_pickup_date');
			$data['entry_ready_by_time'] = $this->language->get('entry_ready_by_time');
			$data['entry_close_time'] = $this->language->get('entry_close_time');
			$data['entry_after_hours_closing_time'] = $this->language->get('entry_after_hours_closing_time');
			$data['entry_after_hours_location'] = $this->language->get('entry_after_hours_location');
			$data['entry_requestor_contact_name'] = $this->language->get('entry_requestor_contact_name');
			$data['entry_requestor_contact_phone'] = $this->language->get('entry_requestor_contact_phone');
			$data['entry_pickup_contact_name'] = $this->language->get('entry_pickup_contact_name');
			$data['entry_pickup_contact_phone'] = $this->language->get('entry_pickup_contact_phone');

			$data['help_package_location'] = $this->language->get('help_package_location');
			$data['help_after_hours_location'] = $this->language->get('help_after_hours_location');
			
			$data['button_modify_pickup_service'] = $this->language->get('button_modify_pickup_service');
			
			$url = '';

			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['cancel'] = $this->url->link('extension/module/saffwebdhl/dhl_pickup', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true);
			
			$data['user_token'] = $this->session->data['user_token'];
			$data['order_id'] = $this->request->get['order_id'];
			
			
			$this->load->model('setting/setting');
			$consignee_name = $order_info['shipping_firstname'].' '.$order_info['shipping_lastname'];
			$shipper_country_name =$this->model_extension_saffwebdhl->get_country_name($this->config->get('shipping_saffwebdhl_country_name'));
			
			$data['person_name'] = $this->config->get('shipping_saffwebdhl_person_name');
			$data['phone_number'] = $this->config->get('shipping_saffwebdhl_phone_number');
								
			//Get all AWB Numbers for this order.
			$data['alllawbs'] = $this->model_extension_saffwebdhl->getAllAirwayBills($order_info['order_id']);
			
		    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			    $record_id = $this->model_extension_saffwebdhl->getRecordID($this->request->post['awb_number']);//Get ID
			 
			    $this->model_extension_saffwebdhl->bookPickup($record_id, $this->request->post);
				 
				 //Process request to DHL
				$xml  = '<?xml version="1.0" encoding="utf-8"?>
				<req:ModifyPURequest xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com modify-pickup-Global-req.xsd" schemaVersion="1.0">
				   <Request>
					  <ServiceHeader>
						 <MessageTime>'.date('Y-m-d').'T09:30:47-05:00</MessageTime>
						 <MessageReference>Esteemed Courier Service of DHL</MessageReference>
						 <SiteID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</SiteID>
						 <Password>' . $this->config->get('shipping_saffwebdhl_password') . '</Password>
					  </ServiceHeader>
				   </Request>
				   <RegionCode>' . $this->config->get('shipping_saffwebdhl_dhl_region') . '</RegionCode>
				   <ConfirmationNumber>' . $this->request->post['booking_confirmation_number'] . '</ConfirmationNumber>
				   <Requestor>
					  <AccountType>D</AccountType>
					  <AccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</AccountNumber>
					  <RequestorContact>
						 <PersonName>' . $this->request->post['requestor_contact_name'] . '</PersonName>
						 <Phone>' . $this->request->post['requestor_contact_phone'] . '</Phone>
					  </RequestorContact>
					  <CompanyName>' . $this->config->get('shipping_saffwebdhl_company_name') . '</CompanyName>
				   </Requestor>
				   <Place>
					  <LocationType>B</LocationType>
					  <CompanyName>' . $this->config->get('shipping_saffwebdhl_company_name') . '</CompanyName>
					  <Address1>' . $this->config->get('shipping_saffwebdhl_address_1') . '</Address1>
					  <Address2>' . $this->config->get('shipping_saffwebdhl_address_2') . '</Address2>
					  <PackageLocation>' . $this->request->post['package_location'] . '</PackageLocation>
					  <City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
					  <StateCode>' . $this->config->get('shipping_saffwebdhl_division_code') . '</StateCode>
					  <DivisionName>' . $this->config->get('shipping_saffwebdhl_division') . '</DivisionName>
					  <CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
					  <PostalCode>' . $this->config->get('shipping_saffwebdhl_postal_code') . '</PostalCode>
				   </Place>
				   <Pickup>
					  <PickupDate>' . $this->request->post['pickup_date'] . '</PickupDate>
					  <ReadyByTime>' . $this->request->post['ready_by_time'] . '</ReadyByTime>
					  <CloseTime>' . $this->request->post['close_time'] . '</CloseTime>
					  <AfterHoursClosingTime>' . $this->request->post['after_hours_closing_time'] . '</AfterHoursClosingTime>
					  <AfterHoursLocation>' . $this->request->post['after_hours_location'] . '</AfterHoursLocation>
				   </Pickup>
				   <PickupContact>
					  <PersonName>' . $this->request->post['pickup_contact_name'] . '</PersonName>
					  <Phone>' . $this->request->post['pickup_contact_phone'] . '</Phone>
				   </PickupContact>
				   <OriginSvcArea>PHX</OriginSvcArea>
				</req:ModifyPURequest>';
	
				$dom = $this->process_xml($xml); //Process XML request to DHL
				if ($dom) {
					$data2 = array();
					
					if($dom->Status->ActionStatus == "Error"){
						//issue error
					}
					if($dom->Note->ActionNote == "Success"){
						//$actionnote = $dom->Note->ActionNote;
						//if ($actionnote == "Success"){$data2['booked_shipping'] = 1;}
						$data2['booked_shipping'] = 1;
						$data2['booking_action_note'] = $dom->Note->ActionNote;
						$data2['booking_confirmation_number'] = $dom->ConfirmationNumber;
						$data2['booking_ready_by_time'] = $dom->ReadyByTime;
						$data2['booking_call_in_time'] = $dom->CallInTime;
						$data2['cancelled_pickup'] = 0;
						$this->model_extension_saffwebdhl->bookPickupUpdate($record_id, $data2);
					}
					
					$data['header'] = $this->load->controller('common/header');
					$data['column_left'] = $this->load->controller('common/column_left');
					$data['footer'] = $this->load->controller('common/footer');
					
					
					$this->response->redirect($this->url->link('extension/module/saffwebdhl/dhl_pickup', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true));
			  } 
			  else {
				   return new Action('error/not_found');
			  }
			}
		
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}
			
			if (isset($this->error['package_location'])) {
				$data['error_package_location'] = $this->error['package_location'];
			} else {
				$data['error_package_location'] = '';
			}
			
			if (isset($this->error['pickup_date'])) {
				$data['error_pickup_date'] = $this->error['pickup_date'];
			} else {
				$data['error_pickup_date'] = '';
			}

			if (isset($this->error['ready_by_time'])) {
				$data['error_ready_by_time'] = $this->error['ready_by_time'];
			} else {
				$data['error_ready_by_time'] = '';
			}
			
			if (isset($this->error['requestor_contact_name'])) {
				$data['error_requestor_contact_name'] = $this->error['requestor_contact_name'];
			} else {
				$data['error_requestor_contact_name'] = '';
			}
			
			if (isset($this->error['requestor_contact_phone'])) {
				$data['error_requestor_contact_phone'] = $this->error['requestor_contact_phone'];
			} else {
				$data['error_requestor_contact_phone'] = '';
			}
			
			if (isset($this->error['pickup_contact_name'])) {
				$data['error_pickup_contact_name'] = $this->error['pickup_contact_name'];
			} else {
				$data['error_pickup_contact_name'] = '';
			}
			
			if (isset($this->error['pickup_contact_phone'])) {
				$data['error_pickup_contact_phone'] = $this->error['pickup_contact_phone'];
			} else {
				$data['error_pickup_contact_phone'] = '';
			}
			
			
			//Get pickup data from db
			if (isset($saffwebdhl_id) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				$dhlrecord = $this->model_extension_saffwebdhl->getDhlRecord($saffwebdhl_id);
			}
			
			if (isset($this->request->post['awb_number'])) {
				$data['awb_number'] = $this->request->post['awb_number'];
			} else {	
				$data['awb_number'] = $dhlrecord['airway_bill_number'];
			}

			if (isset($this->request->post['package_location'])) {
				$data['package_location'] = $this->request->post['package_location'];
			} else {	
				$data['package_location'] = $dhlrecord['package_location'];
			}

			if (isset($this->request->post['pickup_date'])) {
				$data['pickup_date'] = $this->request->post['pickup_date'];
			} else {	
				$data['pickup_date'] = $dhlrecord['pickup_date'];
			}

			if (isset($this->request->post['ready_by_time'])) {
				$data['ready_by_time'] = $this->request->post['ready_by_time'];
			} else {	
				$data['ready_by_time'] = $dhlrecord['ready_by_time'];
			}

			if (isset($this->request->post['close_time'])) {
				$data['close_time'] = $this->request->post['close_time'];
			} else {	
				$data['close_time'] = $dhlrecord['close_time'];
			}
			
			if (isset($this->request->post['after_hours_closing_time'])) {
				$data['after_hours_closing_time'] = $this->request->post['after_hours_closing_time'];
			} else {	
				$data['after_hours_closing_time'] = $dhlrecord['after_hours_closing_time'];
			}

			if (isset($this->request->post['after_hours_location'])) {
				$data['after_hours_location'] = $this->request->post['after_hours_location'];
			} else {	
				$data['after_hours_location'] = $dhlrecord['after_hours_location'];
			}
			
			if (isset($this->request->post['requestor_contact_name'])) {
				$data['requestor_contact_name'] = $this->request->post['requestor_contact_name'];
			} else {	
				$data['requestor_contact_name'] = $dhlrecord['requestor_contact_name'];
			}

			if (isset($this->request->post['requestor_contact_phone'])) {
				$data['requestor_contact_phone'] = $this->request->post['requestor_contact_phone'];
			} else {	
				$data['requestor_contact_phone'] = $dhlrecord['requestor_contact_phone'];
			}

			if (isset($this->request->post['pickup_contact_name'])) {
				$data['pickup_contact_name'] = $this->request->post['pickup_contact_name'];
			} else {	
				$data['pickup_contact_name'] = $dhlrecord['pickup_contact_name'];
			}

			if (isset($this->request->post['pickup_contact_phone'])) {
				$data['pickup_contact_phone'] = $this->request->post['pickup_contact_phone'];
			} else {	
				$data['pickup_contact_phone'] = $dhlrecord['pickup_contact_phone'];
			}
			
			if (isset($this->request->post['booking_confirmation_number'])) {
				$data['booking_confirmation_number'] = $this->request->post['booking_confirmation_number'];
			} else {	
				$data['booking_confirmation_number'] = $dhlrecord['booking_confirmation_number'];
			}
			

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('extension/module/saffwebdhl_modify_pickup', $data));
		} else {
			return new Action('error/not_found');
		}
	}


 /*
 * Cancel Pickup Service from DHL.
 */
  	public function cancel_pickup() {
		$this->load->model('sale/order');
		$this->load->model('extension/saffwebdhl');
		$this->load->model('design/layout');
		$this->load->language('sale/order');
		$this->load->language('extension/module/saffwebdhl');

		if (isset($this->request->get['saffwebdhl_id'])) {
			$saffwebdhl_id = $this->request->get['saffwebdhl_id'];
			$order_id = $this->model_extension_saffwebdhl->getOrderId($this->request->get['saffwebdhl_id']);
		    $order_info = $this->model_sale_order->getOrder($order_id);
		} else {
			$order_id = 0;
			$order_info = "";
		}

		if ($order_info) {
			$this->document->setTitle($this->language->get('heading_title'));
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_option'] = $this->language->get('text_option');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_pending'] = $this->language->get('text_pending');
			$data['text_book_pickup_header'] = $this->language->get('text_book_pickup_header');

			$data['entry_awb_number'] = $this->language->get('entry_awb_number');
			$data['entry_requestor_contact_name'] = $this->language->get('entry_requestor_contact_name');
			$data['entry_cancel_reason'] = $this->language->get('entry_cancel_reason');
			
			$data['button_cancel_pickup_service'] = $this->language->get('button_cancel_pickup_service');
			
			$url = '';

			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['cancel'] = $this->url->link('extension/module/saffwebdhl/dhl_pickup', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true);
			
			$data['user_token'] = $this->session->data['user_token'];
			$data['order_id'] = $this->request->get['order_id'];
			
			
			$this->load->model('setting/setting');
			$consignee_name = $order_info['shipping_firstname'].' '.$order_info['shipping_lastname'];
			$shipper_country_name =$this->model_extension_saffwebdhl->get_country_name($this->config->get('shipping_saffwebdhl_country_name'));
			
			$data['person_name'] = $this->config->get('shipping_saffwebdhl_person_name');
			$data['phone_number'] = $this->config->get('shipping_saffwebdhl_phone_number');
								
			//Get all AWB Numbers for this order.
			$data['alllawbs'] = $this->model_extension_saffwebdhl->getAllAirwayBills($order_info['order_id']);
			
		    if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			    $record_id = $this->model_extension_saffwebdhl->getRecordID($this->request->post['awb_number']);//Get ID
				 
				 //Process request to DHL
				$xml  = '<?xml version="1.0" encoding="utf-8"?>
				<req:CancelPURequest xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com cancel-pickup-global-req.xsd" schemaVersion="1.0">
				   <Request>
					  <ServiceHeader>
						 <MessageTime>'.date('Y-m-d').'T09:30:47-05:00</MessageTime>
						 <MessageReference>Esteemed Courier Service of DHL</MessageReference>
						 <SiteID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</SiteID>
						 <Password>' . $this->config->get('shipping_saffwebdhl_password') . '</Password>
					  </ServiceHeader>
				   </Request>
				   <RegionCode>' . $this->config->get('shipping_saffwebdhl_dhl_region') . '</RegionCode>
				   <ConfirmationNumber>' . $this->request->post['booking_confirmation_number'] . '</ConfirmationNumber>
				   <RequestorName>' . $this->request->post['requestor_contact_name'] . '</RequestorName>
				   <CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
				   <Reason>' . $this->request->post['cancel_reason'] . '</Reason>
				   <PickupDate>' . $this->request->post['pickup_date'] . '</PickupDate>
				   <CancelTime>' . date("h:i") . '</CancelTime>
				   </req:CancelPURequest>';
	
				$dom = $this->process_xml($xml); //Process XML request to DHL
				if ($dom) {
					$data2 = array();
					$actionnote = $dom->Note->ActionNote;
					if ($actionnote == "Success"){$data2['booked_shipping'] = 0;}
					$data2['cancelled_pickup'] = 1;
					$data2['booking_action_note'] = "Cancelled";
					
					$this->model_extension_saffwebdhl->pickupCancelUpdate($record_id, $data2);
					
					$data['header'] = $this->load->controller('common/header');
					$data['column_left'] = $this->load->controller('common/column_left');
					$data['footer'] = $this->load->controller('common/footer');

					$this->response->redirect($this->url->link('extension/module/saffwebdhl/dhl_pickup', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true));
					
			  } 
			  else {
				   return new Action('error/not_found');
			  }
			}
			
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}
		
			//Get pickup data from db
			if (isset($saffwebdhl_id) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				$dhlrecord = $this->model_extension_saffwebdhl->getDhlRecord($saffwebdhl_id);
			}
			
			if (isset($this->request->post['awb_number'])) {
				$data['awb_number'] = $this->request->post['awb_number'];
			} else {	
				$data['awb_number'] = $dhlrecord['airway_bill_number'];
			}

			if (isset($this->request->post['pickup_date'])) {
				$data['pickup_date'] = $this->request->post['pickup_date'];
			} else {	
				$data['pickup_date'] = $dhlrecord['pickup_date'];
			}

			if (isset($this->request->post['requestor_contact_name'])) {
				$data['requestor_contact_name'] = $this->request->post['requestor_contact_name'];
			} else {	
				$data['requestor_contact_name'] = $dhlrecord['requestor_contact_name'];
			}
			
			if (isset($this->request->post['booking_confirmation_number'])) {
				$data['booking_confirmation_number'] = $this->request->post['booking_confirmation_number'];
			} else {	
				$data['booking_confirmation_number'] = $dhlrecord['booking_confirmation_number'];
			}
			

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('extension/module/saffwebdhl_cancel_pickup', $data));
		} else {
			return new Action('error/not_found');
		}
	}


 /*
 * Track Shipping Service from DHL.
DHL tracking link : http://www.dhl.com/en/express/tracking.shtml?AWB=0057934424&brand=DHL
 */
  	public function track_shipping() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->load->language('sale/order');
			$this->load->language('extension/module/saffwebdhl');
			$this->load->model('extension/saffwebdhl');
			$this->load->model('design/layout');

			$this->document->setTitle($this->language->get('heading_title'));
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_track_header'] = $this->language->get('text_track_header');

			$data['entry_awb_number'] = $this->language->get('entry_awb_number');
			$data['entry_detail_level'] = $this->language->get('entry_detail_level');
			
			$data['column_awb_number'] = $this->language->get('column_awb_number');
			$data['column_customer_link'] = $this->language->get('column_customer_link');
			$data['column_tracking_action'] = $this->language->get('column_tracking_action');
			
			$data['button_track'] = $this->language->get('button_track');
			
			$url = '';

			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['cancel'] = $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true);
			
			$data['user_token'] = $this->session->data['user_token'];
			$data['order_id'] = $this->request->get['order_id'];
			
			$this->load->model('setting/setting');
											
			//Get all AWB Numbers for this order.
			$data['alllawbs'] = $this->model_extension_saffwebdhl->getAllAirwayBills($order_info['order_id']);
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('extension/module/saffwebdhl_track_shipping', $data));
		} else {
			return new Action('error/not_found');
		}
	}

 

 /*
 * Generate Labels from DHL.
 */
  	public function shipping_pieces() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->load->language('sale/order');
			$this->load->language('extension/module/saffwebdhl');
			$this->load->model('extension/saffwebdhl');
			$this->load->model('design/layout');

			$this->document->setTitle($this->language->get('heading_title'));
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_no_results'] = $this->language->get('text_no_results');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_shipping_pieces'] = $this->language->get('text_shipping_pieces');
			$data['text_add_pieces'] = $this->language->get('text_add_pieces');
			$data['text_delete_piece'] = $this->language->get('text_delete_piece');
			
			$data['entry_piece'] = $this->language->get('entry_piece');
			$data['entry_height'] = $this->language->get('entry_height');
			$data['entry_depth'] = $this->language->get('entry_depth');
			$data['entry_width'] = $this->language->get('entry_width');
			$data['entry_weight'] = $this->language->get('entry_weight');
			
			//Order table columns
			$data['column_piece'] = $this->language->get('column_piece');
			$data['column_height'] = $this->language->get('column_height');
			$data['column_depth'] = $this->language->get('column_depth');
			$data['column_width'] = $this->language->get('column_width');
			$data['column_weight'] = $this->language->get('column_weight');
			$data['column_pieces_action'] = $this->language->get('column_pieces_action');

			$url = '';

			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/saffwebdhl', 'user_token=' . $this->session->data['user_token'], true)
			);
	
			$data['cancel'] = $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true);
			
			$data['user_token'] = $this->session->data['user_token'];
			$data['order_id'] = $this->request->get['order_id'];
			

			//Get all pieces for this order and showcase them.
			$data['allpieces'] = array();
			$pieces = $this->model_extension_saffwebdhl->getAllDhlPieces($order_info['order_id']);
							
			foreach ($pieces as $piece) {
				$data['allpieces'][] = array(
					'piece_id'     => $piece['piece_id'],
					'order_id'     => $piece['order_id'],
					'height'       => $piece['height'],
					'depth'        => $piece['depth'],
					'width'        => $piece['width'],
					'weight'       => $piece['weight'],
					'delete_piece' => $this->url->link('extension/module/saffwebdhl/delete_piece', 'user_token=' . $this->session->data['user_token'] . '&piece_id=' .  $piece['piece_id']. '&order_id=' .  $order_info['order_id'], true)
				);
			}
			
			 if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate_pieces()) {
				//Save piece data in the database
				$data2 = array();
				$data2['order_id'] = $order_info['order_id'];
				$data2['height']   = $this->request->post['height'];
				$data2['depth']    = $this->request->post['depth'];
				$data2['width']    = $this->request->post['width'];
				$data2['weight']   = $this->request->post['weight'];
				$this->model_extension_saffwebdhl->addDhlPieces($data2);
			 
			    $this->response->redirect($this->url->link('extension/module/saffwebdhl/shipping_pieces', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_info['order_id'], true));
			 }

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}
		
			if (isset($this->error['height'])) {
				$data['error_height'] = $this->error['height'];
			} else {
				$data['error_height'] = '';
			}

			if (isset($this->error['depth'])) {
				$data['error_depth'] = $this->error['depth'];
			} else {
				$data['error_depth'] = '';
			}

			if (isset($this->error['width'])) {
				$data['error_width'] = $this->error['width'];
			} else {
				$data['error_width'] = '';
			}

			if (isset($this->error['weight'])) {
				$data['error_weight'] = $this->error['weight'];
			} else {
				$data['error_weight'] = '';
			}


			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('extension/module/saffwebdhl_pieces', $data));
		} else {
			return new Action('error/not_found');
		}
	}

  /*
 * Deete the DHL Piece from the system
 */
  	public function delete_piece() {
		$this->load->language('extension/module/saffwebdhl');
		$this->load->model('setting/setting');
		$this->load->model('extension/saffwebdhl');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['piece_id'])) {
			$order_id = $this->request->get['order_id'];
			$this->model_extension_saffwebdhl->deleteDhlPiece($this->request->get['piece_id']); //Delete Piece
		} else {
			$order_id = 0;
		}
		$this->response->redirect($this->url->link('extension/module/saffwebdhl/shipping_pieces', 'user_token=' . $this->session->data['user_token'] . '&order_id=' .  $order_id, true));
	}
 
 
 /*
 * Process XML Request to DHL
 */
  	public function process_xml($xml) {
		$this->load->model('extension/saffwebdhl');
		$this->load->model('setting/setting');

		if ($this->config->get('shipping_saffwebdhl_test_mode') == 1) { // Test Mode
			$url = 'https://xmlpitest-ea.dhl.com/XMLShippingServlet';
		} else { //Production (Live) Mode
			$url = 'https://xmlpi-ea.dhl.com/XMLShippingServlet';
		}

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
		$result = curl_exec($curl);
		curl_close($curl);
		
		$error = '';
		$quote_data = array();

		if ($result) {
			if ($this->config->get('shipping_saffwebdhl_log_dhlxml') == 1) { // Log/Save DHL Request & Response
				$log = new Log('saffwebdhl.log');
				$log->write("DHL DATA SENT: " . $xml); //Create  a log record of what is sent to DHL
				$log->write("DHL DATA RECEIVED: " . $result); //Create  a log record of what is received from DHL
			}
			$dom = new SimpleXMLElement($result);
			return $dom;
	  } 
	  else {
		   return new Action('error/not_found');
	  }
	}
	
 /*
 * Validate Input Data
 */
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/saffwebdhl')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['package_location']) {
			$this->error['package_location'] = $this->language->get('error_package_location');
		}
		if (!$this->request->post['pickup_date']) {
			$this->error['pickup_date'] = $this->language->get('error_pickup_date');
		}
		if (!$this->request->post['ready_by_time']) {
			$this->error['ready_by_time'] = $this->language->get('error_ready_by_time');
		}
		if (!$this->request->post['requestor_contact_name']) {
			$this->error['requestor_contact_name'] = $this->language->get('error_requestor_contact_name');
		}
		if (!$this->request->post['requestor_contact_phone']) {
			$this->error['requestor_contact_phone'] = $this->language->get('error_requestor_contact_phone');
		}
		if (!$this->request->post['pickup_contact_name']) {
			$this->error['pickup_contact_name'] = $this->language->get('error_pickup_contact_name');
		}
		if (!$this->request->post['pickup_contact_phone']) {
			$this->error['pickup_contact_phone'] = $this->language->get('error_pickup_contact_phone');
		}

		return !$this->error;
	}
	
	protected function validate_pieces() {
		if (!$this->user->hasPermission('modify', 'extension/module/saffwebdhl')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['height']) {
			$this->error['height'] = $this->language->get('error_height');
		}
		if (!$this->request->post['depth']) {
			$this->error['depth'] = $this->language->get('error_depth');
		}
		if (!$this->request->post['width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		if (!$this->request->post['weight']) {
			$this->error['weight'] = $this->language->get('error_weight');
		}

		return !$this->error;
	}
}
?>