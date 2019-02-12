<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin Free Bootstrap Admin Dashboard Template</title>
  <!-- plugins:css -->
    @yield('link')
     <link rel="stylesheet" href="/css/chosen.css">
  <link rel="stylesheet" href="{{asset('backend/vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('backend/vendors/css/vendor.bundle.addons.css')}}">
   

    <link rel="stylesheet" href="{{asset('backend/vendors/iconfonts/font-awesome/css/font-awesome.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
    @yield('css')
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{asset('backend/css/style.css')}}">

<link rel="stylesheet" href="{{asset('backend/css/custom.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('backend/images/favicon.png')}}" />
</head>

<body>



  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('backend.nav_hr')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      @include('backend.nav')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row purchace-popup">
            <div class="col-12">
     @if(session()->has('notif'))     
     <div class="row">
     <div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true" >&times;
     </button>
     <strong>Notifiaction</strong> {{session()->get('notif')}}
     </div>
     </div>  
     @endif
  @if($errors->all())

<ul style="list-style-type:none">    

    @foreach($errors->all() as $error)

    <li class="alert alert-danger">

        {{ $error }}
    </li>        

    @endforeach

    </ul>

@endif 

    <div class="card">
             
    @yield('content')
</div>


            </div>
          </div>
       
        

   


        </div>
       
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
 
  
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
 
  
  <!-- endinject -->
  <!-- Custom js for this page-->
 
  <!-- End custom js for this page-->
</body>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="{{asset('backend/vendors/js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('backend/vendors/js/vendor.bundle.addons.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> 
  <!-- inject:js -->
  <script src="{{asset('backend/js/off-canvas.js')}}"></script>
  <script src="{{asset('backend/js/misc.js')}}"></script>
  <!-- endinject -->
    <script src="{{asset('/js/chosen.jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/init.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
   
  <!-- Custom js for this page-->
  <script src="{{asset('backend/js/dashboard.js')}}"></script>
   @yield('js')
</html>