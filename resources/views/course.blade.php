@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h3 class="md-3 font-weight-normal">{{ $assistant->name }}助教申请课程信息</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/update') }}" role="form">
                        @method('PATCH')
                        @csrf

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">操作</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">课程名称</th>
                                    <th scope="col">班级名称</th>
                                    <th scope="col">QQ群号</th>
                                    <th scope="col">备注</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="id[]" value="{{ $course->id }}"
                                            @if ($course->is_used)
                                                checked disabled
                                            @endif>
                                        </td>
                                        <td><i>{{ $course->id }}</i></td>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->class }}</td>
                                        <td>
                                            <input type="text" name="qqun[]" placeholder="QQ群号（必填项）" class="form-control{{ $errors->has('qqun[]') ? ' is-invalid' : '' }}" value="{{ $course->qqun }}" disabled>

                                            @if ($errors->has('qqun[]'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('qqun[]') }}</strong>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" name="memo[]" placeholder="备注" class="form-control" value="{{ $course->memo }}" disabled>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @unless ($exists)
                                <tfoot>
                                    <tr>
                                        <td colspan="6" align="center">
                                            <button type="submit" class="btn btn-lg btn-primary">提交</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            @endunless
                        </table>
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
    $('input[type="checkbox"]').click(function() {
        var status = false;

        if ($('input[type="checkbox"]:checked').length >= 3) {
            status = true;
        } else {
            status = false;
        }

        $('input[type="checkbox"]').not(':checked').prop('disabled', status);

            if ($(this).is(':checked')) {
                $(this).parent().siblings('td:gt(2)').find(':text').prop('disabled', false);
            } else {
                $(this).parent().siblings('td:gt(2)').find(':text').prop('disabled', true);
            }
    });
})
</script>
@endpush
