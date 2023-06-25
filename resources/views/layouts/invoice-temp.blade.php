 @if(isset($applicant_details))
            @foreach($applicant_details as $key => $applicant_detail)
            @foreach($applicant_detail->applicant->applications as $key => $app)
            <tr>
              <th scope="row">{{$sl}}</th>
              <td><a href="{{url('/application-review')}}/{{$app->app_number}}">{{$app->applicant->name}}</a><br>
                {{ isset($app->applicant->applicantDetail->nid_number) ? $app->applicant->applicantDetail->nid_number : '-' }}
              </td>
              <td>
                {{ isset($app->applicant->applicantDetail->applicant_BA_no) ? $app->applicant->applicantDetail->applicant_BA_no : '-' }}
              </td>
              <td>
                {{ isset($app->applicant->applicantDetail->rank_id) ? $app->applicant->applicantDetail->rank->name : '-' }}
              </td>
              <td>{{$app->applicant->phone}} </td>
              <td>
                @if(isset($app->applicant->applicantDetail->address))
                <?php $app_address = json_decode($app->applicant->applicantDetail->address, true);   ?>
                @endif  

                @if(!empty($app_address['present']['flat'])&&!empty($app_address['present']['house'])&&!empty($app_address['present']['road'])&&!empty($app_address['present']['block'])&&!empty($app_address['present']['area']))
                {{$app_address['present']['flat'].', '.$app_address['present']['house'].', '.$app_address['present']['road'].', '.$app_address['present']['block'].', '.$app_address['present']['area'].'.'}}
                @endif
              </td>
              <td>{{$app->app_date}}</td>
              <td>{{$app->vehicleinfo->vehicleType->name}}</td>
              <td>{{$app->vehicleinfo->reg_number}}</td>
              <td>{{$app->app_status}}</td>
            </tr>
            <?php $sl++; ?>
            @endforeach
            @endforeach
            @endif
            @if(isset($applicants))
            @foreach($applicants as $key => $applicant)
            @foreach($applicant->applications as $key => $app)
            <tr>
              <th scope="row">{{$sl}}</th>
              <td><a href="{{url('/application-review')}}/{{$app->app_number}}">{{$app->applicant->name}}</a><br>
                {{ isset($app->applicant->applicantDetail->nid_number) ? $app->applicant->applicantDetail->nid_number : '-' }}
              </td>
              <td>
                {{ isset($app->applicant->applicantDetail->applicant_BA_no) ? $app->applicant->applicantDetail->applicant_BA_no : '-' }}
              </td>
              <td>
                {{ isset($app->applicant->applicantDetail->rank_id) ? $app->applicant->applicantDetail->rank->name : '-' }}
              </td>
              <td>{{$app->applicant->phone}} </td>
              <td>
                @if(isset($app->applicant->applicantDetail->address))
                <?php $app_address = json_decode($app->applicant->applicantDetail->address, true);   ?>
                @endif  
                @if(!empty($app_address['present']['flat'])&&!empty($app_address['present']['house'])&&!empty($app_address['present']['road'])&&!empty($app_address['present']['block'])&&!empty($app_address['present']['area']))
                {{$app_address['present']['flat'].', '.$app_address['present']['house'].', '.$app_address['present']['road'].', '.$app_address['present']['block'].', '.$app_address['present']['area'].'.'}}
                @endif
              </td>
              <td>{{$app->app_date}}</td>
              <td>{{$app->vehicleinfo->vehicleType->name}}</td>
              <td>{{$app->vehicleinfo->reg_number}}</td>
              <td>{{$app->app_status}}</td>
            </tr>
            <?php $sl++; ?>
            @endforeach
            @endforeach
            @endif

            @if(isset($stickers) && $stickers !='' )
            <tr>
              <th scope="row">{{$sl}}</th>
              <td><a href="{{url('/application-review')}}/{{$stickers->application->app_number}}">{{$stickers->application->applicant->name}}</a><br>
                {{ isset($stickers->application->applicant->applicantDetail->nid_number) ? $stickers->application->applicant->applicantDetail->nid_number : '-' }}
              </td>
              <td>
                {{ isset($stickers->application->applicant->applicantDetail->applicant_BA_no) ? $stickers->application->applicant->applicantDetail->applicant_BA_no : '-' }}
              </td>
              <td>
                {{ isset($stickers->application->applicant->applicantDetail->rank_id) ? $stickers->application->applicant->applicantDetail->rank->name : '-' }}
              </td>
              <td>{{$stickers->application->applicant->phone}}</td>
              <td>
                @if(isset($stickers->application->applicant->applicantDetail->address))
                <?php $app_address = json_decode($stickers->application->applicant->applicantDetail->address, true);   ?>
                @endif  

                @if(!empty($app_address['present']['flat'])&&!empty($app_address['present']['house'])&&!empty($app_address['present']['road'])&&!empty($app_address['present']['block'])&&!empty($app_address['present']['area']))
                {{$app_address['present']['flat'].', '.$app_address['present']['house'].', '.$app_address['present']['road'].', '.$app_address['present']['block'].', '.$app_address['present']['area'].'.'}}
                @endif
              </td>
              <td>{{$stickers->application->app_date}}</td>
              <td>{{$stickers->application->vehicleType->name}}</td>
              <td>{{$stickers->reg_number}}</td>
              <td>{{$stickers->application->app_status}}</td>
            </tr>
            <?php $sl++; ?>
            @endif

            @if(isset($vehicles))
            @foreach($vehicles as $key => $vehicle)
            <tr>
              <th scope="row">{{$sl}}</th>
              <td><a href="{{url('/application-review')}}/{{$vehicle->application->app_number}}">{{$vehicle->application->applicant->name}}</a><br>
                {{ isset($vehicle->application->applicant->applicantDetail->nid_number) ? $vehicle->application->applicant->applicantDetail->nid_number : '-' }}
              </td>
              <td>
                {{ isset($vehicle->application->applicant->applicantDetail->applicant_BA_no) ? $vehicle->application->applicant->applicantDetail->applicant_BA_no : '-' }}
              </td>
              <td>
                {{ isset($vehicle->application->applicant->applicantDetail->rank_id) ? $vehicle->application->applicant->applicantDetail->rank->name : '-' }}
              </td>
              <td>{{$vehicle->application->applicant->phone}}</td>
              <td>
                @if(isset($vehicle->application->applicant->applicantDetail->address))
                <?php $app_address = json_decode($vehicle->application->applicant->applicantDetail->address, true);   ?>
                @endif  

                @if(!empty($app_address['present']['flat'])&&!empty($app_address['present']['house'])&&!empty($app_address['present']['road'])&&!empty($app_address['present']['block'])&&!empty($app_address['present']['area']))
                {{$app_address['present']['flat'].', '.$app_address['present']['house'].', '.$app_address['present']['road'].', '.$app_address['present']['block'].', '.$app_address['present']['area'].'.'}}
                @endif
              </td>
              <td>{{$vehicle->application->app_date}}</td>
              <td>{{$vehicle->vehicleType->name}}</td>
              <td>{{$vehicle->reg_number}}</td>
              <td>{{$vehicle->application->app_status}}</td>
            </tr>
            <?php $sl++; ?>
            @endforeach
            @endif