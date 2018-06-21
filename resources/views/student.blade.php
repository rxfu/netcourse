@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">学生列表</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">学号</th>
                                <th scope="col">姓名</th>
                                <th scope="col">得分</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $student->card_id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>
                                        <input type="text" name="score" class="form-control" placeholder="{{ $student->name }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2">
                                    <form id="confirmForm" name="confirmForm" action="{{ url('/confirm') }}" method="post" role="form" onsubmit="return confirm('注意：请检查成绩是否已经录入完毕并且正确，成绩提交后将不可更改！请问确定要提交成绩吗？')">
                                        @csrf
                                        <input type="hidden" name="course" value="{{ $course }}">
                                        <button type="submit" class="btn btn-primary" title="提交">提交</button>
                                    </form>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('tr').on({
        'focusin': function() {
            $(this).children('td').css('font-weight', 'bold');
        },
        'focusout': function() {
            $(this).children('td').css('font-weight', 'normal');
        }
    });
    $('td').on({
        'click': function() {
            $(this).children('input').select();
            $(this).select();
        },
        'change': function() {
            var sno = $(this).attr('name').substring(0, 12);
            var id = $(this).attr('name').substring(12, 13);

            // Use ajax to submit form data
            $.ajax({
                'headers': '{{ csrf_token() }}',
                'url': '{{ route('score.update', $course->kcxh) }}',
                'type': 'post',
                'data': {
                    '_method': 'put',
                    '_token': '{{ csrf_token() }}',
                    'dataType': 'json',
                    'score': $(this).val(),
                    'sno': sno,
                    'id': id
                },
                'beforeSend': function() {
                    $('#status' + sno).text('保存中......').addClass('text-warning');
                },
                'success': function(data) {
                    if ($.isNumeric(data)){
                        $('#status' + sno).removeClass();
                        $('#status' + sno).text('保存成功').addClass('text-success');

                        if ({{ config('constants.score.passline') }} > data) {
                            $('tr#' + sno).removeClass('success');
                            $('tr#' + sno).addClass('danger');

                            $('#total' + sno).removeClass();
                            $('#total' + sno).text(data).addClass('text-danger');
                        } else {
                            $('tr#' + sno).removeClass('danger');
                            $('tr#' + sno).addClass('success');

                            $('#total' + sno).removeClass();
                            $('#total' + sno).text(data).addClass('text-success');
                        }
                    } else {
                        $('#status' + sno).removeClass();
                        $('#status' + sno).text('保存失败').addClass('text-danger');
                    }
                }
            })
            .fail(function(jqXHR) {
                if (422 == jqXHR.status) {
                    $.each(jqXHR.responseJSON, function(key, value) {
                        $('#status' + sno).text(value).addClass('text-danger');
                    });
                }
            });
        },
        'keypress': function(e) {
            // Enter pressed
            if (e.keyCode == 13) {
                var inputs = $(this).parents('table').find('input');
                var idx = inputs.index(this);

                if (idx == inputs.length - 1) {
                    inputs[0].select();
                } else {
                    inputs[idx + 1].focus();
                    inputs[idx + 1].select();
                }

                // $(this).closest('form').submit();
                return false;
            }
        }
    }, 'input');
});
</script>
@endpush
