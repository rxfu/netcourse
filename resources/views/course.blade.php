@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                        @csrf
                        @method('PUT')

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">操作</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">课程名称</th>
                                    <th scope="col">班级名称</th>
                                    <th scope="col">学生人数</th>
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
                                        <td>{{ $course->stucount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button type="submit" class="btn btn-block btn-primary">提交</button>
                                    </td>
                                </tr>
                            </tfoot>
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
    $('input').click(function() {
        var status = false;

        if ($('input:checked').length >= 3) {
            status = true;
        } else {
            status = false;
        }

        $('input').not(':checked').prop('disabled', status);
    })
})
</script>
@endpush
