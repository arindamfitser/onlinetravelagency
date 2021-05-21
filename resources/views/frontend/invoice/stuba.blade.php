<?php
$xmldata = unserialize($booking->xml_data);
			 	$hotelbooking = $xmldata['Booking']['HotelBooking'];
		    			$totalsellingprice=0;
		    			$totalprice =0;
		    			$hotelname ='';
		    			if(isset($hotelbooking[0])){
		    			    foreach($hotelbooking as $hotelbook){
		    			        $nightcost[] = $hotelbook['Room']['NightCost'];
		    			        $totalsellingprice =$totalsellingprice + $hotelbook['Room']['TotalSellingPrice']['@attributes']['amt']; 
		    			        $hotel_id =$hotelbook['HotelId'];
		    			        $hotelname =$hotelbook['HotelName'];
		    			    }
		    			}else{
		    			  $hotelname =$xmldata['Booking']['HotelBooking']['HotelName'];
		    			  $nightcost = $hotelbooking['Room']['NightCost'];
		    			  $totalsellingprice = number_format((float) $hotelbooking['Room']['TotalSellingPrice']['@attributes']['amt'], 2); 
		    			  $hotel_id =$xmldata['Booking']['HotelBooking']['HotelId'];
		    			}
		    $totalprice = $totalsellingprice;
		    $totalsellingprice = number_format((float) $totalsellingprice, 2);
