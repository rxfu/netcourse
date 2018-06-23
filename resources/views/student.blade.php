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

                    <form id="scoreForm" name="scoreForm" action="{{ url('/score') }}" method="post" role="form" onsubmit="return confirm('注意：请检查成绩是否已经录入完毕并且正确，成绩提交后将不可更改！请问确定要提交成绩吗？')">
                        <input type="hidden" name="course" value="{{ $course }}">
                        @csrf

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
                                            @if ($student->is_confirmed || Auth::user()->username === 'admin')
                                                {!! $student->score < 60 ? '<span class="text-danger">' . $student->score . "</span>" : $student->score !!}
                                            @else
                                                <input type="text" id="{{ $student->id }}" name="score" class="form-control" placeholder="{{ $student->name }}" value="{{ $student->score }}">
                                                <small class="form-text text-danger"></small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @if (!$student->is_confirmed && Auth::user()->username !== 'admin')
                                <tfoot>
                                    <tr>
                                        <td colspan="4" style="text-align: center">
                                            <button type="submit" class="btn btn-primary" title="提交">提交</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
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
            $(this).select();
        },
        'change': function() {
            var student = $(this);
            var id = student.attr('id');

            // Use ajax to submit form data
            $.ajax({
                'headers': '{{ csrf_token() }}',
                'url': '{{ url('/score') }}',
                'type': 'post',
                'data': {
                    '_method': 'put',
                    '_token': '{{ csrf_token() }}',
                    'dataType': 'json',
                    'score': student.val(),
                    'id': id,
                    'course': {{ $course }}
                },
                success: function(data) {
                    student.removeClass('border-danger');
                    student.next().text('');
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                    student.addClass('border-danger');
                    student.next().text(errors.errors.score);
                    student.focus().select();
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
