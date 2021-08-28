<html lang="grg">
<head>

    <title>12314</title></head>
<body>
<p>1.</p>
@extends('layout.test')

{{--@section('title', '<p>têtstestset.</p>')--}}
<p>2.</p>
@section('sidebar')
    @parent

    <p>Phần phụ của sidebar.</p>
@endsection

@section('content')
    <p>Phần nội dung chính của trang ở đây.</p>
@endsection
</body>
</html>
