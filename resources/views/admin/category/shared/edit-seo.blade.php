<div class="text-dark">
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="title_seo" class="form-label">Tiêu đề SEO:</label>
                <input type="text" id="title_seo" class="form-control" name="title_seo" value="{{ old('title_seo', $category->title_seo ?? '') }}">
            </div>
            <div class="mb-3 col-xs-12">
                <label for="keyword_seo" class="form-label">Từ khóa SEO:</label>
                <input type="text" id="keyword_seo" class="form-control" name="keyword_seo" value="{{ old('keyword_seo', $category->keyword_seo ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="des_seo" class="form-label">Mô tả chi tiết SEO:</label>
                <input type="text" id="des_seo" class="form-control" name="des_seo" value="{{ old('des_seo', $category->des_seo ?? '') }}">
            </div>
        </div>
    </div>
</div>