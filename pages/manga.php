<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Tambah Manga</h3>
            </div>
            <div class="box-body">   
                <div class="col-md-4 col-sm-12">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="link_manga" class="col-sm-1 control-label">Link</label>
                            <div class="col-sm-11">
                                <div class="input-group" id="input_single">
                                    <span class="input-group-addon" id="btn-show-batch"><i class="fas fa-link"></i></span>
                                    <input type="text" class="form-control" id="link_manga" name="link_manga">
                                </div>
                                <textarea name="link_batch" id="link_batch" class="form-control hidden" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-danger hidden" id="btn_batal">BATAL</button>
                                <button class="btn btn-success hidden" id="btn_simpan">SIMPAN</button>
                                <button class="btn btn-primary hidden" id="btn_batch">BATCH</button>
                                <button class="btn btn-primary" id="btn_cek">CEK</button>
                                <button class="btn btn-primary hidden" id="btn_loading" disabled><i class="fas fa-spinner fa-pulse"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="result_cek hidden">
                    <div class="col-md-1 col-sm-12">
                        <img width="120" height="170" class="img" id="img" src="https://komikcast.com/wp-content/uploads/2017/11/b3.jpg">
                    </div>
                    <div class="col-md-7 col-sm-12">
                        <h3 id="judul_manga"></h3>
                        <h4 id="native_title"></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt class="text-left">Genres</dt>
                                    <dd id="genres"></dd>
                                    <dt class="text-left">Release Date</dt>
                                    <dd id="release_date"></dd>
                                    <dt class="text-left">Type</dt>
                                    <dd id="type"></dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt class="text-left">Status</dt>
                                    <dd id="status"></dd>
                                    <dt class="text-left">Author</dt>
                                    <dd id="author"></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-12 col-md-9">
                        <h3 class="box-title">Daftar Manga</h3>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Cari..">
                            <span class="input-group-addon" id="btnSearch"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <div class="row manga-list">                  
                    </div>
                    <div class="row text-center">
                        <button class="btn btn-primary" id="btn-load-more" page='1'>LOAD MORE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalShowManga" tabindex="-1" role="dialog" aria-labelledby="modalShowManga">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body bg-primary">
        <div class="row" id="modal-detail">

        </div>
        <div class="text-center" id="loading-modal">
        <i class="fas fa-spinner fa-pulse fa-3x"></i>
        </div>
      </div>
    </div>
  </div>
</div>