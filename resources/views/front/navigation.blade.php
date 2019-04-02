<div id="navigation" class="wrapper">
    <!--Branding & Navigation Region-->
    <div class="navbar navbar-fixed-top" id="top">
        <div class="navbar-inner">
            <div class="inner">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle btn btn-navbar" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                        <a class="navbar-brand" href="#" title="Home">
                            <h1>
                                Kurs PHP
                            </h1>
                            <span>Cubes School</span> 
                        </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-right" id="main-menu">
                            <li>
                                <a href="{{url('/')}}">Home</a>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-barcode"></i> Products</a>
                                <!-- Dropdown Menu -->
                                <ul class="dropdown-menu" role="menu" aria-labelledby="portfolio-drop">
                                    <li role="menuitem"><a href="{{url('/products')}}" tabindex="-1">All Products</a></li>
                                    <li role="menuitem"><a href="{{url('/products/on-sale')}}" tabindex="-1">On Sale</a></li>

                                    @foreach(\App\Models\ProductCategory::all() as $productCategory)
                                    <li role="menuitem">
                                        <a href="{{url('/products/category/' . $productCategory->id)}}" tabindex="-1">
                                            {{$productCategory->title}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-barcode"></i> Static Pages</a>
                                <!-- Dropdown Menu -->
                                <ul class="dropdown-menu" role="menu" aria-labelledby="portfolio-drop">
                                    @foreach(\App\Models\StaticPage::where('status', \App\Models\StaticPage::STATUS_ENABLED)
                                                ->where('id', '!=', 1)
                                                ->where('parent_id', 0)
                                                ->get() as $staticPage)
                                    <li role="menuitem">
                                        <a href="{{ route('static.page', ['id' => $staticPage->id])}}" tabindex="-1">
                                            {{$staticPage->short_title}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>

                            <li>
                                <a href="{{route('static.page', ['id' => 1])}}">About Us</a>
                            </li>
                            <li>
                                <a href="{{route('contact-us')}}">Contact Us</a>
                            </li>
                            <li>
                                <a href="{{route('login')}}">Login</a>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
    </div>
</div>