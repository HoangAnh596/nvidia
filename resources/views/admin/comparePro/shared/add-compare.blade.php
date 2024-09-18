@if (!empty($compareCate))
    @foreach($compareCate as $val)
        <div class="col"><h4>{{ $val->name }}</h4></div>
        <div class="mt-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-sm-3 text-center">Tên giá trị so sánh</th>
                            <th class="col-sm-6 text-center">Giá trị hiển thị</th>
                            <th class="col-sm-3 text-center">Giá trị so sánh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($compareProducts->get($val->id, []) as $item)
                            <tr>
                                <td class="key-word">{{ $item->key_word }}</td>
                                <td>
                                    <textarea name="display_compare[]" rows="1" style="width: 100%; overflow: hidden" oninput="autoResize(this)">{{ $item->display_compare }}</textarea>
                                </td>
                                <td>
                                    <input type="text" name="value_compare[]" value="{{ $item->value_compare }}" class="border-compare">
                                </td>
                                <!-- Input hidden để lưu compare_id -->
                                <input type="hidden" name="compare_id[]" value="{{ $item->compare_id }}">
                                <input type="hidden" name="compare_cate_id[]" value="{{ $item->compare_cate_id }}">
                            </tr>
                        @empty
                        @foreach($val->valueCompares as $data)
                            <tr>
                                <td class="key-word">{{ $data->key_word }}</td>
                                <td>
                                    <textarea name="display_compare[]" rows="1" style="width: 100%; overflow: hidden" oninput="autoResize(this)"></textarea>
                                </td>
                                <td>
                                    <input type="text" name="value_compare[]" value="" class="border-compare">
                                </td>
                                <!-- Input hidden để lưu compare_id -->
                                <input type="hidden" name="compare_id[]" value="{{ $data->id }}">
                                <input type="hidden" name="compare_cate_id[]" value="{{ $val->id }}">
                            </tr>
                            @endforeach
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@elseif (empty($compareCate))
    <div class="col">Chưa có danh mục bộ lọc! Ấn vào <a href="{{ asset('admin/products/'.$products->id.'/edit') }}">link</a> để thêm danh mục sản phẩm</div>
@endif
