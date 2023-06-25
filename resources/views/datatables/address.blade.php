  @if(isset($address))
  <?php $app_address = json_decode($address, true);   ?>
  @endif  
  @if(!empty($app_address['present']['flat'])&&!empty($app_address['present']['house'])&&!empty($app_address['present']['road'])&&!empty($app_address['present']['block'])&&!empty($app_address['present']['area']))
  {{$app_address['present']['flat'].', '.$app_address['present']['house'].', '.$app_address['present']['road'].', '.$app_address['present']['block'].', '.$app_address['present']['area'].'.'}}
  @endif