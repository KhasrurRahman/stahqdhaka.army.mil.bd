<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Invoice Details | Dhaka Cantonment Board</title>

  <!-- Bootstrap CSS -->
  <link href="{{url('/assets/cdn')}}/all.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="css/fontawesome-all.css"> -->
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700" rel="stylesheet">
  <link rel="stylesheet" href="{{url('/assets/cdn')}}/bootstrap.min.css">
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="{{asset('/assets/admins/css/style.css')}}">

  <style>
  .card {
    min-height: 211px;
  }

  .divider {
    content: "";
    border-top: 1px dashed #000;
    margin: 10px 0;
  }

  @media print {
    #print-btn {
      display :  none;
    }

    body{
      top:50px;
      background: transparent;
    }
  }

  .print-bwrap {
    position: relative;
  }

  #invoice {
    padding: 60px 15px;
  }

  #invoice .header-info ul {
    display: flex;
    flex-flow: row wrap;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
    padding: 0;
    max-width: 390px;
  }

  #invoice.invoice-print-section .header-info ul li {
    margin: 0 6px;
    padding: 3px 0;
  }

  .invoice-print-section{
    color:#000!important;
    width: 960px;
    font-size: 14px!important;
  }

  .invoice-print-section#invoice .inv_title {
    margin: 11px 0;
    font-weight: bold;
  }

  .invoice-print-section table thead th{      
    color:#000!important;
  }

  .invoice-print-section table thead,.invoice-print-section table th,.invoice-print-section table td{      
    color:#000!important;
  }

  .invoice-print-section .card {
    border: 1px solid #A0A0A0!important;
  }

  .invoice-print-section .card-header {
    border-bottom: 1px solid #A0A0A0!important;
  }

  .invoice-print-section .table-bordered thead td, .invoice-print-section .table-bordered thead th {
    border-bottom-width: 1px!important;
    background: #F7F7F7#important;
  }

  .invoice-print-section .table thead th {
    border-bottom: 1px solid #A0A0A0!important;
    background: #F7F7F7!important;
  }

  .invoice-print-section .table-bordered, .invoice-print-section .table-bordered td, .invoice-print-section .table-bordered th {
    border: 1px solid #A0A0A0!important;
    padding: 6px 10px;
  }

  .invoice-print-section .card-header {
    padding: 8px 10px;
    text-align: center;
    font-weight: bold;
  }

  .invoice-print-section .card-header h4 {
    margin: 0px 0!important;.invoice-print-section 
  }

  .invoice-print-section#invoice .card {
    min-height: 100%;
  }

  .invoice-print-section .card-body {
    padding: 12px;
  }

  .invoice-print-section .card-body p {
    margin-bottom: 3px;
  }

  .invoice-print-section .invoice-print-section h3.pptitle {
    font-size: 25px;
    font-weight: bold;
  }

  .invoice-print-section .invoice-print-section h3.pptitle .header-info ul li {
    font-size: 14px!important;
  }

  .invoice-print-section h4.inv_title, .card-header h4 {
    font-size: 18px!important;
    font-weight: 700;
    padding: 0px;
    margin: 14px 0 10px!important;
  }

  .signatur-powered p {
    width: 50%;
    margin-left: auto;
    font-size: 16px;
    font-weight: 700;
    color: #000; 
    border-bottom: 1px solid #000;
    margin-bottom: 30px;
    padding: 25px 0 5px;
  }

  .water-mark {
    position: relative;
  }

  .water-mark img.water-mark-img {
    position: absolute;
    top: 0;
    right: 50%;
    margin-right: -125px;
    opacity: 0.1;
    width: 300px;
    margin-top: -150px;
  }

  .item-summary-card {
    margin-top: 15px;
    text-align: center;
  }

</style>

</head>
<body >   

  <div class="print-bwrap invoice-print-section container">
    <button onclick="myFunction()" style="position: absolute; top: 75px; right: 15px;" class="btn btn-success" id="print-btn">Print this page</button>
  </div>
  <div class="container invoice-print-section content" id="invoice">
    <div class="row">
      <div class="col-md-3 logo">          
        <img src="{{asset('/assets/images/logo.png')}}" alt="" class="img-fluid pt-3" style="width: 100px;">
      </div>
      <div class="col-md-6 text-center">
        <h3 style="margin-top: 10px;font-weight:700" class="pptitle">Station Headqurters, Dhaka</h3>
        <div class="header-info">
          <ul class="mt-0">
            <li><i class="fas fa-phone-volume" style="transform: rotate(-15deg);"></i> Tel: +880-2-8871234</li>
            <li><i class="fas fa-fax"></i> Fax: +880-2-8713250</li>
            <li><i class="fas fa-map-marker"></i> Shaheed Sharani, Dhaka, Bangladesh</li>
          </ul>
        </div>
        <h4 class="inv_title">Invoice</h4>
      </div>
    </div>

    <div class="row" style="margin-top: 5px;">
      <div class="col-sm-4">
        <div class="card">
          <div class="card-header">
            Billing To
          </div>
          <div class="card-body">
            <p>Name: {{$invoice->application->applicant->name}}</p> <span> </span>
            <p>Phone: {{$invoice->application->applicant->phone}} </p> <span></span>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-header">
            Application Details
          </div>
          <div class="card-body">
            <p>Application Number: {{$invoice->application->app_number}} </p> <span></span>
            <p>Sticker Category: {{$invoice->stickerCategory->value}}</p> <span></span>
            <p>Vehicle Type: {{$invoice->vehicleType->name}} </p> <span></span>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-header">
            Invoice Information
          </div>
          <div class="card-body">
            <p>Invoice Number: {{$invoice->number}} </p> <span></span>
            <p>Date of Invoice: {{Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y')}} </p> <span></span>
            <p>Created By: {{$invoice->collector}} </p> <span></span>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-top: 10px;">
      <div class="col-md-12">
        <div class="card item-summary-card">
          <div class="card-header">
            <h4 style="text-align: center;font-size: 22px;margin: 0;">Item Summary</h4>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead style="color:#fff;">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Sticker No</th>
                  <th scope="col">Amount (TK)</th>
                  <th scope="col">Discount (TK)</th>
                  <th scope="col">Total Amount (TK)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>1</th>
                  <td>{{$invoice->vehicleSticker->sticker_number}}</td>
                  <td>{{$invoice->amount}}</td>
                  <td>{{!empty($invoice->discount)?$invoice->discount:''}}</td>
                  <th>{{$invoice->net_amount}}</th>
                </tr>
                <!-- load table rows <tr> from db -->
                </tbody>
              </table>
            </div>
          </div>
        </div>        
      </div>

      <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
          <div class="signatur-powered">            
            <p>Authorised Signatory</p>
            <div class="pwrdby text-right" style="font-size:12px;">Powered By IT Dte, GS Br, AHQ</div>
          </div>

        </div>        
      </div>
    </div>

    <div class="container invoice-print-section water-mark divider-p" style="height: 1px;">
      <div class="divider"></div>
      <img src="{{asset('/assets/images/logo.png')}}" alt="" class="water-mark-img">
    </div>
    <div id="empty">
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{url('/assets/cdn')}}/jquery-3.6.0.min.js"></script>
    <script src="{{url('/assets/cdn')}}/popper.min.js"></script>
    <script src="{{url('/assets/cdn')}}/bootstrap.min.js"></script>
    <script>
      var prin = document.getElementsByClassName("content")[0];
      var body = document.getElementsByTagName("body")[0];

      function myFunction() {
        $(prin).clone().appendTo("#empty");
        window.print();
        location.reload();
      }
    </script>
  </body>
</html>
