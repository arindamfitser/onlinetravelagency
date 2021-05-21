<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo get_option('blogname') ?>::Welcome mail</title>
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
								<tr><td style="padding: 5px 20px;">Hi {{ $e_data['first_name'] }} , </td></tr>
								<tr><td style="padding: 5px 20px;">Your new <?php echo get_option('blogname') ?> Account has been created, Welcome to <?php echo get_option('blogname') ?><strong></td><tr>
								<tr><td style="padding: 5px 20px;">Email: <strong>{{ $e_data['email'] }}</td><tr>
								<tr><td style="padding: 5px 20px;">Password: <strong>{{ $e_data['password'] }}</td><tr>	
								<tr><td style="padding: 5px 20px;">please click the button below to login with your <?php echo get_option('blogname') ?> account</td><tr>							
							<tr style="height: 20px;">&nbsp;</tr>
						</tbody>
					</table>
					<table style="width: 100%; border: none; border-spacing: 0px;border-collapse: separate; width:100%;">
<tbody><tr style="padding-top:0;">
              <td style="text-align: center;vertical-align: top;">
                 <table style="border: none; border-spacing: 0px;border-collapse: separate; width:100%; background-color: #fff;padding: 10px 20px;">
                  <tbody><tr>
                    <td>&nbsp;</td>
                    <td style="padding-top:0; text-align: right;vertical-align: middle;width: 161px;"><table style="border:none; border-spacing: 0px;border-collapse: separate; background-color: #d7b956; width: 140px;">
                        <tbody><tr>
                          <td style="padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px; text-align: center; vertical-align: middle;"><a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:135%;" href="{{URL('login')}}" target="_blank">Login</a></td>
                        </tr>
                      </tbody></table></td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody></table></td>
            </tr>
          </tbody>
          </table>
				</td>
			</tr>
		</tbody>
	</table>
	</center>
</body>
</html>