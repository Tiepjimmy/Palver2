<table>
    <thead>
    <tr>
        <th>STT</th>
        <th>Tên sản phẩm</th>
        <th>Mã sản phẩm</th>
        <th>Loại sản phẩm</th>
        <th>Nhóm sản phẩm</th>
        <th>Khối lượng</th>
        <th>Đơn vị</th>
        <th>Giá bán lẻ</th>
        <th>Giá bán buôn</th>
        <th>Giá bán vốn</th>
        <th>Cho phép kinh doanh</th>
        <th>Áp dụng thuế</th>
    </tr>
    </thead>
    <tbody>
        @foreach($product as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item['product_name'] }}</td>
                <td>{{ $item['product_cd'] }}</td>
                <td>{{ $item['product_catalog']['product_catalog_name'] }}</td>
                <td>{{ $item['product_type'] }}</td>
                <td>{{ $item['quantity'] . $item['volume_unit']['volume_unit_cd'] }}</td>
                <td>{{ $item['unit'] }}</td>
                <td>
                    @if(isset($item['retail_product_entities']))
                        {{ isset($item['retail_product_entities'][0]) ? $item['retail_product_entities'][0]['retail_entity_price']['old_prices'] : 0 }}
                    @else
                        {{ isset($item['product_entities'][0]) ? $item['product_entities'][0]['entity_prices']['old_prices'] : 0 }}
                    @endif
                </td>
                <td>
                    @if(isset($item['retail_product_entities']))
                        {{ isset($item['retail_product_entities'][0]) ? $item['retail_product_entities'][0]['retail_entity_price']['old_wholesale_prices'] : 0 }}
                    @else
                        {{ isset($item['product_entities'][0]) ? $item['product_entities'][0]['entity_prices']['old_wholesale_prices'] : 0 }}
                    @endif
                </td>
                <td>
                    @if(isset($item['retail_product_entities']))
                        {{ isset($item['retail_product_entities'][0]) ? $item['retail_product_entities'][0]['retail_entity_price']['old_cost_prices'] : 0 }}
                    @else
                        {{ isset($item['product_entities'][0]) ? $item['product_entities'][0]['entity_prices']['old_cost_prices'] : 0 }}
                    @endif
                </td>
                <td>{{ $item['is_sales'] }}</td>
                <td>{{ $item['is_enable_tax'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>