?>
<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Luxury Fishing Booking Invoice</title>
	</head>
	<body>
		<div style="margin: 0 auto;display: block;max-width: 100%; text-align: center;">
			<a style="display: block;" href="index.html"><img style="" src="{{ public_path('frontend/hotelier/images/logo.jpg') }}" alt="" /></a>
		</div>
		<br>
		<center>
		
		<table style="border:2px solid #000;; border-spacing: 0px;border-collapse: separate; width:728px; margin: 100px auto; 0 auto;">
			<tbody>
				<tr>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0">
							
							<tbody width="100%">
								<tr><td style="padding: 5px 20px;">Dear <?php echo $users['first_name']; ?>,</td></tr>
								<tr><td style="padding: 5px 20px;">We are glad to have the chance to host you again. We confirm that <strong><?php echo $totalprice; ?> <?php echo $booking['name']; ?> at <?php echo getRoomxmlHotelData('hotelName',$booking->hotel_id); ?></strong> has been reserved under your name.</td> </tr>
								<tr><td style="padding: 5px 20px;"> At <?php echo getRoomxmlHotelData('hotelName',$booking->hotel_id); ?>, you can always expect to be welcomed to a beautiful living space, whether it’s a hotel next door or a far off location. </td></tr>
							
				</tbody>
			</table>
			<div style="background: #d7b956;color:#fff;font-size: 19px; margin: 20px 20px 0 20px;"><div style="padding: 6px 20px;">Booking Details</div></div>		
			<table width="100%" cellpadding="0" cellspacing="0" class="tbl2" style="padding: 0 20px;">
				<tbody>
					<tr>
						<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>BOOKING ID:</strong> <?php echo $booking['xml_booking_id']; ?> </td>
						<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>CHECK-IN -</strong> <?php echo date('jS F\'y ', strtotime($booking['start_date'])); ?> </td>
						<td style="border-bottom: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>CHECK-OUT -</strong> <?php echo date('jS F\'y ', strtotime($booking['end_date'])); ?> </td>
					</tr>
					<tr>
						<td style="border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>ADDRESS -</strong> <?php echo getRoomxmlHotelData('hotelAddress',$booking->hotel_id); ?> </td>
						<td style="border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;"></td>
						<td style="border-right: none;border:1px solid #ccc;padding: 15px;margin: 2px;"><strong>Total payment to be made -</strong> <?php echo $totalprice; ?> </td>
					</tr>
				</tbody>
			</table>
			<table style="width: 100%; border: none; border-spacing: 0px;border-collapse: separate; width:100%;">
				<tbody><tr style="padding-top:0;">
					<td style="text-align: center;vertical-align: top;">
						<table style="border: none; border-spacing: 0px;border-collapse: separate; width:100%; background-color: #fff;padding: 10px 20px;">
							<tbody><tr>
								<td>&nbsp;</td>
								
								<td>&nbsp;</td>
							</tr>
						</tbody></table></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" class="tbl2" style="padding: 0 20px;">
		          
		            <thead>
		                <tr>  
		            	    <th style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;" class="text-center">Nights</th>
		            		<th style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;" class="text-center">Price</th>
		            	</tr>
		            </thead>

		       <tbody>';
                  <?php 
                  $html ='';
			 		if(isset($hotelbooking[0])){
				     foreach($hotelbooking as $k=>$htelbook){
				         if($hotelbooking[$k]['Nights']>1){
							$html .= '<tr>
								<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;">'.$hotelbooking[$k]["Room"]["RoomType"]["@attributes"]["text"].'-'.$hotelbooking[$k]["Nights"].' Night</td>
								<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;">'. $xmldata['Currency'].number_format((float) $hotelbooking[$k]["Room"]["TotalSellingPrice"]["@attributes"]["amt"], 2).'</td>
							</tr>';
						}else{
							$html .= '<tr>
								<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;">'.$hotelbooking[$k]["Room"]["RoomType"]["@attributes"]["text"].' -1 Night</td>
								<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;">'.$xmldata["Currency"].number_format((float) $hotelbooking[$k]["Room"]["TotalSellingPrice"]["@attributes"]["amt"], 2).'</td>
							</tr>';
						
						}
				     }
				 }else{ 
					if($hotelbooking['Nights']>1){
						for ($i=0; $i < count($nightcost) ; $i++) {
							$html .= '<tr>
								<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;">'.$hotelbooking["Room"]["RoomType"]["@attributes"]["text"].'-'.($nightcost[$i]["Night"]+1).' Night</td>
								<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;">'.$xmldata["Currency"].number_format((float) $nightcost[$i]["SellingPrice"]["@attributes"]["amt"], 2).'</td>
							</tr>';
					}  
					}else{
						$html .= '<tr>
							<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;">'.$hotelbooking["Room"]["RoomType"]["@attributes"]["text"].'-'.($nightcost['Night']+1).' Night</td>
							<td style="border-bottom: none!important;border-right: none!important;border:1px solid #ccc;padding: 15px;margin: 2px;">'.$xmldata["Currency"].number_format((float) $nightcost["SellingPrice"]["@attributes"]["amt"], 2).'</td>
						</tr>';
						
					}
				 }
				 echo $html;
				 ?>

	 	</tbody>
        </table>
			<table width="100%" cellpadding="0" cellspacing="0" class="tble_bottom" style="padding: 40px 0 10px 0;">
				<tr>
					<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;"><?php echo date('d F', strtotime($booking['start_date'])); ?></span><br><?php echo $booking['check_in']; ?> Onwards</td>
					<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;"><img src="{{ public_path('frontend/hotelier/images/moon.png') }}" alt="" /></span><br><?php echo $booking['nights']; ?> Night</td>
					<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;"><?php echo date('d F', strtotime($booking['end_date'])); ?></span><br>Till <?php echo $booking['check_out']; ?></td>
					<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;"><img src="{{ public_path('frontend/hotelier/images/guest.png') }}" alt="" /></span><br><?php echo $booking['adult_capacity'] + $booking['child_capacity']; ?> Guest</td>
					<td style="text-align: center;font-size: 13px;color:#373737;"><span style="display: block;font-size: 18px;margin: 0 0 4px;color:#000;">1 Room</span><br><?php echo $totalprice; ?> Rooms</td>
				</tr>
			</table>
		</td>
	</tr>
</tbody>
</table>
</center>
</body>
</html>