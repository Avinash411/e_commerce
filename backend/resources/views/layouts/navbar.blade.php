<nav class="navbar navbar-expand-lg navbar-light bg-light">
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Category
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{route('get:ProductsCategoryController:create')}}">Create</a>
          <a class="dropdown-item" href="{{route('get:ProductsCategoryController:show')}}">Show</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{route('get:ProductsCategoryController:DeletedDataShow')}}">Restore</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Brand
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{route('get:BrandController:create')}}">Create</a>
          <a class="dropdown-item" href="{{route('get:BrandController:show')}}">Show</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{route('get:BrandController:DeletedDataShow')}}">Restore</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Variants
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{route('get:VariantController:create')}}">Create</a>
          <a class="dropdown-item" href="{{route('get:VariantController:show')}}">Show</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{route('get:VariantController:DeleteData')}}">Restore</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Variant Value
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{route('get:VariantValueController:create')}}">Create</a>
          <a class="dropdown-item" href="{{route('get:VariantValueController:show')}}">Show</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{route ('get:VariantValueController:DeleteData')}}">Restore</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Product
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{route('get:ProductController:create')}}">Create</a>
          <a class="dropdown-item" href="{{route('get:ProductController:show')}}">Show</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{route('get:ProductController:DeletedDataShow')}}">Restore</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Offers
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{route('get:CategoryOfferController:create')}}">Category Offer Create</a>
          <a class="dropdown-item" href="{{route('get:CategoryOfferController:show')}}">Category Offer Show</a>
          <a class="dropdown-item" href="{{route('get:CategoryOfferController:DeletedDataShow')}}">Restore</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{route('get:ProductOfferController:create')}}">Product Offer Create</a>
          <a class="dropdown-item" href="{{route('get:ProductOfferController:show')}}">Product Offer Show</a>
          <a class="dropdown-item" href="{{route('get:ProductOfferController:DeletedDataShow')}}">Restore</a>
        </div>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
    </ul>
    
  </div>
</nav>