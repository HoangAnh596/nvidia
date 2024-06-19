<div class="text-dark">
    <div class="form-row">
        <div class="col-8">
            <div class="mb-3">
                <label for="title_pr_images" class="form-label">Thẻ Title</label>
                <input type="text" id="title_pr_images" class="form-control" name="title_pr_images">
                <span id="name-error" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="alt_pr_images" class="form-label">Thẻ Alt</label>
                <input type="text" id="alt_pr_images" class="form-control" name="alt_pr_images">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div style="margin-top: 1rem;">(Kích thước đề nghị 400 x 400 px)</div>
            <div class="input-group">
                <input class="hiddenPrImages py-1" type="file" name="pr_image_ids" id="prImages" accept="image/*">
                <input id="thumbnailPrImages" class="form-control" type="hidden" name="filepathPrImages">
                <button class="btn btn-outline-dark" id="uploadBtnPrImages" style="margin-right: 1rem;" onclick="uploadImgChild()">Upload</button>
                <span class="input-group-btn">
                    <button id="lfm-prImages" data-input="thumbnailPrImages" data-preview="image-holder" class="btn btn-outline-dark hiddenBtnPrImages">
                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                    </button>
                </span>
            </div>
            <div id="image-holder"></div>
            <div id="pr">
                <img id="pr-image" src="#" alt="your image" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="">No.</th>
                            <th class="col-sm-3">Ảnh</th>
                            <th class="col-sm-3">Thẻ title</th>
                            <th class="col-sm-3">Thẻ Alt</th>
                            <th class="col-sm-1">Thứ tự</th>
                            <th class="">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>
                                <img src="" class="img-fluid">
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="" class="btn-sm">Xóa</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav class="float-right">
                </nav>
            </div>
        </div>
    </div>
</div>