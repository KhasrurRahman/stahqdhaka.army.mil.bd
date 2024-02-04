<div class="newtricker-section">
	<div class="container-fluid">
		<div class="row">
			{{-- @if ($highLightNotice)
				<div class="col-md-2 text-center" style="padding-right: 0">
					<div class="notice-area">
						<a target="_blank" href="{{ route('notice_details',['slug'=>$highLightNotice->slug]) }}" class="notice-alert blink_me">Notice <i class="text-warning fas fa-bullhorn"></i><br><span class="notice-text">{{ $highLightNotice->title }}</span></a>

					</div>
				</div>
			@endif --}}

			<div class="col-md-10 {{ $highLightNotice ? 'col-md-10' : '' }}">
				<marquee behavior="scroll" direction="left"
						 onmouseover="this.stop();"
						 onmouseout="this.start();">
					@foreach($notices as $notice)
						@if ($notice->status == 1)
						<span class="mrq-text elementToFadeInAndOut">
						@if ($notice->link_active == 1)
								<a class="elementToFadeInAndOut" href="{{ route('notice_details',['slug'=>$notice->slug]) }}">{{ $notice->title }}</a>
							@else
								{{ $notice->title }}
							@endif

						</span>
						@endif
					@endforeach
				</marquee>
			</div>
		</div>
	</div>
</div>