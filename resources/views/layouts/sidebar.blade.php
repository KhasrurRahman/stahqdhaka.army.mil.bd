                <div class="col-lg-3 col-md-4 front-sidebarwidget">

                    <!-- widget -->
                    <div class="widget left-widget">                                                   
                        <h3 class="widget-title"><i class="fa fa-bell"></i> Notice</h3>
                        <ul class="widget-menu"> 
                           @foreach ($pdf_files as $pdf_file)
                                @if ($pdf_file->type == 'notice')
                                    <li><a href="{{asset('assets/pdf_files/'.$pdf_file->file)}}" target="_blank"><i class="fa fa-external-link-alt"></i> {{ $pdf_file->name  }}</a></li>
                                @endif
                            @endforeach
                        </ul> 
                    </div>

                    <!-- widget -->
                    <div class="widget left-widget">                                                   
                        <h3 class="widget-title"><i class="fa fa-newspaper"></i> News & Events</h3>
                        <ul class="widget-menu">
                            @foreach ($pdf_files as $pdf_file)
                                @if ($pdf_file->type == 'news_events')
                                    <li><a href="{{asset('assets/pdf_files/'.$pdf_file->file)}}" target="_blank"><i class="fa fa-external-link-alt"></i> {{ $pdf_file->name  }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <!-- widget -->
                    <div class="widget left-widget">                                                   
                        <h3 class="widget-title"><i class="fa fa-pen-square"></i> Forms</h3>
                        <ul class="widget-menu">
                             @foreach ($pdf_files as $pdf_file)
                                @if ($pdf_file->type == 'forms')
                                    <li><a href="{{asset('assets/pdf_files/'.$pdf_file->file)}}" target="_blank"><i class="fa fa-external-link-alt"></i> {{ $pdf_file->name  }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div> 

                    <!-- widget -->
                    <div class="widget left-widget">                                                   
                        <h3 class="widget-title"><i class="fa fa-gavel"></i> Policy</h3>
                        <ul class="widget-menu">
                            @foreach ($pdf_files as $pdf_file)
                                @if ($pdf_file->type == 'policy')
                                    <li><a href="{{asset('assets/pdf_files/'.$pdf_file->file)}}" target="_blank"><i class="fa fa-external-link-alt"></i> {{ $pdf_file->name  }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>  
                </div>