<div class="text-dark">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="">Tiêu đề SEO: </label>
                <input type="text" name="title_seo" id="title_seo" class="form-control" value="{{ old('title_seo') }}">
                <div class="text-danger" id="message" style="padding-top: 10px;"></div>
            </div>
            <div class="form-group">
                <label for="">Từ khóa SEO: </label>
                <input type="text" name="keyword_seo" class="form-control" value="{{ old('keyword_seo') }}">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Mô tả chi tiết SEO: </label>
                <input type="text" name="des_seo" class="form-control" value="{{ old('des_seo') }}">
            </div>
        </div>
    </div>
</div>