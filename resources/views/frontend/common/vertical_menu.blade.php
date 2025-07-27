   <div class="side-menu animate-dropdown outer-bottom-xs">
       <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
       <nav class="yamm megamenu-horizontal">
           <ul class="nav">
               @if ($categories->isNotEmpty())
                   @foreach ($categories as $category)
                       <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                   class="icon"
                                   aria-hidden="true"></i>{{ $category->category_name }}</a>
                           <ul class="dropdown-menu mega-menu">
                               <div class="yamm-content ">
                                   <div class="row">
                                       @foreach ($category->subCategory as $subcategory)
                                           <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                               <a
                                                   href="{{ url('/category/product/' . $subcategory->id . '/' . $subcategory->subcategory_slug) }}">
                                                   <h2 class="title">{{ $subcategory->subcategory_name }}
                                                   </h2>
                                                   <ul class="links">
                                                       @foreach ($subcategory->subSubCategory as $subSub)
                                                           <li><a
                                                                   href="{{ url('/subsubcategory/product/' . $subSub->id . '/' . $subSub->subsubcategory_slug) }}">{{ $subSub->subsubcategory_name }}</a>
                                                           </li>
                                                       @endforeach
                                                   </ul>
                                               </a>
                                           </div>
                                       @endforeach
                                       {{-- <div class="col-xs-12 col-sm-6 col-md-4 col-menu banner-image">
                                           <img class="img-responsive"
                                               src="{{ asset('/frontend/assets/images/banners/top-menu-banner.jpg') }}"
                                               alt="">
                                       </div> --}}
                                   </div>
                               </div>
                           </ul>
                       </li>
                   @endforeach
               @endif
           </ul>
           <!-- /.nav -->
       </nav>
       <!-- /.megamenu-horizontal -->
   </div>

   {{-- <div class="side-menu animate-dropdown outer-bottom-xs">
       <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Layanan</div>
       <nav class="yamm megamenu-horizontal">
           <ul class="nav">

               @php
                   $layanans = App\Models\Layanan::latest()->get();
               @endphp
               @if ($layanans->isNotEmpty())
                   @foreach ($layanans as $layanan)
                       <li class="menu-item"> <a href="#" class=""
                               aria-hidden="false"></i>{{ $layanan->nama_layanan }}</a>
                       </li>
                   @endforeach
               @endif
           </ul>
           <!-- /.nav -->
       </nav>
   </div> --}}
