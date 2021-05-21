<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Online travel agency</title>
	</head>
	<body>
		<center>
		<table style="border:2px solid #000;; border-spacing: 0px;border-collapse: separate; width:728px; margin: 0 auto;">
			<tbody>
				<tr>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th style="margin: 0 auto;display: block;max-width: 100%;"><a href="{{ URL('/') }}"><img src="{{ asset('frontend/images/fish_header_img.png') }}" alt="" /></a></th>
								</tr>
							</thead>
							<tbody>
								<tr><td style="padding: 5px 20px;">Dear {{ $e_data['first_name'] }},</td></tr>
								<tr><td style="padding: 5px 20px;">We confirm that <strong>{{ $e_data['room'] }} at {{ $e_data['hotel'] }}</strong> has been cancelled by you.</td> </tr>
								<tr><td style="padding: 5px 20px;"> At {{ $e_data['hotel'] }}, you can always expect to be welcomed to a beautiful living space, whether it’s a hotel next door or a far off location. </td></tr>
							<tr style="height: 20px;">&nbsp;</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	</center>
</body>
</html>