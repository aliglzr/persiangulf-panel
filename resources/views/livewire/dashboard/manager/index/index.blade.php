<div class="container-xxl">
    <a onclick="test()" class="btn btn-primary">DO</a>
</div>

@section('title')
    پیشخان
@endsection
@section('description')
    پیشخان کنترل پنل
@endsection
@push('scripts')
    <script>
        var test = null;
        var connection = new WebSocket('ws://127.0.0.1:8080');
        connection.onopen = function () {
            var i = 0;
            while (true) {
                i++;
                if(i == 100000) {
                    connection.send(Date.now());
                    i = 0;
                }
            }
         test = function () {
            console.log("sdfsdfd");

                connection.send(Date.now()); // Send the message 'Ping' to the server

        }};
    </script>
@endpush
