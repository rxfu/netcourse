@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header text-center bg-primary text-white">
                    <h3 class="md-3 font-weight-normal">请助教输入相关信息</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/apply') }}" aria-label="助教信息录入">
                        @csrf

                        <div class="form-group row">
                            <label for="id" class="col-md-2 col-form-label text-right">工号</label>
                            <div class="col-md-10">
                                <input type="text" id="id" name="id" class="form-control" placeholder="工号" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-right">姓名</label>
                            <div class="col-md-10">
                                <input type="text" id="name" name="name" class="form-control" placeholder="姓名" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="department_id" class="col-md-2 col-form-label text-right">学院</label>
                            <div class="col-md-10">
                                <select name="department_id" id="department_id" class="form-control" required>
                                    <option disabled value="">请选择</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="major" class="col-md-2 col-form-label text-right">专业</label>
                            <div class="col-md-10">
                                <input type="text" id="major" name="major" class="form-control" placeholder="专业">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-2 col-form-label text-right">联系电话</label>
                            <div class="col-md-10">
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="联系电话" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">申请</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('input#id').on('keyup focusout', function() {
        $.ajax({
            url: 'assistant',
            type: 'get',
            dataType: 'json',
            data: {
                id: this.value
            },
            success: function(data) {
                $('#name').val(data.assistant.name);
                $('#department_id').val(data.assistant.department_id);
                $('#major').val(data.assistant.major);
                $('#phone').val(data.assistant.phone);
            }
        })
    });
})
</script>
@endpush
