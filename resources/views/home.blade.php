@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">课程列表</div>

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
                                <th scope="col">课程名称</th>
                                <th scope="col">所在班级</th>
                                <th scope="col">状态</th>
                                <th scope="col">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->class }}</td>
                                    <td>{{ App\Score::whereCourseId($course->id)->whereIsConfirmed(false)->exists() ? '未提交' : '已提交' }}</td>
                                    <td>
                                        <a href="{{ route('student', $course->id) }}">
                                            {{ Auth::user()->username === 'admin' ? '查看' : '登分' }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
