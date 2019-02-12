 <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="profile-image">
                  <img src="/backend/images/faces/face1.jpg" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name">Richard V.Welsh</p>
                  <div>
                    <small class="designation text-muted">Manager</small>
                    <span class="status-indicator online"></span>
                  </div>
                </div>
              </div>
             
            </div>
          </li>  
          <li class="nav-item">
            <a class="nav-link" href="index.html">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Category</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:ProductsCategoryController:create')}}">Create</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:ProductsCategoryController:show')}}">Show</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="{{route('get:ProductsCategoryController:DeletedDataShow')}}">Restore</a>
                </li>
              </ul>
            </div>
          </li>

        


         


<li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#brand" aria-expanded="false" aria-controls="brand">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Brand</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="brand">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:BrandController:create')}}">Create</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:BrandController:show')}}">Show</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="{{route('get:BrandController:DeletedDataShow')}}">Restore</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#variant_menu_options" aria-expanded="false" aria-controls="variant">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Variants</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="variant_menu_options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:VariantController:create')}}">Create</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:VariantController:show')}}">Show</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="{{route('get:VariantController:DeleteData')}}">Restore</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#value" aria-expanded="false" aria-controls="value">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Variant Value</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="value">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:VariantValueController:create')}}">Create</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:VariantValueController:show')}}">Show</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="{{route ('get:VariantValueController:DeleteData')}}">Restore</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#product" aria-expanded="false" aria-controls="product">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Product</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="product">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:ProductController:create')}}">Create</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:ProductController:show')}}">Show</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="{{route('get:ProductController:DeletedDataShow')}}">Restore</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#offer" aria-expanded="false" aria-controls="offer">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">offers</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="offer">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:CategoryOfferController:create')}}">Category Offer Create</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:CategoryOfferController:show')}}">Category Offer Show</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="{{route('get:CategoryOfferController:DeletedDataShow')}}">Restore</a>
                </li>
                <hr>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:ProductOfferController:create')}}">Product Offer Create</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('get:ProductOfferController:show')}}">Product Offer Show</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="{{route('get:ProductOfferController:DeletedDataShow')}}">Restore</a>
                </li>
              </ul>
            </div>
          </li>

         
         
         
        </ul>
      </nav>