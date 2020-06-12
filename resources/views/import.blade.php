<div class="modal fade" tabindex="-1" role="dialog" id="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-default">
            <div class="modal-header">
                <h5 class="modal-title text-ligth">导入成绩</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" id="import-form" name="import-form" method="post" action="{{ route('import') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="import" class="col-sm-3 col-form-label text-right">成绩文件</label>
                        <div class="col-md-9">
                            <input type="file" name="import" id="import" class="form-control{{ $errors->has('import') ? ' is-invalid' : '' }}" placeholder="成绩文件" accept=".csv,.xls,.xlsx" required>
                            
                            @if ($errors->has('import'))
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('import') }}</strong>
                                </div>
                            @endif
                            <small class="form-text text-light">只允许xls, xlsx, csv格式文件</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button name="cancel" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button name="submit" class="btn btn-primary" id="btn-confirmed">导入</button>
                </div>
        </form>
        </div>
    </div>
</div>