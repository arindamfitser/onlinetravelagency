<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Online travel agency::Contact mail</title>
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
								<tr><td style="padding: 5px 20px;">Hi  Query from {{ $e_data['first_name'] }} ,</td></tr>
								<tr><td style="padding: 5px 20px;">Name: <strong>{{ $e_data['first_name'] }} {{ $e_data['last_name'] }}</td><tr>
								<tr><td style="padding: 5px 20px;">Email: <strong>{{ $e_data['email'] }}</td><tr>
								<tr><td style="padding: 5px 20px;">Contact: <strong>{{ $e_data['contact'] }}</td><tr>
								<tr><td style="padding: 5px 20px;">Subject: <strong>{{ $e_data['subject'] }}</td><tr>
								<tr><td style="padding: 5px 20px;">{{ $e_data['body'] }}</td></tr>
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