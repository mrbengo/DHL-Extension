<?php
class ModelExtensionShippingSaffwebdhl extends Model {
	function getQuote($address) {
		$this->load->language('extension/shipping/saffwebdhl');
		
      	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('saffwebdhl_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

      	if (!$this->config->get('saffwebdhl_geo_zone_id')) {
        	$status = true;
      	} elseif ($query->num_rows) {
        	$status = true;
      	} else {
        	$status = false;
      	}
		
		$method_data = array();
		
	    if ($status) {
			
			$weight = $this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->config->get('shipping_saffwebdhl_weight_class_id'));
			$weight_code = strtoupper($this->weight->getUnit($this->config->get('shipping_saffwebdhl_weight_class_id')));

			if ($weight_code == 'KGS' || $weight_code == 'KG') {
				$weight_code = 'KG';
			}

			if ($weight_code == 'LBS') {
				$weight_code = 'LB';
			}
			
			$cartweight = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			
			$this->load->model('localisation/country');

			$country_info = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));

			$this->load->model('localisation/zone');

			$zone_info = $this->model_localisation_zone->getZone($this->config->get('config_zone_id'));
			
			$length_code = strtoupper($this->length->getUnit($this->config->get('shipping_saffwebdhl_length_class_id')));
			
			$x = 0;
			$the_pieces = '';
			$servicecode = '';
			$title = '';
			$cost = 0;
			$currency = '';
			
			$data['products'] = array();
			$products = $this->cart->getProducts();
			foreach ($products as $product) {
			  $x++;
			  $the_pieces.=
			  '<Piece>
				 <PieceID>' . $x . '</PieceID>
				 <Height>' . intval($product['height']) . '</Height>
				 <Depth>' . intval($product['length']) . '</Depth>
				 <Width>' . intval($product['width']) . '</Width>
				 <Weight>' . intval($product['weight']) . '</Weight>
			  </Piece>';
			}
			
			if($this->config->get('shipping_saffwebdhl_duty_payment_type') == 'R'){
				$payment_cc = $address['iso_code_2'];
			}
			else{
				$payment_cc = $this->config->get('shipping_saffwebdhl_country_code');
			}
			
