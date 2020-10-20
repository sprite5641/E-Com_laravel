<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($categoryProducts as $product)
            <li class="span3">
                <div class="thumbnail">
                    <a href="{{ url('product/' . $product['id']) }}">
                        @if (isset($product['main_inage']))
                            <?php $product_image_path = 'images/product_images/small/' .
                            $product['main_image']; ?>
                        @else
                            <?php $product_image_path = ''; ?>
                        @endif
                        <?php $product_image_path = 'images/product_images/small/' .
                        $product['main_image']; ?>
                        @if (!empty($product['main_image']) && file_exists($product_image_path))
                            <img style="width: 100px;" src="{{ asset($product_image_path) }}" alt="">
                        @else
                            <img style="width: 300px;" src="{{ asset('images/product_images/small/no-image.png') }}"
                                alt="">
                        @endif
                    </a>
                    <div class="caption">
                        <h5>{{ $product['product_name'] }}</h5>
                        <p>
                            {{ $product['brand']['name'] }}
                        </p>
                        <h4 style="text-align:center"><a class="btn" href="{{ url('product/' . $product['id']) }}"> <i
                                    class="icon-zoom-in"></i></a> <a class="btn" href="#">เพิ่มสินค้า <i
                                    class="icon-shopping-cart"></i></a> <a class="btn btn-primary"
                                href="#">ราคา{{ $product['product_price'] }}</a></h4>

                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <hr class="soft" />
</div>