			$dhlimage = "<img src=".(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/image/dhl_logo.png".">";

			$error = '';
			$quote_data = array();
		
			//Loop through each capability and get DHL fee (Quote)
			//Check if Domestic DHL Shipping
			if($this->config->get('shipping_saffwebdhl_country_code') == $address['iso_code_2']){
				$i = 0;
                $domestic = implode(',', $this->config->get('shipping_saffwebdhl_dhl_domestic'));
				$services = explode(',', $domestic); 
				foreach($services as $key) { 
				   $i++;   
				   $dhlproduct = $this->getDhlProduct($key);
					//Process DHL is non-dutible
					$xml  = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
					<p:DCTRequest xmlns:p="http://www.dhl.com" xmlns:p1="http://www.dhl.com/datatypes" xmlns:p2="http://www.dhl.com/DCTRequestdatatypes" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com DCT-req.xsd ">
					  <GetQuote>
						<Request>
						  <ServiceHeader>
							<MessageTime>'.date('c').'</MessageTime>
							<MessageReference>1234567890123456789012345678901</MessageReference>
								<SiteID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</SiteID>
								<Password>' . $this->config->get('shipping_saffwebdhl_password') . '</Password>
						  </ServiceHeader>
						</Request>
						<From>
						  <CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
						  <City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
						</From>
						<BkgDetails>
						  <PaymentCountryCode>' . $payment_cc . '</PaymentCountryCode>
						  <Date>' . date('Y-m-d') . '</Date>
						  <ReadyTime>PT10H21M</ReadyTime>
						  <ReadyTimeGMTOffset>+01:00</ReadyTimeGMTOffset>
						  <DimensionUnit>' . $length_code . '</DimensionUnit>
						  <WeightUnit>' . $weight_code . '</WeightUnit>
						  <Pieces>
							<Piece>
							  <PieceID>1</PieceID>
							  <Height>' . $this->config->get('shipping_saffwebdhl_height') . '</Height>
							  <Depth>' . $this->config->get('shipping_saffwebdhl_length') . '</Depth>
							  <Width>' . $this->config->get('shipping_saffwebdhl_width') . '</Width>
							  <Weight>' . $weight . '</Weight>
							</Piece>
						  </Pieces> 
							 <PaymentAccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</PaymentAccountNumber>
							<IsDutiable>N</IsDutiable>
							  <NetworkTypeCode>' . $dhlproduct['network_type_code'] . '</NetworkTypeCode>
								 <QtdShp>
									  <GlobalProductCode>' . $dhlproduct['global_product_code'] . '</GlobalProductCode>
									<LocalProductCode>' . $dhlproduct['local_product_code'] . '</LocalProductCode>            
								 </QtdShp>
							</BkgDetails>
							<To>
							  <CountryCode>' . $address['iso_code_2'] . '</CountryCode>
							  <Postalcode>' . $address['postcode'] . '</Postalcode>
							  <City>' . $address['city'] . '</City>
							</To>
					  </GetQuote>
					</p:DCTRequest>';
				
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
					
					if ($result) {
						if ($this->config->get('shipping_saffwebdhl_log_dhlxml') == 1) { // Log/Save DHL Request & Response
							$log = new Log('saffwebdhl.log');
							$log->write("DHL DATA SENT: " . $xml); //Create  a log record of what is sent to DHL
							$log->write("DHL DATA RECEIVED: " . $result); //Create  a log record of what is received from DHL
						}
						
						$xmlresult = new SimpleXMLElement($result);
						if(isset($xmlresult->GetQuoteResponse->Note->Condition->ConditionCode)){
							// Show nothing
						}

						if(!isset($xmlresult->GetQuoteResponse->Note->Condition->ConditionCode)){
							$dom = new DOMDocument('1.0', 'UTF-8');
							$dom->loadXml($result);
							
							if($dom->getElementsByTagName('QtdShp')->item(0)){
								$service = $dom->getElementsByTagName('QtdShp')->item(0);
								$servicecode = $service->getElementsByTagName('GlobalProductCode')->item(0)->nodeValue;
								$title = $this->language->get('text_dhl_' . $servicecode);
								$cost = $service->getElementsByTagName('ShippingCharge')->item(0)->nodeValue;
								$currency = $service->getElementsByTagName('CurrencyCode')->item(0)->nodeValue;
								
								$quote_data['saffwebdhl'][$i] = array(
									'code'         => 'saffwebdhl.'.$i,
									'title'        => $dhlimage." ".$title,
									'cost'         => $this->currency->convert($cost, $currency, $this->config->get('config_currency')),
									'tax_class_id' => $this->config->get('shipping_saffwebdhl_tax_class_id'),
									'text'         => $this->currency->format($this->tax->calculate($this->currency->convert($cost, $currency, $this->config->get('config_currency')), $this->config->get('shipping_saffwebdhl_tax_class_id'), $this->config->get('config_tax')), $this->config->get('config_currency'), 1.0000000)
								);
							}
						}
					}
				}
			}
			
			//If International DHL Shipping
			else{
				$j = 0;
                $international = implode(',', $this->config->get('shipping_saffwebdhl_dhl_international'));
				$services = explode(',', $international); 
				foreach($services as $key) { 
			  	    $j++;   
				    $dhlproduct = $this->getDhlProduct($key);
					//Process DHL is dutible
					$xml  = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
					<p:DCTRequest xmlns:p="http://www.dhl.com" xmlns:p1="http://www.dhl.com/datatypes" xmlns:p2="http://www.dhl.com/DCTRequestdatatypes" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com DCT-req.xsd ">
					  <GetQuote>
						<Request>
						  <ServiceHeader>
							<MessageTime>'.date('c').'</MessageTime>
							<MessageReference>1234567890123456789012345678901</MessageReference>
								<SiteID>' . $this->config->get('shipping_saffwebdhl_access_id') . '</SiteID>
								<Password>' . $this->config->get('shipping_saffwebdhl_password') . '</Password>
						  </ServiceHeader>
						</Request>
						<From>
						  <CountryCode>' . $this->config->get('shipping_saffwebdhl_country_code') . '</CountryCode>
						  <City>' . $this->config->get('shipping_saffwebdhl_city') . '</City>
						</From>
						<BkgDetails>
						  <PaymentCountryCode>' . $payment_cc . '</PaymentCountryCode>
						  <Date>' . date('Y-m-d') . '</Date>
						  <ReadyTime>PT10H21M</ReadyTime>
						  <ReadyTimeGMTOffset>+01:00</ReadyTimeGMTOffset>
						  <DimensionUnit>' . $length_code . '</DimensionUnit>
						  <WeightUnit>' . $weight_code . '</WeightUnit>
						  <Pieces>
							<Piece>
							  <PieceID>1</PieceID>
							  <Height>' . $this->config->get('shipping_saffwebdhl_height') . '</Height>
							  <Depth>' . $this->config->get('shipping_saffwebdhl_length') . '</Depth>
							  <Width>' . $this->config->get('shipping_saffwebdhl_width') . '</Width>
							  <Weight>' . $weight . '</Weight>
							</Piece>
						  </Pieces> 
							 <PaymentAccountNumber>' . $this->config->get('shipping_saffwebdhl_account_number') . '</PaymentAccountNumber>
							<IsDutiable>Y</IsDutiable>
							  <NetworkTypeCode>' . $dhlproduct['network_type_code'] . '</NetworkTypeCode>
								 <QtdShp>
									  <GlobalProductCode>' . $dhlproduct['global_product_code'] . '</GlobalProductCode>
									<LocalProductCode>' . $dhlproduct['local_product_code'] . '</LocalProductCode>             
								 </QtdShp>
							</BkgDetails>
							<To>
							  <CountryCode>' . $address['iso_code_2'] . '</CountryCode>
							  <Postalcode>' . $address['postcode'] . '</Postalcode>
							  <City>' . $address['city'] . '</City>
							</To>
						   <Dutiable>
							  <DeclaredCurrency>' . $this->session->data['currency'] . '</DeclaredCurrency>
							  <DeclaredValue>' . $this->currency->format($this->cart->getSubTotal(), $this->session->data['currency'], false, false) . '</DeclaredValue>
							</Dutiable>
						</GetQuote>
					</p:DCTRequest>';
					
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
	
					if ($result) {
						if ($this->config->get('shipping_saffwebdhl_log_dhlxml') == 1) { // Log/Save DHL Request & Response
							$log = new Log('saffwebdhl.log');
							$log->write("DHL DATA SENT: " . $xml); //Create  a log record of what is sent to DHL
							$log->write("DHL DATA RECEIVED: " . $result); //Create  a log record of what is received from DHL
						}
						
						$xmlresult = new SimpleXMLElement($result);
						if(isset($xmlresult->GetQuoteResponse->Note->Condition->ConditionCode)){
							// Show nothing
						}

						if(!isset($xmlresult->GetQuoteResponse->Note->Condition->ConditionCode)){
							$dom = new DOMDocument('1.0', 'UTF-8');
							$dom->loadXml($result);
							
							if($dom->getElementsByTagName('QtdShp')->item(0)){
								$service = $dom->getElementsByTagName('QtdShp')->item(0);
								$servicecode = $service->getElementsByTagName('GlobalProductCode')->item(0)->nodeValue;
								$title = $this->language->get('text_dhl_' . $servicecode);
								$cost = $service->getElementsByTagName('ShippingCharge')->item(0)->nodeValue;
								$currency = $service->getElementsByTagName('CurrencyCode')->item(0)->nodeValue;
	
								$quote_data['saffwebdhl'][$j] = array(
									'code'         => 'saffwebdhl.'.$j,
									'title'        => $dhlimage." ".$title,
									'cost'         => $this->currency->convert($cost, $currency, $this->config->get('config_currency')),
									'tax_class_id' => $this->config->get('shipping_saffwebdhl_tax_class_id'),
									'text'         => $this->currency->format($this->tax->calculate($this->currency->convert($cost, $currency, $this->config->get('config_currency')), $this->config->get('shipping_saffwebdhl_tax_class_id'), $this->config->get('config_tax')), $this->config->get('config_currency'), 1.0000000)
								);
							}
						}
					 }
				}
			}

			/*
			//AM Region – Americas
			$countries = explode(',', 'AG,AI,AR,AW,BB,BM,BO,BR,BS,CA,CL,CO,CR,DM,DO,EC,GD,GF,GP,GT,GU,GY,HN,HT,JM,KN,KY,LC,MQ,MX,NI,PA,PE,PR,PY,SR,SV,TC,TT,US,UY,VC,VE,VG,XC,XM,XN,XY');
			
			//EA/EU Region – Europe
			$countries = explode(',', 'AT,BE,BG,CH,CZ,DE,DK,EE,ES,FI,FR,GB,GR,HU,IE,IS,IT,LT,LU,LV,NL,NO,PL,PT,RO,SE,SI,SK');
			
			
			//AP Region – Asia Pacific, Middle East & Africa
			$countries = explode(',', 'AE,AF,AL,AM,AU,BA,BD,BH,BN,BY,CI,CN,CY,DZ,EG,FJ,GH,HK,HR,ID,IL,IN,IQ,IR,JO,JP,KE,KG,KR,KW,KZ,LA,LB,LK,MA,MD,MK,MM,MT,MU,MY,NA,NG,NP,NZ,OM,PH,PK,QA,RE,RS,RU,SA,SD,SG,SN,SY,TH,TJ,TR,TW,UA,UZ,VN,YE,ZA');
			*/
			$title = $this->language->get('text_title');

			if ($this->config->get('shipping_saffwebdhl_display_weight')) {
				$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('shipping_saffwebdhl_weight_class_id')) . ')';
			}

			if ($quote_data || $error) {
				foreach ($quote_data as $row) {
				  $method_data = array(
					'code'       => 'saffwebdhl',
					'title' 	  => $title,
					'quote'      => $row,
					'sort_order' => $this->config->get('shipping_saffwebdhl_sort_order'),
					'error'      => $error
				  );
				}
			}
		}

		return $method_data;
	}

	public function getDhlProduct($record_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "saffwebdhl_products WHERE id = '" . (int)$record_id . "'");
		return $query->row;
	}
}
?>